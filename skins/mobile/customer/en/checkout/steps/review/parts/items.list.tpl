{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Checkout : order review step : items : list
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2013 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}

<div class="orders-wrapper" IF="showFirst">
  <ul class="ui-body-e order-list">
    <li FOREACH="cart.getItems(),item">
      <span class="name">{item.getName()}</span>
      <span class="qty">&times; {item.getAmount()}</span>
    </li>
  </ul>
</div>
