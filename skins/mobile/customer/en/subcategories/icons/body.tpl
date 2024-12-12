{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Subcategories list (grid style)
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2013 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}


<ul data-role="listview" class="categories-list" IF="getSubcategories()">
  {foreach:getSubcategories(),subcategory}
    <li IF="subcategory.hasAvailableMembership()">
      <a href="{buildURL(#category#,##,_ARRAY_(#category_id#^subcategory.category_id))}" data-transition="slide">
        <span class="ui-li-thumb">
          <widget class="\XLite\View\Image" image="{subcategory.image}" maxWidth="80" maxHeight="80" verticalAlign="middle" className="list" centerImage="0" />
          <img src="images/spacer.gif" class="leveler" alt="" />
        </span>
        <h2 class="subcategory-name">{subcategory.name}</h2>
        <span IF="countProducts(subcategory)" class="ui-li-count">{countProducts(subcategory)}</span>
      </a>
    </li>
  {end:}
  <li FOREACH="getNestedViewList(#children#),item">{item.display()}</li>
</ul>
<list name="subcategories.base" />
