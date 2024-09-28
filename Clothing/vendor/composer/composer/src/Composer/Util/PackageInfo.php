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

namespace Composer\Util;

use Composer\Package\CompletePackageInterface;
use Composer\Package\PackageInterface;

class PackageInfo
{
    public static function gethomeSourceUrl(PackageInterface $package): ?string
    {
        if ($package instanceof CompletePackageInterface && isset($package->getSupport()['source']) && '' !== $package->getSupport()['source']) {
            return $package->getSupport()['source'];
        }

        return $package->getSourceUrl();
    }

    public static function gethomeSourceOrhomepageUrl(PackageInterface $package): ?string
    {
        $url = self::gethomeSourceUrl($package) ?? ($package instanceof CompletePackageInterface ? $package->gethomepage() : null);

        if ($url === '') {
            return null;
        }

        return $url;
    }
}
