{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Orders list items block
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2013 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *
 * @ListChild (list="orders.children", weight="20")
 *}
<ul IF="getPageData()" class="list">

  <li FOREACH="getPageData(),order" class="order-{order.order_id}">

    <div class="order-body-item">

      <div class="title">

        <ul class="order-body-item-spec">
          <li class="date">{formatTime(order.date)}</li>
          <li class="details">
            <widget
              class="\XLite\View\Button\Link"
              label="Details"
              location="{buildURL(#order#,##,_ARRAY_(#order_number#^order.orderNumber,#profile_id#^profile.profile_id))}"
              />
          </li>
          <li IF="showReorder(order)" class="reorder">
            <widget
              class="\XLite\View\Button\Link"
              label="Re-order"
              location="{buildURL(#cart#,#add_order#,_ARRAY_(#order_number#^order.orderNumber))}"
              />
          </li>
          <li class="order-shipping-status">
            <widget class="\XLite\View\OrderStatus" order="{order}" useWrapper="true" />
          </li>
        </ul>

        <ul class="order-body-item-spec2">
          <li class="orderid">{t(#Order ID#)}: <span class="orderid">#{order.getOrderNumber()}</span></li>
          <li class="total">{t(#Grand total#)}: <span class="sum">{formatPrice(order.getTotal(),order.getCurrency())}</span></li>
          {**
            *TODO divide main status into payment/shipping separated statuses

          <li class="order-payment-status"><widget template="common/order_payment_status.tpl" /></li>
          *}
        </ul>


      </div>

      <div class="order-body-items-list">

        <widget class="\XLite\View\OrderItemsShort" full="true" order="{order}" />

      <div>

    </div>

  </li>

</ul>
