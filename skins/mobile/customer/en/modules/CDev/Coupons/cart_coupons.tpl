{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Cart coupons
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2014 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}


<div class="coupons">

  <widget
    IF="!getCoupons()"
    class="\XLite\Module\XC\Mobile\View\Button\PopupLinkButton"
    label="{t(#Have a discount coupon?#)}"
    dataTheme="e"
    dataMini="false"
    dataPopupPosition="window"
    dataTransition="slidedown"
    location="#add-coupon" />
  <widget
    IF="getCoupons()"
    class="\XLite\Module\XC\Mobile\View\Button\PopupLinkButton"
    label="{t(#Have more coupons?#)}"
    dataTheme="e"
    dataMini="false"
    dataPopupPosition="window"
    dataTransition="slidedown"
    location="#add-coupon" />

  <div class="add-coupon" id="add-coupon" data-role="popup" data-theme="c"  data-overlay-theme="a">

    <a href="#" data-rel="back" data-role="button" data-icon="delete" data-iconpos="notext" class="ui-btn-right">{t(#Close#)}</a>

    <div data-role="content">
      <h3>{t(#Enter coupon code#)}:</h3>
      <widget class="\XLite\Module\CDev\Coupons\View\Form\Customer\AddCoupon" name="addCoupon" />
        <input type="text" name="code" value="" maxlength="16" />
        <widget class="XLite\Module\CDev\Coupons\View\Button\AddCoupon" />
        <div class="clear"></div>
      <widget name="addCoupon" end />
    </div>
  </div>

</div>
