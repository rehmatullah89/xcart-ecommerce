{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Invoice billing address
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2013 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *
 * @ListChild (list="invoice.bottom.address", weight="20")
 *}
<td class="bill" IF="order.profile&order.profile.getBillingAddress()">
  <strong>{t(#Billing address#)}</strong>

  <ul class="address-section billing-address-section">
    <li FOREACH="getAddressSectionData(order.profile.billing_address),idx,field" class="{field.css_class} address-field">
      <span class="address-title">{t(field.title)}:</span>
      <span class="address-field">{field.value}</span>
      <span class="address-comma">,</span>
    </li>
  </ul>

  <p>
    {t(#E-mail#)}: <a href="mailto:{order.profile.login}">{order.profile.login}</a>
  </p>

</td>
