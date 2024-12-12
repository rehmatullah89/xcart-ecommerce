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


namespace XLite\Module\XC\Mobile\View\Product\Details\Customer\Page;

/**
 * Header menu widget
 *
 * @ListChild (list="product.details.page", weight="1")
 */
class ProductHeader extends \XLite\View\Price
{
    /**
     * Get product
     *
     * @return \XLite\Model\Product
     */
    protected function getProduct()
    {
        $this->setWidgetParams(array(
            \XLite\View\Product\Details\Customer\Widget::PARAM_PRODUCT_ID => \XLite\Core\Request::getInstance()->product_id,
        ));

        return parent::getProduct();
    }
    
    /**
     * Return widget default template
     *
     * @return string
     */
    protected function isVisible()
    {
        return \XLite\Core\Request::isMobileDevice();
    }

    /**
     * Return widget default template
     *
     * @return string
     */
    protected function getDefaultTemplate()
    {
        return (\XLite\Core\Request::isMobileDevice()) 
            ? 'product/details/page/product_header.tpl' 
            : parent::getDefaultTemplate();
    }

    /**
     * Get the "You save" value in percents
     *
     * @param \XLite\Model\Product $product Current product
     *
     * @return float
     */
    protected function getYouSaveValue()
    {
        $priceDifference = $this->isModuleEnabled('MarketPrice')
            ? $this->getWidget(
                array(
                    'product' => $this->getProduct()
                ),
                'XLite\View\Price'
            )->getSaveDifference()
            : 0;
        
        return $priceDifference > 0
            ? min(99,round(($priceDifference / $this->getProduct()->getMarketPrice()) * 100))
            : 0;
    }
    
    /**
     * Determine if we need to display product market price
     *
     * @return boolean
     */
    protected function isShowMarketPrice()
    {
        return $this->isModuleEnabled('MarketPrice')
            ? 0 < $this->getListPrice() 
                && $this->getProduct()->getMarketPrice() > $this->getListPrice()
            : false;
    }
}