{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Shopping cart items block
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2013 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}

<div class="ui-grid-a">
  <div class="ui-block-a continue-shopping-button">
    <widget class="XLite\View\Button\ContinueShopping" />
  </div>
  <div class="ui-block-b checkout-button">
    <a
      href="{buildURL(#checkout#)}"
      data-role="button"
      class="big-button"
      data-mini="false"
      data-theme="b"
      data-icon="arrow-r"
      data-iconpos="right">
        <span class="currency">
          <widget
            class="XLite\View\Surcharge"
            surcharge="{cart.getTotal()}"
            currency="{cart.getCurrency()}" />
        </span>
        {t(#Checkout#)}
    </a>
  </div>
</div>

<ul data-role="listview" class="cart-products">
  <li FOREACH="cart.getItems(),item">

    <div class="cart-item">

      <div class="product-thumbnail">
        <div class="img-wrapper">
          <widget
            class="\XLite\View\Image"
            image="{item.getImage()}"
            maxWidth="136"
            maxHeight="136"
            alt="{item.getName()}"
            verticalAlign="top"
            className="list"
            centerImage=0 />
        </div>
      </div>

      <div class="product-details">
        <list name="cart.item" item="{item}" />
      </div>

      <div class="price-row-wrapper">
        <list name="cart.item.price-row" item="{item}" />
      </div>

      <widget IF="isModuleEnabled(#ProductOptions#)" template="shopping_cart/parts/selected.options.tpl" />

    </div>

    <widget class="\XLite\View\Form\Cart\Item\Delete" name="itemRemove{item.getItemId()}" item="{item}" />
      <div class="delete-button">
        <widget
          class="\XLite\View\Button\Submit"
          label="Delete item"
          dataTheme="c"
          dataIcon="delete"
          dataIconPos="notext" />
      </div>
    <widget name="itemRemove{item.getItemId()}" end />

  </li>
</ul>