{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Orders search Order ID condition
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2013 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *
 * @ListChild (list="orders.search.conditions", weight="30")
 *}
<tr class="status">
  <td class="title">{t(#Status#)}:</td>
  <td height="10">
    <widget class="\XLite\View\FormField\Select\OrderStatus" fieldOnly=true fieldName="status" value="{getCondition(#status#)}" allOption />
  </td>
  <td>&nbsp;</td>
</tr>
