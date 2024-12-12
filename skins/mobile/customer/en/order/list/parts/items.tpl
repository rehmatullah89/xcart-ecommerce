{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Orders list items block
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2013 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}

<table IF="getPageData()" data-role="table" data-mode="reflow" class="ui-responsive table-stroke order-list">
  <thead>
    <tr>
      <th data-priority="1">{t(#Order ID#)}</th>
      <th data-priority="persist">{t(#Date#)}</th>
      <th data-priority="2">{t(#Total#)}</th>
      <th data-priority="3">{t(#Content#)}</th>
      <th data-priority="4">{t(#Status#)}</th>
      <th data-priority="5">&nbsp;</th>
    </tr>
  </thead>
  
  <tbody>
    <tr FOREACH="getPageData(),order">
      <td class="orderid">#{order.getOrderNumber()}</td>
      <td class="date">{formatTime(order.date)}</td>
      <td class="total">{formatPrice(order.getTotal(),order.getCurrency())}</td>
      <td class="items-ordered"><widget class="\XLite\View\OrderItemsShort" full="true" order="{order}" /></td>
      <td class="status"><widget class="\XLite\View\OrderStatus" order="{order}" useWrapper="true" /></td>
      <td class="buttons">
        <div>
          <widget
            class="\XLite\View\Button\Link"
            label="{t(#Details#)}"
            location="{buildURL(#order#,##,_ARRAY_(#order_number#^order.orderNumber,#profile_id#^profile.profile_id))}"
            dataRel="external"
            />
          <span IF="showReorder(order)" class="reorder">
            <widget
              class="\XLite\View\Button\Link"
              label="{t(#Re-order#)}"
              location="{buildURL(#cart#,#add_order#,_ARRAY_(#order_number#^order.orderNumber))}"
              dataRel="external"
              />
          </span>
        </div>
      </td>
      {**
          *TODO divide main status into payment/shipping separated statuses

        <td class="order-payment-status"><widget template="common/order_payment_status.tpl" /></td>
        *}
    </tr>
  </tbody>
</table>
