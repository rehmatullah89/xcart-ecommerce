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


namespace XLite\Module\XC\Mobile\View\Checkout;

/**
 * Payment methods list
 *
 * @ListChild (list="mobile.checkout.methods.selected.sub.payment", weight="300")
 */
class PaymentMethodsList extends \XLite\View\Checkout\PaymentMethodsList implements \XLite\Base\IDecorator
{
    /**
     * Return widget default template
     *
     * @return string
     */
    protected function getDefaultTemplate()
    {
        return \XLite\Core\Request::isMobileDevice()
            ? 'checkout/steps/methods/parts/paymentMethods.tpl'
            : parent::getDefaultTemplate();
    }

    /**
     * Check if widget is visible
     *
     * @return boolean
     */
    protected function isVisible()
    {
        $result = parent::isVisible();
        if ($result && \XLite\Core\Request::isMobileDevice()) {
            // In mobile skin this widget will not be visible on the 'checkout.shipping.selected.sub.payment' list
            $result = ('mobile.checkout.methods.selected.sub.payment' ==  $this->viewListName);
        }

        return $result;
    }

}
