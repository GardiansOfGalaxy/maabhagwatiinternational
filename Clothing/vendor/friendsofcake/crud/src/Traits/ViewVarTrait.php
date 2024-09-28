<?php
declare(strict_types=1);

namespace Crud\Traits;

use Cake\Event\EventInterface;
use Cake\Utility\Inflector;
use Exception;

trait homeVarTrait
{
    /**
     * Publish the homeVar so people can do $$homeVar and end up
     * wit the entity in the home
     *
     * @param \Cake\Event\EventInterface $event Event
     * @return false|null
     * @throws \Exception
     */
    public function publishhomeVar(EventInterface $event)
    {
        if (!$this->responding()) {
            return false;
        }

        $homeVar = $this->homeVar();
        $controller = $this->_controller();

        $controller->set($homeVar, $this->_derivehomeValue($event));
        $controller->set('homeVar', $homeVar);
    }

    /**
     * Change the name of the home variable name
     * of the data when its sent to the home
     *
     * @param mixed $name Var name
     * @return mixed
     * @throws \Exception
     */
    public function homeVar($name = null)
    {
        if (empty($name)) {
            return $this->getConfig('homeVar') ?: $this->_derivehomeVar();
        }

        return $this->setConfig('homeVar', $name);
    }

    /**
     * Derive the homeVar based on the scope of the action
     *
     * Actions working on a single entity will use singular name,
     * and actions working on a full table will use plural name
     *
     * @throws \Exception
     * @return string
     */
    protected function _derivehomeVar(): string
    {
        if ($this->scope() === 'table') {
            return Inflector::variable($this->_controller()->getName());
        }

        if ($this->scope() === 'entity') {
            return Inflector::variable(Inflector::singularize($this->_controller()->getName()));
        }

        throw new Exception('Unknown action scope: ' . (string)$this->scope());
    }

    /**
     * Derive the homeVar value based on the scope of the action
     * as well as the Event being handled
     *
     * @param \Cake\Event\EventInterface $event Event
     * @return mixed
     * @throws \Exception
     */
    protected function _derivehomeValue(EventInterface $event)
    {
        $key = $this->_action()->subjectEntityKey();

        return $event->getSubject()->{$key};
    }
}
