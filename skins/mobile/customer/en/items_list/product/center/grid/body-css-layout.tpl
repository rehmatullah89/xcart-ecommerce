{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Products list (grid variant)
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2013 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}

<div class="products content-secondary">

  <ul class="products-list" data-role="listview" data-divider-theme="c" IF="getPageData()">

    <li IF="getHead()" data-role="list-divider" role="heading">
      <h2>{t(getHead())}</h2>
    </li>

    <li FOREACH="getPageData(),product" class="product-cell {getProductCellClass(product)}">

      <a href="{buildURL(#product#,##,_ARRAY_(#product_id#^product.product_id,#category_id#^category_id))}" data-transition="slide">

        <div class="image-box">
          <list name="photo" type="inherited" product="{product}" />
        </div>

        <div class="product-details">
          <list name="info" type="inherited" product="{product}" />
        </div>

      </a>

    </li>
  </ul>

  <div class="clearing"></div>

  <div class="products-grid show-more-link" IF="isShowMoreLink()">
    <widget class="\XLite\View\Button\Link" label="{getMoreLinkText()}" location="{getMoreLinkURL()}" />
  </div>

</div>
