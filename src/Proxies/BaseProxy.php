<?php
/**
 * Create an Observer to add a \Closure on a specific model event.
 *
 * @author Samy Nastuzzi <samy@nastuzzi.fr>
 *
 * @copyright Copyright (c) 2020
 * @license MIT
 */

namespace Laramore\Proxies;

use Laramore\Observers\BaseObserver;

abstract class BaseProxy extends BaseObserver
{
    /**
     * The method to call.
     *
     * @var string
     */
    protected $methodName;

    /**
     * Static proxy
     *
     * @var bool
     */
    protected $static;

    /**
     * An observer needs at least a name and a Closure.
     *
     * @param string        $name
     * @param string        $methodName
     * @param bool          $static
     */
    public function __construct(string $name, string $methodName, bool $static=false)
    {
        $this->setMethodName($methodName);
        $this->setStatic($static);

        parent::__construct($name, null, self::MEDIUM_PRIORITY, []);
    }

    /**
     * Define the method name that is used for this proxy.
     *
     * @param string $methodName
     * @return self
     */
    public function setMethodName(string $methodName)
    {
        $this->needsToBeUnlocked();

        $this->methodName = $methodName;

        return $this;
    }

    /**
     * Return the method name that is used for this proxy.
     *
     * @return string
     */
    public function getMethodName(): string
    {
        return $this->methodName;
    }

    /**
     *  Set this proxy as static or not.
     *
     * @param bool $methodName
     * @return self
     */
    public function setStatic(bool $static)
    {
        $this->needsToBeUnlocked();

        $this->static = $static;

        return $this;
    }

    /**
     * Return if this proxy is static or not.
     *
     * @return bool
     */
    public function isStatic(): bool
    {
        return $this->static;
    }
}
