{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Total item cell
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2013 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *
 * @ListChild (list="invoice.item", weight="40")
 *}
<td bgcolor="#CCCCCC" align="right" rowspan="2">{formatPrice(item.getTotal(),order.getCurrency())}</td>