{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Shipping estimator box
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2013 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}

<div IF="isShippingEstimate()" class="estimate-box ui-body">
  <div class="link">
    <widget
      class="\XLite\View\Button\Link"
      label="{t(#Change#)}"
      dataTheme="c"
      dataMini="false"
      location="{buildURL(#shipping_estimate#)}" />
  </div>

  <ul class="estimated-for">
    <li>
      <strong>{t(#Shipping#)}:</strong>
      {modifier.method.getName():h} ({getShippingCost()})
    </li>
    <li>
      <strong>{t(#Estimated for#)}:</strong>
      {getEstimateAddress()}
    </li>
  </ul>
</div>

{if:!isShippingEstimate()}
<widget class="\XLite\View\Form\Cart\ShippingEstimator\Open" name="shippingEstimator" />
  <div class="buttons">
    <widget class="\XLite\View\Button\Submit" label="{t(#Estimate shipping cost#)}" />
  </div>
<widget name="shippingEstimator" end />
{end:}
