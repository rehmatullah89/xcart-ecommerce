{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Invoice totals : subtotal
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2013 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *
 * @ListChild (list="order.base.totals", weight="100")
 *}
<tr>
  <td class="title">{t(#Subtotal#)}:</td>
  <td class="value">{formatPrice(order.getSubtotal(),order.getCurrency())}</td>
</tr>
