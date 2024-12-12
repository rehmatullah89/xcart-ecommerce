{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Billing adddress
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2013 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}


<div class="same-address">
  <input type="hidden" name="same_address" value="0" />
  <input id="same_address" type="checkbox" name="same_address" value="1" checked="{isSameAddress()}" />
  <label for="same_address">{t(#Billing address is the same as Shipping#)}</label>
</div>

<div class="billing-address-form {if:isSameAddressVisible()}display-none{end:}">
  <widget
    IF="isDisplayAddressButton()"
    class="\XLite\View\Button\Link"
    label="Address book"
    location="{buildURL(#select_address#,##,_ARRAY_(#atype#^#b#))}"
    style="address-book" />

  <h3>{t(#Complete billing address#)}</h3>

  <ul class="form">
    <list name="checkout.payment.address.before" address="{getAddressInfo()}" />
      <li FOREACH="getAddressFields(),fieldName,fieldData" class="item-{fieldName} clearfix">
        <widget
          class="{fieldData.class}"
          attributes="{getFieldAttributes(fieldName,fieldData)}"
          label="{fieldData.label}"
          fieldName="{getFieldFullName(fieldName)}"
          stateSelectorId="billingaddress-state-id"
          stateInputId="billingaddress-custom-state"
          value="{getFieldValue(fieldName)}"
          comment="{fieldData.comment}"
          placeholder="{getFieldPlaceholder(fieldName)}"
          required="{fieldData.required}" />
        <list name="checkout.payment.address.{fieldName}" address="{getAddressInfo()}" fieldName="{fieldName}" fieldData="{fieldData}" />
      </li>
    <list name="checkout.payment.address.after" address="{getAddressInfo()}" />
  </ul>

</div>