{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Invoice shipping methods
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2013 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *
 * @ListChild (list="invoice.bottom.methods", weight="10")
 *}
<td class="shipping" IF="getShippingModifier()&shippingModifier.getMethod()">
  <br />
  <strong>{t(#Shipping method#)}:</strong>
  {shippingModifier.method.getName():h}
</td>
