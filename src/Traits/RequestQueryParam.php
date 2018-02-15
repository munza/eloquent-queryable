<?php

namespace Munza\EloquentQueryable\Traits;

trait RequestQueryable
{
    /**
     * {@inheritdoc}
     */
    public function newQuery()
    {
        $queryParams = $this->getQueryParams();
        $newQuery = parent::newQuery();

        foreach ($queryParams as $queryParam => $args) {
            foreach(config('eloquent-queryable.query_prefix') as $key => $value) {
                if (starts_with($queryParam, $value)) {
                    $this->addQueryCondition($newQuery, $queryParam, $args, $key);
                }
            }
        }

        return $newQuery;
    }

    /**
     * Add a basic query condition to the query builder.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param array                                 $queryParam
     * @param array                                 $args
     * @param string                                $queryKey
     */
    private function addQueryCondition($query, $queryParam, $args, $queryKey)
    {
        switch ($queryKey) {
            case 'where':
                $this->addWhereQuery($query, $queryParam, $args);
                break;

            case 'or_where':
                $this->addWhereQuery($query, $queryParam, $args, true);
                break;

            default:
                // dd($args);
                foreach ($args as $arg) {
                    if ($this->isQueryable($arg)) {
                        $query->{camel_case($queryKey)}(...$arg);
                    }
                }
                break;
        }
    }

    /**
     * Get the where query condition from the query params.
     *
     * @param  array $queryParam
     * @return array
     */
    private function getWhereQueryCondition($queryParam, $or = false)
    {
        $whereType = $or
            ? config('eloquent-queryable.query_prefix.or_where')
            : config('eloquent-queryable.query_prefix.where');

        list($match, $comparator, $wrapper) = [null, null, null];

        foreach (config('eloquent-queryable.query_postfix') as $key => $value) {
            if (ends_with($queryParam, $value)) {
                preg_match("/^{$whereType}_(.*?)_{$value}$/", $queryParam, $match);
                list($comparator, $wrapper) = $this->getComparatorAndWrapperFor($key);
                break;
            }
        }

        return [$match ? $match[1] : null, $comparator, $wrapper];
    }

    /**
     * Get the comparator and wrapper for a postfix key.
     *
     * @param  string $key
     * @return array
     */
    private function getComparatorAndWrapperFor($key)
    {
        $key_to_comparator_wrapper_map = [
            'not_starts_with' => ['not like', ['', '%']],
            'starts_with'     => ['like',     ['', '%']],
            'not_ends_with'   => ['not like', ['%', '']],
            'ends_with'       => ['like',     ['%', '']],
            'not_contains'    => ['not like', ['%', '%']],
            'contains'        => ['like',     ['%', '%']],
            'greater_than'    => ['>',        ['', '']],
            'lower_than'      => ['<',        ['', '']],
            'equals_to'       => ['=',        ['', '']],
            'not_equal'       => ['<>',       ['', '']],
            'not_in'          => [null,       null],
            'in'              => [null,       null],
            'not_between'     => [null,       null],
            'between'         => [null,       null],
        ];

        return array_key_exists($key, $key_to_comparator_wrapper_map)
            ? $key_to_comparator_wrapper_map[$key]
            : [null, null];
    }

    /**
     * Add where condition in the query pipeline.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param array                                 $queryParam
     * @param array                                 $args
     * @param boolean                               $or
     */
    private function addWhereQuery($query, $queryParam, $args, $or = false)
    {
        list($field, $comparator, $argsWrapper) = $this->getWhereQueryCondition($queryParam, $or);

        if (!$this->isQueryable($field)) {
            return;
        }

        // For where query conditions with comparator
        if ($field && $comparator && is_array($argsWrapper)) {
            $query->{$or ? 'orWhere' : 'where'}(
                $field,
                $comparator,
                $argsWrapper[0].$args[0][0].$argsWrapper[1]
            );
        }

        // For where in and between query conditions
        if ($field && !$comparator && !is_array($argsWrapper)) {
            foreach (['not_in', 'in', 'not_between', 'between'] as $key) {
                if (ends_with($queryParam, $key)) {
                    $where = ($or ? 'orWhere' : 'where')
                        .(starts_with($key, 'not_') ? 'Not' : '')
                        .studly_case(str_replace('not_', '', $key));

                    $query->{$where}($field, $args[0]);
                    break;
                }
            }
        }
    }

    /**
     * Get the query string from the url
     * and return a formatted array.
     *
     * @return array
     */
    private function getQueryParams()
    {
        $queryParams = config('eloquent-queryable.key_prefix')
            ? app('request')->get(config('eloquent-queryable.key_prefix'))
            : app('request')->all();

        if (is_null($queryParams)) return [];

        foreach ($queryParams as $queryParam => $value) {
            if ($this->isParsable($value)) {
                $queryParams[$queryParam] = $this->parseQueryArgs($value);
            }
        }

        return $queryParams;
    }

    /**
     * Parse the query argument string
     * and convert into an array.
     *
     * @param  string $arg
     * @return array
     */
    private function parseQueryArgs($arg)
    {
        return array_map(function ($item) {
            $key = explode(',', $item);
            switch (true) {
                case starts_with($key[0], '-'):
                    return [substr($key[0], 1), 'desc'];

                case starts_with($key[0], '+'):
                    return [substr($key[0], 1), 'asc'];

                default:
                    return $key;
            }
        }, explode(';', $arg));
    }

    /**
     * Check if a query value is parseable.
     *
     * @param  string|array  $queryValue
     * @return boolean
     */
    private function isParsable($queryValue)
    {
        if (is_string($queryValue)) {
            return true;
        }

        return false;
    }

    /**
     * Check if a query value is queryable.
     *
     * @param  string|array $attribute
     * @return boolean
     */
    private function isQueryable($attribute)
    {
        switch (true) {
            case !property_exists($this, 'queryable'):
            case $this->queryable == '*':
                return true;

            case is_string($attribute):
                return in_array($attribute, $this->queryable);

            case is_array($attribute):
                foreach ($attribute as $attr) {
                    if (in_array($attr, $this->queryable)) {
                        return true;
                    }
                }
                return false;

            default:
                return false;
        }
    }
}
