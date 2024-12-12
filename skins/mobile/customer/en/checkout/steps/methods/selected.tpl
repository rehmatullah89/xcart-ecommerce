{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Shipping checkout step (selected)
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2013 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}

<list name="mobile.checkout.methods.selected" />

<widget class="\XLite\Module\XC\Mobile\View\Form\ShippingPaymentMethod" name="shippingPaymentMethod" className="shipping-payment-method" />
  <widget class="\XLite\View\Button\Submit" label="{t(#Continue#)}" dataTheme="b" dataIcon="arrow-r" dataIconPos="right" />
<widget name="shippingPaymentMethod" end />
