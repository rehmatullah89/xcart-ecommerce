{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * ____file_title____
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2013 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *
 * @ListChild (list="marketplace.top-controls", weight="350")
 *}

<div IF="isVisibleAddonFilters()" class="addons-filters">

  <div class="addons-selectors">

  <form name="addons-filter" method="GET" action="admin.php">
  <widget class="\XLite\View\FormField\Input\FormId" />
  <input FOREACH="getURLParams(),name,value" type="hidden" name="{name}" value="{value}" />

  <div class="addons-sort-box">
    <widget
      class="\XLite\View\FormField\Select\AddonsSort"
      fieldId="addons-sort"
      fieldName="addonsSort"
      options="{getSortOptionsForSelector()}"
      value="{getSortOptionsValueForSelector()}"
      attributes="{_ARRAY_(#data-classes#^#addons-sort#,#data-height#^#100%#)}"
    />
  </div>

  <div class="tag-filter-box">
    <widget
      class="\XLite\View\FormField\Select\AddonsSort"
      fieldId="tag-filter"
      fieldName="tag"
      options="{getTagOptionsForSelector()}"
      value="{getTagOptionsValueForSelector()}"
      attributes="{_ARRAY_(#data-classes#^#tag-filter#,#data-height#^#100%#)}"
    />
  </div>

  </form>

  </div>

  <div class="addons-search-box">

    <widget class="\XLite\View\Form\Module\Install" formMethod="GET" className="search-form" name="install_search" />
      <div class="substring">
        <widget
          class="\XLite\View\FormField\Input\Text"
          fieldOnly=true
          fieldName="substring"
          value="{getParam(#substring#)}"
          defaultValue="{t(#Search for modules#)}" />
        <widget class="\XLite\View\Button\Submit" label="" />
      </div>
    <widget name="install_search" end />

  </div>

  <div class="clear"></div>

</div>
