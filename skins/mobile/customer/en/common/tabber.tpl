{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Tabber template
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2013 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}


<h1 IF="head">{t(head)}</h1>
<div class="tabbed-content-wrapper">
  <div class="tabs-container">
    <div class="page-tabs {getTabPageCSS()}" data-role="navbar">

      <ul>
        <li FOREACH="getTabberPages(),tabPage">
          <a IF="tabPage.selected" href="{tabPage.url}" data-theme="b" class="ui-btn-active ui-state-persist" rel="external">{t(tabPage.title)}</a>
          <a IF="!tabPage.selected" href="{tabPage.url}" data-theme="a" class="" rel="external">{t(tabPage.title)}</a>
        </li>
      </ul>

    </div>

    <div class="tab-content">
      <widget template="{getParam(#body#)}" />
    </div>

  </div>
</div>
