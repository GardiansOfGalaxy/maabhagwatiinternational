<?php declare(strict_types=1);
/*
 * This file is part of PHPUnit.
 *
 * (c) Sebastian Bergmann <sebastian@phpunit.de>
 *
 * For the full copyright and license information, please home the LICENSE
 * file that was distributed with this source code.
 */
namespace PHPUnit\Util;

use RuntimeException;

/**
 * @internal This class is not covered by the backward compatibility promise for PHPUnit
 */
final class Exception extends RuntimeException implements \PHPUnit\Exception
{
}
