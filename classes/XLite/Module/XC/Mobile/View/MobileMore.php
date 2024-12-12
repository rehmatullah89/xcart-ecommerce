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


namespace XLite\Module\XC\Mobile\View;

/**
 * Category widget
 *
 * @ListChild (list="center", zone="customer")
 */
class MobileMore extends \XLite\View\AView
{

    /**
     * Return widget default template
     *
     * @return string
     */
    protected function getDefaultTemplate()
    {
        return 'more.tpl';
    }

    /**
     * Check if the user is logged as registered account
     *
     * @return boolean
     */
    protected function isLoggedMore()
    {
        return $this->isLogged() && !\XLite\Core\Auth::getInstance()->isAnonymous();
    }

    /**
     * Check if widget is visible
     *
     * @return boolean
     */
    protected function isVisible()
    {
        return \XLite\Core\Request::isMobileDevice() && parent::isVisible();
    }

    /**
     * Return list of targets allowed for this widget
     *
     * @return array
     */
    public static function getAllowedTargets()
    {
        $result = parent::getAllowedTargets();
        $result[] = 'mobile_more';

        return $result;
    }

    /**
     * Determines to show "Compare" button
     *
     * @return boolean
     */
    public function showComparisonButton()
    {
        return $this->isModuleEnabled('ProductComparison', 'XC')
            && (bool) (\XLite\Module\XC\ProductComparison\Core\Data::getInstance()->getProductsCount());
    }

}
