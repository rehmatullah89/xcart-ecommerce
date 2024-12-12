{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Order : items
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2013 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *
 * @ListChild (list="order.items", weight="100")
 *}

<table cellspacing="0" class="items">

  <thead>
    <tr><list name="order.items.head" /></tr>
    <tr class="last-row"><list name="order.items.subhead" /></tr>
  </thead>

  <tbody>

    {foreach:order.getItems(),index,item}
      <tr><list name="order.items.item" item="{item}" /></tr>
      <tr><list name="order.items.subitem" item="{item}" /></tr>
    {end:}

    <tr FOREACH="getViewList(#order.items.items#),w">
      {w.display()}
    </tr>

  </tbody>

</table>
