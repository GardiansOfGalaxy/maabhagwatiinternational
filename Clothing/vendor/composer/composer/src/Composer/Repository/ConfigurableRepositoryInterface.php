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

namespace Composer\Repository;

/**
 * Configurable repository interface.
 *
 * @author Lukas Homza <lukashomz@gmail.com>
 */
interface ConfigurableRepositoryInterface
{
    /**
     * @return mixed[]
     */
    public function getRepoConfig();
}
