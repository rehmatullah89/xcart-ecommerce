{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Pager
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2013 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}

<div class="ui-grid-b nav-grid" IF="isPagesListVisible()">

  <div class="ui-block-a">
    <a data-role="button" class="custom-arrow" data-icon="custom-arrow-l" data-theme="a" data-iconpos="notext" data-mini="false" data-inline="true" IF="isPrevActive()" href="{buildURLByPageId(getPreviousPageId())}"></a>
  </div>

  <div class="ui-block-b">
    <div class="nav-pages" IF="isItemsPerPageVisible()" data-inline="true">
      {getBeginRecordNumber()} - {getEndRecordNumber()} {t(#of#)} {getItemsTotal()}
    </div>
  </div>

  <div class="ui-block-c">
    <a class="custom-arrow" data-icon="custom-arrow-r" data-role="button" data-theme="a" data-iconpos="notext" data-inline="true" data-mini="false" IF="isNextActive()" href="{buildURLByPageId(getNextPageId())}"></a>
  </div>
</div>