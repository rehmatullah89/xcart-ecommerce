{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Invoice payment methods
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2013 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *
 * @ListChild (list="invoice.bottom.methods", weight="20")
 *}
<td class="payment" IF="order.getVisiblePaymentMethods()">
  <br />
  <strong>{t(#Payment method#)}:</strong>
  {foreach:order.getVisiblePaymentMethods(),m}
    {m.getTitle():h}<br />
  {end:}
</td>
