{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Shopping cart totals panel
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2013 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}

<div class="ui-grid-a panel-totals">

  <div class="ui-block-a">
    <list name="cart.buttons" />
    <list name="cart.panel.box" />
  </div>

  <div class="cart-block-totals">
    <ul class="totals">
      <list name="cart.panel.totals" />
    </ul>
  </div>

  <div class="checkout-button" IF="cart.checkCart()">
    <a href="{buildURL(#checkout#)}" data-role="button" class="big-button" data-mini="false" data-theme="b" data-icon="arrow-r" data-iconpos="right">
      <span class="currency">
        <widget class="XLite\View\Surcharge" surcharge="{cart.getTotal()}" currency="{cart.getCurrency()}" />
      </span>
      {t(#Checkout#)}
    </a>
  </div>
</div>
