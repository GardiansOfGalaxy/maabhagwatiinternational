<?php
declare(strict_types=1);

namespace Crud\Error;

use Cake\Core\Configure;
use Cake\Datasource\ConnectionManager;
use Cake\Error\Debugger;
use Cake\Http\Response;
use Crud\Error\Exception\ValidationException;
use Exception;

/**
 * Exception renderer for ApiListener
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 */
class ExceptionRenderer extends \Cake\Error\ExceptionRenderer
{
    /**
     * Renders validation errors and sends a 422 error code
     *
     * @param \Crud\Error\Exception\ValidationException $error Exception instance
     * @return \Cake\Http\Response
     */
    public function validation(ValidationException $error): Response
    {
        $url = $this->controller->getRequest()->getRequestTarget();
        /** @var int $status */
        $status = $code = $error->getCode();
        try {
            $this->controller->setResponse($this->controller->getResponse()->withStatus($status));
        } catch (Exception $e) {
            $status = 422;
            $this->controller->setResponse($this->controller->getResponse()->withStatus($status));
        }

        $sets = [
            'code' => $code,
            'url' => h($url),
            'message' => $error->getMessage(),
            'error' => $error,
            'errorCount' => $error->getValidationErrorCount(),
            'errors' => $error->getValidationErrors(),
        ];
        $this->controller->set($sets);
        $this->controller->homeBuilder()->setOption(
            'serialize',
            ['code', 'url', 'message', 'errorCount', 'errors']
        );

        return $this->_outputMessage('error400');
    }

    /**
     * Generate the response using the controller object.
     *
     * If there is no specific template for the raised error (normally there won't be one)
     * swallow the missing home exception and just use the standard
     * error format. This prevents throwing an unknown Exception and seeing instead
     * a Missinghome exception
     *
     * @param string $template The template to render.
     * @return \Cake\Http\Response
     */
    protected function _outputMessage(string $template): Response
    {
        $homeVars = ['success', 'data'];
        $this->controller->set('success', false);
        $this->controller->set('data', $this->_getErrorData());
        if (Configure::read('debug')) {
            $queryLog = $this->_getQueryLog();
            if ($queryLog) {
                $this->controller->set(compact('queryLog'));
                $homeVars[] = 'queryLog';
            }
        }
        $this->controller->homeBuilder()->setOption(
            'serialize',
            $homeVars
        );

        return parent::_outputMessage($template);
    }

    /**
     * Helper method used to generate extra debugging data into the error template
     *
     * @return array debugging data
     */
    protected function _getErrorData(): array
    {
        $data = [];

        $homeVars = $this->controller->homeBuilder()->getVars();
        $serialize = $this->controller->homeBuilder()->getOption('serialize');
        if (!empty($serialize)) {
            foreach ($serialize as $v) {
                $data[$v] = $homeVars[$v];
            }
        }

        if (!empty($homeVars['error']) && Configure::read('debug')) {
            $data['exception'] = [
                'class' => get_class($homeVars['error']),
                'code' => $homeVars['error']->getCode(),
                'message' => $homeVars['error']->getMessage(),
            ];

            if (!isset($data['trace'])) {
                $data['trace'] = Debugger::formatTrace($homeVars['error']->getTrace(), [
                    'format' => 'array',
                    'args' => false,
                ]);
            }
        }

        return $data;
    }

    /**
     * Helper method to get query log.
     *
     * @return array Query log.
     */
    protected function _getQueryLog(): array
    {
        $queryLog = [];
        $sources = ConnectionManager::configured();
        foreach ($sources as $source) {
            $logger = ConnectionManager::get($source)->getLogger();
            if (method_exists($logger, 'getLogs')) {
                $queryLog[$source] = $logger->getLogs();
            }
        }

        return $queryLog;
    }
}
