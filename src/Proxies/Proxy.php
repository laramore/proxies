<?php
/**
 * Proxy definition.
 *
 * @author Samy Nastuzzi <samy@nastuzzi.fr>
 *
 * @copyright Copyright (c) 2020
 * @license MIT
 */

namespace Laramore\Proxies;

use Illuminate\Support\{
    Str, Arr
};
use Illuminate\Container\Container;
use Laramore\Contracts\Proxied;

class Proxy extends BaseProxy
{
    /**
     * Identifier value.
     *
     * @var string
     */
    protected $identifier;

    /**
     * Prefered name for the multi proxy name.
     *
     * @var string
     */
    protected $multiName;

    /**
     * An observer needs at least a name and a Closure.
     *
     * @param string        $identifier
     * @param string        $methodname
     * @param bool          $static
     * @param string        $nameTemplate
     * @param string        $multiNameTemplate
     */
    public function __construct(string $identifier, string $methodname, bool $static=false,
                                string $nameTemplate=null, string $multiNameTemplate=null)
    {
        $config = Container::getInstance()->config;
        $name = Str::replaceInTemplate(
            $nameTemplate ?: $config->get('proxy.name_template'),
            compact($identifier, $methodname)
        );

        parent::__construct($name, $methodname, $static);

        $this->setMultiName(
            Str::replaceInTemplate(
                $multiNameTemplate ?: $config->get('proxy.multi_name_template'),
                compact($name, $identifier, $methodname
            ))
        );

        $this->setIdentifier($identifier);
    }

    /**
     * Define the proxy multi proxy name.
     *
     * @param string $multiName
     * @return self
     */
    public function setMultiName(string $multiName)
    {
        $this->needsToBeUnlocked();

        $this->multiName = $multiName;

        return $this;
    }

    /**
     * Return the proxy multi proxy name.
     *
     * @return string
     */
    public function getMultiName(): string
    {
        return $this->multiName;
    }

    /**
     * Define the proxy identifier.
     *
     * @param string $multiName
     * @return self
     */
    public function setIdentifier(string $identifier)
    {
        $this->needsToBeUnlocked();

        $this->identifier = $identifier;

        return $this;
    }

    /**
     * Return the proxy identifier.
     *
     * @return string
     */
    public function getIdentifier(): string
    {
        return $this->identifier;
    }

    /**
     * Call the proxy.
     *
     * @param  mixed ...$args
     * @return mixed
     */
    public function __invoke(...$args)
    {
        if (!$this->isStatic && !(Arr::get($args, 0) instanceof Proxied)) {
            throw new \BadMethodCallException("The proxy `{$this->getName()}` cannot be called statically.");
        }

        return \call_user_func($this->getCallback(), ...$args);
    }
}