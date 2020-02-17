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
     * An observer needs at least a name and a Closure.
     *
     * @param string        $name
     * @param string        $methodName
     * @param array<string> $injections
     */
    public function __construct(string $name, string $methodName, array $injections=[])
    {
        $this->setMethodName($methodName);

        parent::__construct($name, null, self::MEDIUM_PRIORITY, $injections);
    }

    /**
     * Define the field method name that is used for this proxy.
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
     * Return the field method name that is used for this proxy.
     *
     * @return string
     */
    public function getMethodName(): string
    {
        return $this->methodName;
    }
}
