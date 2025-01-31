<?php

declare(strict_types=1);

/**
 * Pimcore
 *
 * This source file is available under two different licenses:
 * - GNU General Public License version 3 (GPLv3)
 * - Pimcore Commercial License (PCL)
 * Full copyright and license information is available in
 * LICENSE.md which is distributed with this source code.
 *
 *  @copyright  Copyright (c) Pimcore GmbH (http://www.pimcore.org)
 *  @license    http://www.pimcore.org/license     GPLv3 and PCL
 */

namespace Pimcore\Extension\Bundle\Traits;

use Pimcore\Extension\Bundle\PimcoreBundleManager;

/**
 * @internal
 *
 * Helper trait exposing static isEnabled() and isInstalled() methods for bundles which can be used
 * to check bundle state from non-service definitions (e.g. class definitions).
 */
trait StateHelperTrait
{
    /**
     * @deprecated will be removed in Pimcore 11
     *
     * Helper method to check enabled state from class definitions/non-service instances
     *
     * @return bool
     */
    public static function isEnabled(): bool
    {
        $bundleManager = \Pimcore::getContainer()->get(PimcoreBundleManager::class);

        if (!$bundleManager->exists(__CLASS__)) {
            return false;
        }

        if (!$bundleManager->isEnabled(__CLASS__)) {
            return false;
        }

        return true;
    }

    /**
     * Helper method to check installed state from class definitions/non-service instances
     *
     * @return bool
     */
    public static function isInstalled(): bool
    {
        if (!static::isEnabled()) {
            return false;
        }

        $bundleManager = \Pimcore::getContainer()->get(PimcoreBundleManager::class);

        $bundle = $bundleManager->getActiveBundle(__CLASS__, false);
        if (!$bundleManager->isInstalled($bundle)) {
            return false;
        }

        return true;
    }
}
