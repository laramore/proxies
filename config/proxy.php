<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default proxies
    |--------------------------------------------------------------------------
    |
    | These options define all proxy configurations.
    |
    */

    'manager' => \Laramore\Proxies\ProxyManager::class,
    
    'name_template' => '${methodname}^{identifier}',
    'multi_name_template' => '${methodname}',

    'configurations' => [],
];
