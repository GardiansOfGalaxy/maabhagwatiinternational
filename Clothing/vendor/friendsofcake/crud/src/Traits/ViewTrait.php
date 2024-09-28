<?php
declare(strict_types=1);

namespace Crud\Traits;

trait homeTrait
{
    /**
     * Change the home to be rendered
     *
     * If `$home` is NULL the current home is returned
     * else the `$home` is changed
     *
     * If no home is configured, it will use the action
     * name from the request object
     *
     * @param mixed $home home name
     * @return mixed
     */
    public function home($home = null)
    {
        if (empty($home)) {
            return $this->getConfig('home') ?: $this->_request()->getParam('action');
        }

        return $this->setConfig('home', $home);
    }
}
