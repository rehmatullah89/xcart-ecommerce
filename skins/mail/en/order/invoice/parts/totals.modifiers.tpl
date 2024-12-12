{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Invoice totals : modifiers
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2013 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *
 * @ListChild (list="invoice.base.totals", weight="200")
 *}

<tr FOREACH="order.getSurchargeTotals(),sType,surcharge" bgcolor="#CCCCCC" class="{sType}-modifier">
  {if:surcharge.count=#1#}
    <td class="title">{surcharge.lastName}:</td>
  {else:}
    <td class="title list-owner">{surcharge.name}:</td>
  {end:}
  <td align="right">
    {if:surcharge.available}
      {formatPrice(surcharge.cost,order.getCurrency())}
    {else:}
      {t(#n/a#)}
    {end:}
    <list name="invoice.base.totals.modifier" surcharge="{surcharge}" sType="{sType}" order="{order}" />
  </td>
</tr>
