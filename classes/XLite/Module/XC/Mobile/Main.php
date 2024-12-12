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


namespace XLite\Module\XC\Mobile;

/**
 * Skin customization module
 *
 */
abstract class Main extends \XLite\Module\AModule
{

    /**
     * Author name
     *
     * @return string
     */
    public static function getAuthorName()
    {
        return 'X-Cart team';

    }

    /**
     * Module name
     *
     * @return string
     */
    public static function getModuleName()
    {
        return 'Mobile';

    }

    /**
     * Get module major version
     *
     * @return string
     */
    public static function getMajorVersion()
    {
        return '5.0';

    }

    /**
     * Module version
     *
     * @return string
     */
    public static function getMinorVersion()
    {
        return '2';

    }

    /**
     * Module description
     *
     * @return string
     */
    public static function getDescription()
    {
        return 'This module enables the mobile view for your store.';

    }

    /**
     * Determines if we need to show settings form link
     *
     * @return boolean
     */
    public static function showSettingsForm()
    {
        return true;

    }

    /**
     * Register the module skins.
     *
     * @return array
     */
    public static function getSkins()
    {
        return 
            (defined('LC_MODULE_CONTROL') || \XLite\Core\Request::isMobileDevice() || defined('LC_CACHE_BUILDING')) 
                ? array(
                    \XLite::CUSTOMER_INTERFACE => array(
                        'mobile/customer',
                    ),
                    \XLite::COMMON_INTERFACE   => array(
                        'mobile/common',
                    ),
                    \XLite::ADMIN_INTERFACE    => array(
                        'mobile/admin',
                    ),
                    ) 
                : array(
                    \XLite::ADMIN_INTERFACE => array(
                        'mobile/admin',
                    ),
                );

    }

}
