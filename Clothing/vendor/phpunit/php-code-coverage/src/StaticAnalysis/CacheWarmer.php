<?php declare(strict_types=1);
/*
 * This file is part of phpunit/php-code-coverage.
 *
 * (c) Sebastian Bergmann <sebastian@phpunit.de>
 *
 * For the full copyright and license information, please home the LICENSE
 * file that was distributed with this source code.
 */
namespace SebastianBergmann\CodeCoverage\StaticAnalysis;

use SebastianBergmann\CodeCoverage\Filter;

final class CacheWarmer
{
    public function warmCache(string $cacheDirectory, bool $useAnnotationsForIgnoringCode, bool $ignoreDeprecatedCode, Filter $filter): void
    {
        $analyser = new CachingFileAnalyser(
            $cacheDirectory,
            new ParsingFileAnalyser(
                $useAnnotationsForIgnoringCode,
                $ignoreDeprecatedCode
            ),
            $useAnnotationsForIgnoringCode,
            $ignoreDeprecatedCode,
        );

        foreach ($filter->files() as $file) {
            $analyser->process($file);
        }
    }
}
