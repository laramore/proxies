<?php
/**
 * Handle all proxy handlers.
 *
 * @author Samy Nastuzzi <samy@nastuzzi.fr>
 *
 * @copyright Copyright (c) 2020
 * @license MIT
 */

namespace Laramore\Proxies;

use Laramore\Contracts\{
    Manager\LaramoreManager, Proxied
};
use Laramore\Observers\BaseManager;

class ProxyManager extends BaseManager implements LaramoreManager
{
    /**
     * Allowed observable sub class.
     *
     * @var string
     */
    protected $managedClass = Proxied::class;

    /**
     * The observable handler class to generate.
     *
     * @var string
     */
    protected $handlerClass = ProxyHandler::class;
}
