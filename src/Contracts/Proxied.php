<?php
/**
 * Proxy contract.
 *
 * @author Samy Nastuzzi <samy@nastuzzi.fr>
 *
 * @copyright Copyright (c) 2020
 * @license MIT
 */

namespace Laramore\Contracts;

interface Proxied
{
    /**
     * Return the proxy handler for this class.
     *
     * @return void
     */
    public function getProxyHandler();

    /**
     * Indicate if a proxy exists.
     *
     * @param string $name
     * @return void
     */
    public function hasProxy(string $name);

    /**
     * Return a proxy by its name.
     *
     * @param string $name
     * @return void
     */
    public function getProxy(string $name);

    /**
     * Return the static proxy handler for this class.
     *
     * @return void
     */
    public static function getStaticProxyHandler();

    /**
     * Indicate if a static proxy exists.
     *
     * @param string $name
     * @return void
     */
    public static function hasStaticProxy(string $name);

    /**
     * Return a static proxy by its name.
     *
     * @param string $name
     * @return void
     */
    public static function getStaticProxy(string $name);

    /**
     * Call a proxy by its name.
     *
     * @param mixed $name
     * @param mixed $args
     * @return void
     */
    public function __proxy($name, $args);

    /**
     * Return a static proxy by its name.
     *
     * @param mixed $name
     * @param mixed $args
     * @return void
     */
    public static function __proxyStatic($name, $args);
}
