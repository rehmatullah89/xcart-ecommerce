{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Order's payment method
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2013 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *
 * @ListChild (list="order.payment", weight="100")
 *}

<div class="method" IF="order.getVisiblePaymentMethods()">
  <strong>{t(#Payment method#)}:</strong>
  <span>
    {foreach:order.getVisiblePaymentMethods(),m}
      {m.getTitle():h}<br />
    {end:}
  </span>
</div>
