{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Order shipping status
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2014 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *
 * @ListChild (list="order.status", weight="10")
 *}
<div class="shipping order-status-{order.getStatus()}"><widget class="\XLite\View\OrderStatus" order="{getOrder()}" useWrapper="true" /></div>
