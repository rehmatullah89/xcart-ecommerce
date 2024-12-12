{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Invoice totals : modifiers
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2013 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *
 * @ListChild (list="order.base.totals", weight="200")
 *}

<tr FOREACH="getSurchargeTotals(),sType,surcharge" class="{getSurchargeClassName(sType,surcharge)}">
  {if:surcharge.count=#1#}
    <td class="title">
      {surcharge.lastName}:
      <list name="order.base.totals.modifier.name" surcharge="{surcharge}" sType="{sType}" order="{order}" />
    </td>
  {else:}
    <td class="title list-owner">
      {surcharge.name}:
      <list name="order.base.totals.modifier.name" surcharge="{surcharge}" sType="{sType}" order="{order}" />
    </td>
  {end:}
  <td class="value">
    {if:surcharge.available}
      {formatSurcharge(surcharge)}
    {else:}
      {t(#n/a#)}
    {end:}
    <list name="order.base.totals.modifier.value" surcharge="{surcharge}" sType="{sType}" order="{order}" />
  </td>
</tr>
