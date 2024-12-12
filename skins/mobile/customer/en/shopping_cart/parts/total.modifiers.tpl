{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Shopping cart modifiers
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2013 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}


<li FOREACH="getSurchargeTotals(),sType,surcharge" class="{getSurchargeClassName(sType,surcharge)}">
  <strong IF="surcharge.count=#1#">{surcharge.lastName}:</strong>
  <strong IF="!surcharge.count=#1#" class="list-owner">{surcharge.name}:</strong>

  <span IF="surcharge.available" class="value"><widget class="XLite\View\Surcharge" surcharge="{surcharge.cost}" currency="{cart.getCurrency()}" /></span>
  <span IF="!surcharge.available">{t(#n/a#)}</span>

  <list IF="surcharge.count=#1#" name="modifier" type="nested" surcharge="{surcharge}" sType="{sType}" cart="{cart}" />
  <div IF="!surcharge.count=#1#" class="order-modifier-details display-none">
    <ul>
      <li FOREACH="getExcludeSurchargesByType(sType),row">
        <span class="name">{row.getName()}:</span>
        <span class="value"><widget class="XLite\View\Surcharge" surcharge="{row.getValue()}" currency="{cart.getCurrency()}" /></span>
      </li>
    </ul>
  </div>
</li>
