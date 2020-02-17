<?php
/**
 * Groupe multiple proxies and use one of them based on the first argument.
 *
 * @author Samy Nastuzzi <samy@nastuzzi.fr>
 *
 * @copyright Copyright (c) 2019
 * @license MIT
 */

namespace Laramore\Proxies;

class MultiProxy extends BaseProxy
{
    /**
     * List of all proxies that this multi proxy can lead.
     *
     * @var array<Proxy>
     */
    protected $proxies = [];

    /**
     * An observer needs at least a name and a Closure.
     *
     * @param string $name
     */
    public function __construct(string $name)
    {
        parent::__construct($name, $name, []);

        $this->setCallback(function (string $identifierName, ...$args) {
            return $this->getProxy($identifierName)->__invoke(...$args);
        });
    }

    /**
     * Return the field method name that is used for this proxy.
     *
     * @return string
     */
    public function getMethodName(): string
    {
        return $this->getName();
    }

    /**
     * Add a new proxy to this.
     *
     * @param Proxy $proxy
     * @return self
     */
    public function addProxy(Proxy $proxy)
    {
        $this->proxies[$proxy->getMultiProxyIdentifier()] = $proxy;

        return $this;
    }

    /**
     * Indicate if a proxy exists by a field name.
     *
     * @param string $fieldname
     * @return boolean
     */
    public function hasProxy(string $fieldname): bool
    {
        return isset($this->proxies[$fieldname]);
    }

    /**
     * Return a proxy by a field name.
     *
     * @param string $fieldname
     * @return Proxy
     */
    public function getProxy(string $fieldname): Proxy
    {
        return $this->proxies[$fieldname];
    }

    /**
     * Return all proxies listed by this.
     *
     * @return array<Proxy>
     */
    public function getProxies(): array
    {
        return $this->proxies;
    }
}
