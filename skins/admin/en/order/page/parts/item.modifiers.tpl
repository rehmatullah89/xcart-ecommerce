{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Total item cell
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2013 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *
 * @ListChild (list="order.items.item", weight="40")
 *}
<td FOREACH="item.getThroughExcludeSurcharges(),surcharge" class="modifier {surcharge.getType()}-modifier" rowspan="2">
  {if:surcharge}
    {formatPrice(surcharge.getValue(),order.getCurrency())}
  {else:}
    -
  {end:}
</td>
