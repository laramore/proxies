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

    'multi_class' => \Laramore\Proxies\MultiProxy::class,
    
    'templates' => [
        'name' => '-{methodname}-^{identifier}',
        'multi_name' => '-{methodname}',
    ],

    'configurations' => [],
];
