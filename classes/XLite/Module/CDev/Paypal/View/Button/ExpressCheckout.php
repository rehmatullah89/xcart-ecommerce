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

namespace XLite\Module\CDev\Paypal\View\Button;

/**
 * Express Checkout button
 *
 * @ListChild (list="cart.panel.totals", weight="100")
 * @ListChild (list="minicart.horizontal.buttons", weight="100")
 */
class ExpressCheckout extends \XLite\View\Button\Link
{
    /**
     * Returns widget default template
     *
     * @return string
     */
    protected function getDefaultTemplate()
    {
        return 'modules/CDev/Paypal/button/express_checkout.tpl';
    }

    /**
     * Get widget template
     * 
     * @return string
     */
    protected function getTemplate()
    {
        return 'cart.panel.totals' == $this->viewListName
            ? 'modules/CDev/Paypal/button/cart_express_checkout.tpl'
            : $this->getDefaultTemplate();
    }

    /**
     * Returns true if widget is visible
     * 
     * @return boolean
     */
    protected function isVisible()
    {
        $cart = $this->getCart();
        return parent::isVisible()
            && $cart
            && (0 < $cart->getTotal())
            && $cart->checkCart()
            && \XLite\Module\CDev\Paypal\Main::isExpressCheckoutEnabled($cart);
    }

    /**
     * Get CSS class name
     * 
     * @return string
     */
    protected function getClass()
    {
        return 'pp-ec-button';
    }

    /**
     * defineWidgetParams 
     * 
     * @return void
     */
    protected function defineWidgetParams()
    {
        parent::defineWidgetParams();

        $this->widgetParams[self::PARAM_LOCATION] = new \XLite\Model\WidgetParam\String(
            'Redirect to',
            $this->buildURL(
                'checkout',
                'start_express_checkout'
            )
        );
    }

}
