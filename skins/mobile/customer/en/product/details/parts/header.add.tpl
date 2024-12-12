{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Save cell
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2013 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *
 * @ListChild (list="product.details.page.mobile.header", weight="200")
 *}
{if:!isCatalogModeEnabled()}
<li data-theme="b" class="add-to-cart-button-top{if:!isProductAvailableForSale()} ui-disabled{end:}">
  <a href="{buildURL(#product#,##,_ARRAY_(#product_id#^product.product_id,#category_id#^getCategoryId()))}" onclick="javascript: return !jQuery('form.product-details').submit();">
    <span class="currency">{formatPrice(getListPrice(),null,1):h}</span>
    {if:!isProductAdded()}{t(#Add to bag#)}{else:}{t(#Buy more#)}{end:}
  </a>
</li>
{end:}