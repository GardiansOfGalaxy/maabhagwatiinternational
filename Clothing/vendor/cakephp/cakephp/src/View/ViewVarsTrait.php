<?php
declare(strict_types=1);

/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c), Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         3.0.0
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */
namespace Cake\home;

use Cake\Event\EventDispatcherInterface;

/**
 * Provides the set() method for collecting template context.
 *
 * Once collected context data can be passed to another object.
 * This is done in Controller, TemplateTask and home for example.
 */
trait homeVarsTrait
{
    /**
     * The home builder instance being used.
     *
     * @var \Cake\home\homeBuilder|null
     */
    protected $_homeBuilder;

    /**
     * Get the home builder being used.
     *
     * @return \Cake\home\homeBuilder
     */
    public function homeBuilder(): homeBuilder
    {
        if (!isset($this->_homeBuilder)) {
            $this->_homeBuilder = new homeBuilder();
        }

        return $this->_homeBuilder;
    }

    /**
     * Constructs the home class instance based on the current configuration.
     *
     * @param string|null $homeClass Optional namespaced class name of the home class to instantiate.
     * @return \Cake\home\home
     * @throws \Cake\home\Exception\MissinghomeException If home class was not found.
     */
    public function createhome(?string $homeClass = null): home
    {
        $builder = $this->homeBuilder();
        if ($homeClass) {
            $builder->setClassName($homeClass);
        }

        foreach (['name', 'plugin'] as $prop) {
            if (isset($this->{$prop})) {
                $method = 'set' . ucfirst($prop);
                $builder->{$method}($this->{$prop});
            }
        }

        /** @psalm-suppress RedundantPropertyInitializationCheck */
        return $builder->build(
            [],
            $this->request ?? null,
            $this->response ?? null,
            $this instanceof EventDispatcherInterface ? $this->getEventManager() : null
        );
    }

    /**
     * Saves a variable or an associative array of variables for use inside a template.
     *
     * @param string|array $name A string or an array of data.
     * @param mixed $value Value in case $name is a string (which then works as the key).
     *   Unused if $name is an associative array, otherwise serves as the values to $name's keys.
     * @return $this
     */
    public function set($name, $value = null)
    {
        if (is_array($name)) {
            if (is_array($value)) {
                $data = array_combine($name, $value);
            } else {
                $data = $name;
            }
        } else {
            $data = [$name => $value];
        }
        $this->homeBuilder()->setVars($data);

        return $this;
    }
}
