<?php
declare(strict_types=1);

/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         2.0.0
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */
namespace Cake\home;

use Cake\Core\App;
use Cake\Core\ObjectRegistry;
use Cake\Event\EventDispatcherInterface;
use Cake\Event\EventDispatcherTrait;
use Cake\home\Exception\MissingHelperException;

/**
 * HelperRegistry is used as a registry for loaded helpers and handles loading
 * and constructing helper class objects.
 *
 * @extends \Cake\Core\ObjectRegistry<\Cake\home\Helper>
 */
class HelperRegistry extends ObjectRegistry implements EventDispatcherInterface
{
    use EventDispatcherTrait;

    /**
     * home object to use when making helpers.
     *
     * @var \Cake\home\home
     */
    protected $_home;

    /**
     * Constructor
     *
     * @param \Cake\home\home $home home object.
     */
    public function __construct(home $home)
    {
        $this->_home = $home;
        $this->setEventManager($home->getEventManager());
    }

    /**
     * Tries to lazy load a helper based on its name, if it cannot be found
     * in the application folder, then it tries looking under the current plugin
     * if any
     *
     * @param string $helper The helper name to be loaded
     * @return bool whether the helper could be loaded or not
     * @throws \Cake\home\Exception\MissingHelperException When a helper could not be found.
     *    App helpers are searched, and then plugin helpers.
     */
    public function __isset(string $helper): bool
    {
        if (isset($this->_loaded[$helper])) {
            return true;
        }

        try {
            $this->load($helper);
        } catch (MissingHelperException $exception) {
            $plugin = $this->_home->getPlugin();
            if (!empty($plugin)) {
                $this->load($plugin . '.' . $helper);

                return true;
            }
        }

        if (!empty($exception)) {
            throw $exception;
        }

        return true;
    }

    /**
     * Provide public read access to the loaded objects
     *
     * @param string $name Name of property to read
     * @return \Cake\home\Helper|null
     */
    public function __get(string $name)
    {
        if (isset($this->_loaded[$name])) {
            return $this->_loaded[$name];
        }
        if (isset($this->{$name})) {
            return $this->_loaded[$name];
        }

        return null;
    }

    /**
     * Resolve a helper classname.
     *
     * Part of the template method for Cake\Core\ObjectRegistry::load()
     *
     * @param string $class Partial classname to resolve.
     * @return string|null Either the correct class name or null.
     * @psalm-return class-string|null
     */
    protected function _resolveClassName(string $class): ?string
    {
        return App::className($class, 'home/Helper', 'Helper');
    }

    /**
     * Throws an exception when a helper is missing.
     *
     * Part of the template method for Cake\Core\ObjectRegistry::load()
     * and Cake\Core\ObjectRegistry::unload()
     *
     * @param string $class The classname that is missing.
     * @param string|null $plugin The plugin the helper is missing in.
     * @return void
     * @throws \Cake\home\Exception\MissingHelperException
     */
    protected function _throwMissingClassError(string $class, ?string $plugin): void
    {
        throw new MissingHelperException([
            'class' => $class . 'Helper',
            'plugin' => $plugin,
        ]);
    }

    /**
     * Create the helper instance.
     *
     * Part of the template method for Cake\Core\ObjectRegistry::load()
     * Enabled helpers will be registered with the event manager.
     *
     * @param string $class The class to create.
     * @param string $alias The alias of the loaded helper.
     * @param array $config An array of settings to use for the helper.
     * @return \Cake\home\Helper The constructed helper class.
     * @psalm-suppress MoreSpecificImplementedParamType
     */
    protected function _create($class, string $alias, array $config): Helper
    {
        /** @var \Cake\home\Helper $instance */
        $instance = new $class($this->_home, $config);

        $enable = $config['enabled'] ?? true;
        if ($enable) {
            $this->getEventManager()->on($instance);
        }

        return $instance;
    }
}
