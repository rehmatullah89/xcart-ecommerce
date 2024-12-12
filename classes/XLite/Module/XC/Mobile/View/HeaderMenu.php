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
 * @ListChild (list="mobile.page.header", weight="100")
 */
class HeaderMenu extends \XLite\View\AView
{

    /**
     * Return default template
     *
     * @return string
     */
    protected function getDefaultTemplate()
    {
        return 'layout/header/header.menu.tpl';

    }

    /**
     * Return cart quantity amount
     *
     * @return string
     */
    public function getCartQuantity()
    {
        return \XLite\Model\Cart::getInstance()->countQuantity();
    }

    /**
     * Determine home tab activity
     *
     * @return boolean
     */
    protected function isHomeTab()
    {
        return \XLite::getController()->getTarget() == \XLite::TARGET_DEFAULT;
    }

    /**
     * Determine catalog tab activity
     *
     * @return boolean
     */
    protected function isCatalogTab()
    {
        $controller = \XLite::getController();
        return $controller instanceof \XLite\Controller\Customer\Category 
            && $this->getCategoryId() !== $this->getRootCategoryId()
            || $controller instanceof \XLite\Controller\Customer\MobileCatalog 
            || $controller instanceof \XLite\Controller\Customer\Product;
    }

    /**
     * Determine search tab activity
     *
     * @return boolean
     */
    protected function isSearchTab()
    {
        return \XLite::getController() instanceof \XLite\Controller\Customer\Search;
    }

    /**
     * Determine cart tab activity
     *
     * @return boolean
     */
    protected function isCartTab()
    {
        return 
            \XLite::getController() 
             instanceof \XLite\Controller\Customer\Cart 
            || \XLite::getController() 
                instanceof \XLite\Controller\Customer\Checkout 
            || \XLite::getController() 
                instanceof \XLite\Controller\Customer\CheckoutFailed 
            || \XLite::getController() 
                instanceof \XLite\Controller\Customer\CheckoutSuccess;
    }

    /**
     * Determine cart tab activity
     *
     * @return boolean
     */
    protected function isMoreTab()
    {
        return
            \XLite::getController()
             instanceof \XLite\Controller\Customer\MobileMore 
             || !($this->isHomeTab() 
             || $this->isCatalogTab()
             || $this->isSearchTab()
             || $this->isCartTab());
    }

    /**
     * Return CSS-classes string for an active navigation tab
     *
     * @return string
     */
    public function setActiveTab($item)
    {
        $active = 'is' . ucfirst($item) . 'Tab';

        return $this->$active() ? 'ui-btn-active ui-state-persist' : '';
    }

}