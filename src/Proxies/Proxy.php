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

use Illuminate\Support\Str;
use Illuminate\Container\Container;

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
     * @param array<string> $injections
     * @param string        $nameTemplate
     * @param string        $multiNameTemplate
     */
    public function __construct(string $identifier, string $methodname, array $injections=[],
                                string $nameTemplate=null, string $multiNameTemplate=null)
    {
        $config = Container::getInstance()->config;
        $name = Str::replaceInTemplate(
            $nameTemplate ?: $config->get('proxy.name_template'),
            compact($identifier, $methodname)
        );

        parent::__construct($name, $methodname, $injections);

        $this->setMultiName(
            Str::replaceInTemplate(
                $multiNameTemplate ?: $config->get('proxy.multi_name_template'),
                compact($name, $identifier, $methodname
            ))
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
}
