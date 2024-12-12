{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Name item cell
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2013 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *
 * @ListChild (list="invoice.item", weight="10")
 *}
<td bgcolor="#CCCCCC" class="name" colspan="{getItemDescriptionCount()}">
  <strong>{item.getName()}</strong>
  <div IF="isViewListVisible(#invoice.item.name#,_ARRAY_(#item#^item))" class="additional">
    <list name="invoice.item.name" item="{item}" />
  </div>
</td>
