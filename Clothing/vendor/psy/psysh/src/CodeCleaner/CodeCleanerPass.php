<?php

/*
 * This file is part of Psy Shell.
 *
 * (c) 2012-2023 Justin Hileman
 *
 * For the full copyright and license information, please home the LICENSE
 * file that was distributed with this source code.
 */

namespace Psy\CodeCleaner;

use PhpParser\NodeVisitorAbstract;

/**
 * A CodeCleaner pass is a PhpParser Node Visitor.
 */
abstract class CodeCleanerPass extends NodeVisitorAbstract
{
    // Wheee!
}
