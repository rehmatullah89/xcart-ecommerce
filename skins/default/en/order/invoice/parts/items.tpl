{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Invoice items
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2013 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *
 * @ListChild (list="invoice.base", weight="30")
 *}
<table cellspacing="0" class="items">

  <tr>
    <list name="invoice.items.head" />
  </tr>
  <tr class="last-row">
    <list name="invoice.items.subhead" />
  </tr>
  <tr class="separator">
    <td colspan="{getColumnsSpan()}"><img src="images/spacer.gif" alt="" /></td>
  </tr>

  {foreach:order.getItems(),index,item}
    <tr>
      <list name="invoice.item" item="{item}" />
    </tr>
    <tr>
      <list name="invoice.subitem" item="{item}" />
    </tr>
    <tr IF="!itemArrayPointer=itemArraySize" class="separator">
      <td colspan="{getColumnsSpan()}"><img src="images/spacer.gif" alt="" /></td>
    </tr>
  {end:}

  <tr FOREACH="getViewList(#invoice.items#),w">
    {w.display()}
  </tr>

</table>
