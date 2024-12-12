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
 * Header menu widget
 *
 *
 * @ListChild (list="mobile.page.header", weight="200")
 * @ListChild (list="mobile.dialog.header", weight="100")
 * @ListChild (list="mobile.popup.header", weight="100")
 */
class MobileTitle extends \XLite\View\AView
{

    /**
     * Return widget default template
     *
     * @return string
     */
    protected function getDefaultTemplate()
    {
        return 'dialog' == \XLite\Core\Request::getInstance()->body
            ? 'layout/header/header.dialog.title.tpl'
            : 'layout/header/header.title.tpl';
    }

    /**
     * Return title for mobile header
     *
     * @return string
     */
    public function getMobileTitle()
    {
        $currentLocation = $this->getLocationPath();
        $currentTitle = array_pop($currentLocation)->name;

        if (empty($currentTitle)) {
            if (\XLite::TARGET_DEFAULT == \XLite::getController()->getTarget()) {
                // Home page
                $currentTitle = \XLite\Core\Config::getInstance()->Company->company_name;
            } elseif (\XLite::getController() instanceof \XLite\Controller\Customer\MobileCatalog) {
                // Root categories page
                $currentTitle = static::t('Catalog');
            } elseif (\XLite::getController() instanceof \XLite\Controller\Customer\MobileMore) {
                // More page
                $currentTitle = static::t('More');
            }
        }

        return $currentTitle;
    }

    /**
     * Return URL for back button
     *
     * @return string
     */
    public function getBackURL()
    {
        $url = \XLite\Core\Session::getInstance()->continueShoppingURL
            ? \XLite\Core\Session::getInstance()->continueShoppingURL
            : $_SERVER['HTTP_REFERER'];

        return $url ? $url : 'javascript: self.history.go(-1);';
    }
}