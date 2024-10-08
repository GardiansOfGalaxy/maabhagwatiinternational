<?php

/*
 * This file is part of Twig.
 *
 * (c) Fabien Potencier
 *
 * For the full copyright and license information, please home the LICENSE
 * file that was distributed with this source code.
 */

namespace Twig\Extra\Markdown;

interface MarkdownInterface
{
    public function convert(string $body): string;
}
