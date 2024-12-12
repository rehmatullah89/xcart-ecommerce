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
 * @copyright Copyright (c) 2011-2013 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 */


namespace XLite\Module\XC\Mobile\Core;

/**
 * Request
 */
class Request extends \XLite\Core\Request implements \XLite\Base\IDecorator
{
    /**
     * Initial scale value
     */
    const INITIAL_MOBILE_SCALE = '0.8';
    const INITIAL_TABLET_SCALE = '1';

    /**
     * Default pages transition
     */
    const DEFAULT_PAGES_TRANSITION = 'slide';

    /**
     * Cache for mobile device flag
     *
     * @var null|boolean
     */
    protected static $isMobileDeviceFlag = null;

    /**
     * Detect Mobile version
     *
     * @return boolean
     */
    public static function isMobileDevice()
    {
        if (is_null(static::$isMobileDeviceFlag)) {
            static::$isMobileDeviceFlag = static::isMobileEnabled() ? static::detectMobileDevice() : false;
        }

        return static::$isMobileDeviceFlag;
    }

    /**
     * Return true if Mobile skin is disabled by session param 'mobileEnabled'
     *
     * @return boolean
     */
    public static function isMobileEnabled()
    {
        if (!isset(\XLite\Core\Session::getInstance()->mobileEnabled)) {
            \XLite\Core\Session::getInstance()->mobileEnabled = true;
        }

        return ((boolean)\XLite\Core\Session::getInstance()->mobileEnabled);
    }

    public static function doEnableMobile()
    {
        \XLite\Core\Session::getInstance()->mobileEnabled = true;
    }

    public static function doDisableMobile()
    {
        \XLite\Core\Session::getInstance()->mobileEnabled = false;
    }

    /**
     * Detect if browser is mobile device
     *
     * @return boolean
     */
    public static function detectMobileDevice()
    {
        $detect = \XLite\Module\XC\Mobile\Core\MobileDetect::getInstance()->detect;
        $conf_var = 'mobile_show_on_tablets';

        return !(\XLite\Core\Config::getInstance()->XC && \XLite\Core\Config::getInstance()->XC->Mobile->$conf_var)
            ? $detect->isMobile() && !$detect->isTablet()
            : $detect->isMobile();
    }

    /**
     * Get initial scale
     *
     * @return string
     */
    public static function getInitialScale()
    {
        $detect = \XLite\Module\XC\Mobile\Core\MobileDetect::getInstance()->detect;
        return ($detect->isTablet())
            ? self::INITIAL_TABLET_SCALE
            : self::INITIAL_MOBILE_SCALE;
    }

    /**
     * Get default mobile pages transition value
     *
     * @return string
     */
    public static function getDefaultPagesTransition()
    {
        $detect = \XLite\Module\XC\Mobile\Core\MobileDetect::getInstance()->detect;
        return ($detect->isAndroidOS() && strnatcmp($detect->version('Android'), '2.3.3') <= 0)
            ? 'none'
            : self::DEFAULT_PAGES_TRANSITION;
    }
}
