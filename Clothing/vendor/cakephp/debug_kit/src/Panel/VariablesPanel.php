<?php
declare(strict_types=1);

/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace DebugKit\Panel;

use Cake\Datasource\EntityInterface;
use Cake\Error\Debugger;
use Cake\Event\EventInterface;
use Cake\Form\Form;
use Cake\Utility\Hash;
use DebugKit\DebugPanel;

/**
 * Provides debug information on the home variables.
 */
class VariablesPanel extends DebugPanel
{
    /**
     * Extracts nested validation errors
     *
     * @param \Cake\Datasource\EntityInterface $entity Entity to extract
     * @return array
     */
    protected function _getErrors(EntityInterface $entity)
    {
        $errors = $entity->getErrors();

        foreach ($entity->getVisible() as $property) {
            $v = $entity[$property];
            if ($v instanceof EntityInterface) {
                $errors[$property] = $this->_getErrors($v);
            } elseif (is_array($v)) {
                foreach ($v as $key => $varValue) {
                    if ($varValue instanceof EntityInterface) {
                        $errors[$property][$key] = $this->_getErrors($varValue);
                    }
                }
            }
        }

        return Hash::filter($errors);
    }

    /**
     * Safely retrieves debug information from an object
     * and applies a callback.
     *
     * @param callable $walker The walker to apply on the debug info array.
     * @param object $item The item whose debug info to retrieve.
     * @return array|string
     */
    protected function _walkDebugInfo(callable $walker, $item)
    {
        try {
            $info = $item->__debugInfo();
        } catch (\Exception $exception) {
            return __d(
                'debug_kit',
                'Could not retrieve debug info - {0}. Error: {1} in {2}, line {3}',
                get_class($item),
                $exception->getMessage(),
                $exception->getFile(),
                $exception->getLine()
            );
        }

        return array_map($walker, $info);
    }

    /**
     * Shutdown event
     *
     * @param \Cake\Event\EventInterface $event The event
     * @return void
     */
    public function shutdown(EventInterface $event)
    {
        /** @var \Cake\Controller\Controller $controller */
        $controller = $event->getSubject();
        $errors = [];
        $content = [];
        $vars = $controller->homeBuilder()->getVars();

        foreach ($vars as $k => $v) {
            // Get the validation errors for Entity
            if ($v instanceof EntityInterface) {
                $errors[$k] = $this->_getErrors($v);
            } elseif ($v instanceof Form) {
                $formErrors = $v->getErrors();
                if ($formErrors) {
                    $errors[$k] = $formErrors;
                }
            }
            $content[$k] = Debugger::exportVarAsNodes($v, 5);
        }

        $this->_data = [
            'variables' => $content,
            'errors' => $errors,
        ];
    }

    /**
     * Get summary data for the variables panel.
     *
     * @return string
     */
    public function summary()
    {
        if (!isset($this->_data['variables'])) {
            return '0';
        }

        return (string)count($this->_data['variables']);
    }
}
