{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Order review checkout step (selected)
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2013 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}

<widget
  IF="isDisplayAddressButton()"
  class="\XLite\View\Button\Link"
  label="{t(#Address book#)}"
  location="{buildURL(#select_address#,##,_ARRAY_(#atype#^#s#))}" />

<widget class="\XLite\View\Form\Checkout\UpdateProfile" name="addresses" className="address shipping-address" />

  <widget class="\XLite\View\Checkout\ShippingAddress" />

  <div IF="isDisplayAddressButton()" class="save">
    <input type="checkbox" id="save_shipping_address" name="shippingAddress[save_as_new]" value="1" />
    <label for="save_shipping_address">{t(#Save as new#)}</label>
  </div>

  <widget class="\XLite\View\Checkout\BillingAddress" />

  <widget class="\XLite\View\Button\Submit" label="{t(#Continue#)}" dataTheme="b" dataIcon="arrow-r" dataIconPos="right" />

<widget name="addresses" end />