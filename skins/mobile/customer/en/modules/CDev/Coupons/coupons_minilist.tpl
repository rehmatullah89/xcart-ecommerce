{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Discount coupon subpanel
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2013 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}

<form action="{buildURL(#coupon#)}" method="post" data-ajax="false" accept-charset="utf-8">
  <input type="hidden" name="action" value="remove" />
  <input type="hidden" name="returnURL" value="{getURL()}" />
<ul IF="isDiscountCouponSubpanelVisible(surcharge)" class="discount-coupons-panel">
  <li FOREACH="getDiscountCoupons(),usedCoupon">
    <button
      IF="isDiscountCouponRemoveVisible()"
      data-role="button"
      data-icon="delete"
      data-iconpos="notext"
      data-mini="true"
      data-inline="true"
      data-corners="true"
      data-shadow="true"
      data-iconshadow="true"
      data-wrapperels="span"
      data-theme="c"
      title="{t(#Remove#)}"
      name="id"
      value="{usedCoupon.getId()}"
      type="submit"></button>
    <span>{usedCoupon.getPublicCode()}</span>
  </li>
</ul>
</form>
