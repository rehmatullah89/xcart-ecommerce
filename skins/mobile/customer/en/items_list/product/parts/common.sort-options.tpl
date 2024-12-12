{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Products list sorting control
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2013 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}


<div IF="isSortBySelectorVisible()" class="sort-box">
  <select 
    class="sort-crit" 
    id="{getSortWidgetId(true)}" 
    onchange="jQuery.mobile.changePage(this.value);" 
    data-theme="a" 
    data-icon="bars">
    {if:isSearchPage()}
    <option
      FOREACH="sortByModes,key,name" 
      value="{buildURL(#search#,##,_ARRAY_(#sortBy#^key))}"
      selected="{isSortByModeSelected(key)}">
      {t(name)}
    </option>      
    {else:}
    <option
      FOREACH="sortByModes,key,name" 
      value="{buildURL(#category#,##,_ARRAY_(#category_id#^getCategoryId(),#sortBy#^key))}" 
      selected="{isSortByModeSelected(key)}">
      {t(name)}
    </option>
    {end:}
  </select>
</div>