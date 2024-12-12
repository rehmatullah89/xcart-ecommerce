{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Mobile top menu
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2013 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}


<div data-role="navbar" data-iconpos="top" class="top-nav">
  <ul>
    <li><a
        class="link-home {setActiveTab(#home#)}"
        data-theme="a"
        data-icon="custom"
        href="{buildURL(#main#)}"
        data-prefetch><h3>{t(#Home#)}</h3>
    </a></li>
    <li><a
        class="link-catalog {setActiveTab(#catalog#)}"
        data-theme="a"
        data-icon="custom"
        href="{buildURL(#mobile_catalog#)}"
        data-prefetch><h3>{t(#Catalog#)}</h3>
    </a></li>
    <li><a
        class="link-search {setActiveTab(#search#)}"
        data-rel="popup"
        data-position-to="window"
        data-theme="a"
        data-icon="custom"
        href="#quick-search"
        data-transition="slidedown"><h3>{t(#Search#)}</h3>
    </a></li>
    <li IF="!isCatalogModeEnabled()" class="link-cart-wrapper"><a
        class="link-cart {setActiveTab(#cart#)}"
        data-theme="a"
        data-icon="custom"
        href="{buildURL(#cart#)}"
        data-prefetch><h3>{t(#Cart#)}</h3>
    </a><span class="minicart-total-items">{getCartQuantity()}</span>
    </li>
    <li><a
        class="link-more {setActiveTab(#more#)}"
        data-theme="a"
        data-icon="custom"
        href="{buildURL(#mobile_more#)}"
        data-prefetch><h3>{t(#More#)}</h3>
    </a></li>
  </ul>
</div>

{* Quick search popup. TODO: think about splitting this to a separate template *}
<div id="quick-search" data-role="popup" data-overlay-theme="a" data-theme="c" data-dismissible="false">
  <a href="#" data-rel="back" data-role="button" data-icon="delete" data-iconpos="notext" class="ui-btn-right">{t(#Close#)}</a>
  <widget class="\XLite\Module\XC\Mobile\View\MobileSearch" />
</div>