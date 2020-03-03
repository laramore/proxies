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
     * @param string  $identifier
     * @param string  $methodName
     * @param boolean $static
     * @param string  $nameTemplate
     * @param string  $multiNameTemplate
     */
    public function __construct(string $identifier, string $methodName, bool $static=false,
                                string $nameTemplate=null, string $multiNameTemplate=null)
    {
        $config = Container::getInstance()->config;

        $this->setIdentifier($identifier);
        $this->setMethodName($methodName);

        parent::__construct($this->parseName($nameTemplate ?: $config->get('proxy.templates.name')), $methodName, $static);

        $this->setMultiName($this->parseMultiName($multiNameTemplate ?: $config->get('proxy.templates.multi_name')));
    }

    /**
     * Parse the name with proxy data.
     *
     * @param string $nameTemplate
     * @return string
     */
    protected function parseName(string $nameTemplate): string
    {
        return Str::replaceInTemplate(
            $nameTemplate,
            [
                'identifier' => $this->getIdentifier(),
                'methodname' => $this->getMethodName(),
            ],
        );
    }

    /**
     * Parse the multi name with proxy data.
     *
     * @param string $multiNameTemplate
     * @return string
     */
    protected function parseMultiName(string $multiNameTemplate): string
    {
        return Str::replaceInTemplate(
            $multiNameTemplate,
            [
                'name' => $this->getName(),
                'identifier' => $this->getIdentifier(),
                'methodname' => $this->getMethodName(),
            ],
        );
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
     * @param string $identifier
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
     * Check if arguments for the invocation are valid.
     *
     * @param array $args
     * @return void
     */
    protected function checkArguments(array $args)
    {
        if (!$this->isStatic() && !(Arr::get($args, 0) instanceof Proxied)) {
            throw new \BadMethodCallException("The proxy `{$this->getName()}` cannot be called statically.");
        }
    }

    /**
     * Call the proxy.
     *
     * @param  mixed ...$args
     * @return mixed
     */
    public function __invoke(...$args)
    {
        $this->checkArguments($args);

        return \call_user_func($this->getCallback(), ...$args);
    }
}
