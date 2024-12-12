{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Name item cell
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2014 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *
 * @ListChild (list="order.items.item", weight="10")
 *}
<td class="name" colspan="{getItemDescriptionCount()}">
  <a IF="item.getURL()" href="{item.getURL()}">{item.getName()}</a>
  <span IF="!item.getURL()">{item.getName()}</span>
  <span IF="!item.product.isPersistent()" class="deleted-product-note">({t(#deleted#)})</span>
  <div IF="isViewListVisible(#order.items.item.name#,_ARRAY_(#item#^item))" class="additional">
    <list name="order.items.item.name" item="{item}" />
  </div>
</td>
