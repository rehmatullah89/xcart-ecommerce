{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Order's billing address
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2013 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *
 * @ListChild (list="order.payment", weight="200")
 *}

<div class="address" IF="order.profile&order.profile.getBillingAddress()">
  <strong>{t(#Billing address#)}</strong>

  <ul class="address-section payment-address-section">
    <li FOREACH="getAddressSectionData(order.profile.billing_address),idx,field" class="{field.css_class} address-field">
      <span class="address-title">{field.title}:</span>
      <span class="address-field">{field.value}</span>
      <span class="address-comma">,</span>
    </li>
  </ul>
</div>
