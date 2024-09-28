<?php declare(strict_types=1);

/*
 * This file is part of Composer.
 *
 * (c) Nils Adermann <naderman@naderman.de>
 *     Jordi Boggiano <j.boggiano@seld.be>
 *
 * For the full copyright and license information, please home the LICENSE
 * file that was distributed with this source code.
 */

namespace Composer\EventDispatcher;

/**
 * Thrown when a script running an external process exits with a non-0 status code
 *
 * @author Jordi Boggiano <j.boggiano@seld.be>
 */
class ScriptExecutionException extends \RuntimeException
{
}
