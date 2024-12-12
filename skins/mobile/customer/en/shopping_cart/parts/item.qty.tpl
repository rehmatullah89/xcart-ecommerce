{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Shopping cart item : quantity
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2013 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *
 * @ListChild (list="cart.item.price-row", weight="20")
 *}

<div class="price-row">

  <widget
    class="\XLite\View\Form\Cart\Item\Update"
    item="{item}"
    name="updateItem{item.getItemId()}"
    className="price-parts update-quantity"
    validationEngine />

  <widget
    class="\XLite\View\Product\QuantityBox"
    product="{item.getProduct()}"
    fieldValue="{item.getAmount()}"
    isCartPage="{#1#}" />

  <widget name="updateItem{item.getItemId()}" end />

  <div class="price-parts multi">=</div>

</div>