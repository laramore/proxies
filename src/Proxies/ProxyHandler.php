<?php
/**
 * Handle all observers for a specific model.
 *
 * @author Samy Nastuzzi <samy@nastuzzi.fr>
 *
 * @copyright Copyright (c) 2019
 * @license MIT
 */

namespace Laramore\Proxies;

use Laramore\Observers\{
    BaseHandler, BaseObserver
};

class ProxyHandler extends BaseHandler
{
    /**
     * The observable class.
     *
     * @var string
     */
    protected $observerClass = Proxy::class;

    /**
     * Add an observer to a list of observers.
     *
     * @param BaseObserver     $proxy
     * @param array<BaseProxy> $proxys
     * @return self
     */
    protected function push(BaseObserver $proxy, array &$proxys)
    {
        \array_push($proxys, $proxy);

        if ($this->has($name = $proxy->getMultiProxyName())) {
            $multiProxy = $this->get($name);

            if (!($multiProxy instanceof MultiProxy)) {
                throw new \LogicException("Conflict between proxies `$name`");
            }
        } else {
            \array_push($proxys, $multiProxy = new MultiProxy($name));
        }

        $multiProxy->addProxy($proxy);

        return $this;
    }
}
