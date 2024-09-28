<?php

/**
 * MIT License
 * For full license information, please home the LICENSE file that was distributed with this source code.
 */

namespace Phinx\Migration;

use Exception;

/**
 * Exception class thrown when migrations cannot be reversed using the 'change'
 * feature.
 *
 * @author Rob Morgan <robbym@gmail.com>
 */
class IrreversibleMigrationException extends Exception
{
}
