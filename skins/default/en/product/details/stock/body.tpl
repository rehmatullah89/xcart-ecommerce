{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Product stock
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2013 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}

<div class="product-stock {getFingerprint()}">
  <span class="stock-level product-in-stock" IF="isInStock()">
    <span class="in-stock-label">{t(#In stock#)}</span>
    <span class="product-items-available">({t(#X items available#,_ARRAY_(#count#^getAvailableAmount()))})</span>
  </span>
  <span class="stock-level product-out-of-stock" IF="isOutOfStock()">{getOutOfStockMessage()}</span>
</div>
