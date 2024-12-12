{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Shopping cart item : price
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2013 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *
 * @ListChild (list="cart.item.price-row", weight="10")
 *}

<div class="price-row">

  <span class="price-parts product-price-value">
    <widget class="XLite\View\Surcharge" surcharge="{item.getNetPrice()}" currency="{cart.getCurrency()}" />
  </span>
  <span class="price-parts multi">
    &times;
  </span>

</div>