<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Query Key Prefix
    |--------------------------------------------------------------------------
    |
    | The query key prefix wrap the query param and make it an array.
    | Will not make an array if the value is null.
    |
    | eg. 'q' with make the query param ?q[<param>]=<value>
    |     null will make the query param ?<param>=<value>
    |
    */
    'key_prefix' => 'q',

    /*
    |--------------------------------------------------------------------------
    | Basic Query Prefix
    |--------------------------------------------------------------------------
    |
    | eg. ?q[select]=id,name
    |     ?q[order_by]=name,desc;created_at
    |     ?q[order_by]=-name;created_at
    |     ?q[limit]=20
    |     ?q[offset]=10
    |     ?q[with]=posts,posts.comments
    |     ?q[where_{column_name}_{postfix}]={values}
    |     ?q[or_where_{column_name}_{postfix}]={values}
    |
    */
    'query_prefix' => [
        'select'   => 'select',
        'order_by' => 'order_by',
        'limit'    => 'limit',
        'offset'   => 'offset',
        'with'     => 'with',
        'where'    => 'where',
        'or_where' => 'or_where',
    ],

    /*
    |--------------------------------------------------------------------------
    | Where Query Postfix
    |--------------------------------------------------------------------------
    |
    | Only usable for 'where' and 'or_where' prefix.
    |
    | eg. ?q[where_name_starts_with]=John
    |     ?q[where_name_not_starts_with]=John
    |     ?q[where_name_ends_with]=Doe
    |     ?q[where_name_not_ends_with]=Doe
    |     ?q[where_name_contains]=John
    |     ?q[where_name_not_contains]=John
    |     ?q[where_created_at_gt]=2017-07-19%2008:14:45
    |     ?q[where_created_at_lt]=2017-07-19%2008:14:48
    |     ?q[where_name_eq]=John%20Doe
    |     ?q[where_name_ne]=John%20Doe
    |     ?q[where_id_in]=1,2,3
    |     ?q[where_id_not_in]=1,2,3
    |     ?q[where_created_at_between]=2017-07-19%2008:14:45,2017-07-19%2008:14:48
    |     ?q[where_created_at_not_between]=2017-07-19%2008:14:45,2017-07-19%2008:14:48
    |
    */
    'query_postfix' => [
        'not_starts_with' => 'not_starts_with',
        'starts_with'     => 'starts_with',
        'not_ends_with'   => 'not_ends_with',
        'ends_with'       => 'ends_with',
        'not_contains'    => 'not_contains',
        'contains'        => 'contains',
        'greater_than'    => 'gt',
        'lower_than'      => 'lt',
        'equals_to'       => 'eq',
        'not_equal'       => 'ne',
        'where_not_in'    => 'not_in',
        'where_in'        => 'in',
        'not_between'     => 'not_between',
        'between'         => 'between',
    ],

];
