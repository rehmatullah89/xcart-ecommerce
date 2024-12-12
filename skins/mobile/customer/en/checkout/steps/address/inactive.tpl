{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Order review checkout step (inactive)
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2013 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}

<div class="ui-grid-a">
  <div class="ui-block-a">
    <h3>{t(#Shipping address#)}</h3>
    <widget IF="isAddressCompleted()" template="checkout/parts/address.plain.tpl" address="{cart.profile.getBillingAddress()}" />
    <p IF="!isAddressCompleted()" class="address-not-defined">{t(#Billing address is not defined yet#)}</p>
  </div>

  <div class="ui-block-b">
    <h3>{t(#Billing address#)}</h3>
    <widget IF="isAddressCompleted()" template="checkout/parts/address.plain.tpl" address="{cart.profile.getShippingAddress()}" />
    <p IF="!isAddressCompleted()" class="address-not-defined">{t(#Shipping address is not defined yet#)}</p>
  </div>
</div>

<div class="ui-grid-solo">
  <div class="ui-block-a">
    <widget class="\XLite\View\Button\Link" label="{t(#Change address#)}" location="{buildURL(#checkout#,##,_ARRAY_(#step#^#address#))}" dataInline="false" />
  </div>
</div>
