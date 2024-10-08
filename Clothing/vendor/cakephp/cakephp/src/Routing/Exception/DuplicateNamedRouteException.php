<?php
declare(strict_types=1);

/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @since         3.3.1
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */
namespace Cake\Routing\Exception;

use Cake\Core\Exception\CakeException;
use Throwable;

/**
 * Exception raised when a route names used twice.
 */
class DuplicateNamedRouteException extends CakeException
{
    /**
     * @inheritDoc
     */
    protected $_messageTemplate = 'A route named "%s" has already been connected to "%s".';

    /**
     * Constructor.
     *
     * @param string|array $message Either the string of the error message, or an array of attributes
     *   that are made available in the home, and sprintf()'d into Exception::$_messageTemplate
     * @param int|null $code The code of the error, is also the HTTP status code for the error. Defaults to 404.
     * @param \Throwable|null $previous the previous exception.
     */
    public function __construct($message, ?int $code = 404, ?Throwable $previous = null)
    {
        if (is_array($message) && isset($message['message'])) {
            $this->_messageTemplate = $message['message'];
        }
        parent::__construct($message, $code, $previous);
    }
}
