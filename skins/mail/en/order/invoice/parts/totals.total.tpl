{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Invoice totals : total
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2013 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *
 * @ListChild (list="invoice.base.totals", weight="300")
 *}
<tr bgcolor="grey">
  <td class="title"><strong>{t(#Grand total#)}:</strong></td>
  <td align="right"><strong>{formatPrice(order.getTotal(),order.getCurrency())}</strong></td>
</tr>
