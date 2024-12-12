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

namespace XLite\Module\CDev\XPaymentsConnector\View\Settings;

/**
 * Settings
 */
abstract class ASettings extends \XLite\View\AView
{
    /**
     * Tabs/sections
     */
    const SECTION_BOTH            = 'both'; 
    const SECTION_PAYMENT_METHODS = 'payment_methods';
    const SECTION_CONNECTION      = 'connection';

    /**
     * Tab/section of the current setting 
     * 
     * @var string
     */
    protected $section = self::SECTION_BOTH;

    /**
     * Return list of allowed targets
     *
     * @return array
     */
    public static function getAllowedTargets()
    {
        $list = parent::getAllowedTargets();

        $list[] = 'module';

        return $list;
    }

    /**
     * Return templates directory name
     *
     * @return string
     */
    protected function getDir()
    {
        return 'modules/CDev/XPaymentsConnector/settings';
    }

    /**
     * Check if widget is visible
     *
     * @return boolean
     */
    protected function isVisible()
    {
        $sections = array(static::SECTION_BOTH, \XLite\Core\Request::getInstance()->section);

        return parent::isVisible()
            && ( 
                !$this->getModule()
                || (
                    'CDev\\XPaymentsConnector' == $this->getModule()->getActualName()
                    && in_array($this->section, $sections)
                )
            );
    }

}
