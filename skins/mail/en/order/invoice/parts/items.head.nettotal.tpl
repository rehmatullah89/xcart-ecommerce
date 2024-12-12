{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Invoice items table head part : Net total column
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2013 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *
 * @ListChild (list="invoice.items.head", weight="20")
 *}
<th IF="order.getItemsExcludeSurcharges()" class="net-total" rowspan="2">{t(#Subtotal#)}</th>