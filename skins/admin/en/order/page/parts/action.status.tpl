{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Order status selector
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2013 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *
 * @ListChild (list="order.actions", weight="100")
 *}

<div class="status">
  <widget
    class="\XLite\View\FormField\Select\OrderStatus"
    label="Status"
    fieldName="status"
    value="{order.getStatus()}"
    orderId="{order.getOrderId()}" />
</div>
