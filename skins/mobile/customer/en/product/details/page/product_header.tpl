{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Product details header section
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2013 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}

<div class="top-info ui-body ui-body-b ui-overlay-shadow">

  <div class="ui-grid-solo">
    <div class="ui-block-a">
      <h1>{product.name:h}</h1>
    </div>
  </div>

  <div class="ui-grid-a">

    <div class="ui-block-a">

      <div IF="product.getSKU()" class="sku{if:isShowMarketPrice()} save-mark-here{end:}">
        {product.sku}
      </div>

      <div class="product-quantity-text-top{if:!isOutOfStock()} in-stock{end:}">
        {if:isOutOfStock()}{t(#Out of Stock#)}{else:}{t(#In stock#)}{end:}
      </div>
      <div class="out-of-stock-message hidden-element">{t(#Out of stock#)}</div>
      <div class="in-stock-message hidden-element">{t(#In stock#)}</div>
    </div>


    <div class="ui-block-b">
      <div class="right-block">

        <ul data-role="listview" data-inset="true">
          <list name="product.details.page.mobile.header" />
         </ul>

       </div>
     </div>

   </div>
</div>
