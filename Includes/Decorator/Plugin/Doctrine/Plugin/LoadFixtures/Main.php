<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * X-Cart
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the software license agreement
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.x-cart.com/license-agreement.html
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to licensing@x-cart.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not modify this file if you wish to upgrade X-Cart to newer versions
 * in the future. If you wish to customize X-Cart for your needs please
 * refer to http://www.x-cart.com/ for more information.
 *
 * @category  X-Cart 5
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2014 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 */

namespace Includes\Decorator\Plugin\Doctrine\Plugin\LoadFixtures;

/**
 * Main 
 *
 */
class Main extends \Includes\Decorator\Plugin\Doctrine\Plugin\APlugin
{
    const STEP_TTL = 10;

    /**
     * Execute certain hook handle
     *
     * @return void
     */
    public function executeHookHandler()
    {
        $sum = 0;

        \Includes\Utils\Operator::showMessage('', true, false);

        foreach (\Includes\Decorator\Plugin\Doctrine\Utils\FixturesManager::getFixtures() as $fixture) {
            \Includes\Utils\Operator::showMessage('...Load ' . substr($fixture, strlen(LC_DIR_ROOT)), true, true);
            \XLite\Core\Database::getInstance()->loadFixturesFromYaml($fixture);
            \Includes\Decorator\Plugin\Doctrine\Utils\FixturesManager::removeFixtureFromList($fixture);
            if (\Includes\Decorator\Utils\CacheManager::isTimeExceeds(static::STEP_TTL)) {
                break;
            }
        }

        \XLite\Core\Database::getEM()->clear();
    }
}
