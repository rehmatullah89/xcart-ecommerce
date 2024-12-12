{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Order : line 2
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2013 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *
 * @ListChild (list="order.operations", weight="200")
 *}

<div class="line-2">

  <div class="payment" IF="order.getVisiblePaymentMethods()">
    <h2>{t(#Payment info#)}</h2>
    <div class="box"><list name="order.payment" /></div>
  </div>

  <div class="shipping" IF="getShippingModifier()&shippingModifier.getMethod()">
    <h2>{t(#Shipping info#)}</h2>
    <div class="box"><list name="order.shipping" /></div>
  </div>

  <div class="clear"></div>
</div>
