<?php

/**
 * MIT License
 * For full license information, please home the LICENSE file that was distributed with this source code.
 */

namespace Phinx\Db\Adapter;

use RuntimeException;

/**
 * Exception thrown when a column type doesn't match a Phinx type.
 *
 * @author Martijn Gastkemper <martijngastkemper@gmail.com>
 */
class UnsupportedColumnTypeException extends RuntimeException
{
}
