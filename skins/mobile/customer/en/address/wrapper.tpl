{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * ____file_title____
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2013 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}


<li class="address-book" >

  <div class="ui-body ui-body-c" IF="{address.getAddressId()}">

    <widget template="address/text/body.tpl" />

    <widget
      class="\XLite\View\Button\Link"
      label="{t(#Change#)}"
      location="{buildURL(#address_book#,##,_ARRAY_(#widget#^#\XLite\View\Address\Modify#,#address_id#^address.getAddressId(),#body#^#dialog#))}"
      dataRel="dialog" />

    <div class="delete-action">
      <widget
        class="\XLite\View\Button\Link"
        location="{buildURL(#address_book#,#delete#,_ARRAY_(#address_id#^address.getAddressId()))}"
        dataIcon="delete"
        dataIconPos="notext"
        dataTheme="f"
        label="{t(#Delete#)}" />
    </div>

    <div class="address-icons">
      <img
        src="images/icon_billing.png"
        title="{t(#This address was used as a billing address during the recent purchase#)}"
        class="address-type-icon"
        IF="{address.getIsBilling()}"
        alt="" />
      <img
        src="images/icon_shipping.png"
        title="{t(#This address was used as a shipping address during the recent purchase#)}"
        class="address-type-icon"
        IF="{address.getIsShipping()}"
        alt="" />
      <div IF="{address.getIsBilling()|address.getIsShipping()}">
        <span>{t(#This address was used as a#)}</span>
        <span IF="{address.getIsBilling()}">
          {t(#billing#)}
        </span>
        <span IF="{address.getIsShipping()}">
          {t(#shipping#)}
        </span>
        <span>{t(#address during the recent purchase#)}</span>
      </div>
    </div>

  </div>

  <div class="address-center-button" IF="{!address.getAddressId()}">
    <widget
      class="\XLite\View\Button\Link"
      label="{t(#Add new address#)}"
      location="{buildURL(#address_book#,##,_ARRAY_(#widget#^#\XLite\View\Address\Modify#,#profile_id#^profile_id,#body#^#dialog#))}"
      dataTheme="b"
      dataRel="dialog" />
  </div>

</li>
