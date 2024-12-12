{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Checkout failed
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2013 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}

<div class="order-success-box">
  <div class="order-success-panel">
    <p><widget template="checkout/failed_message.tpl" /></p>
    <div class="ui-grid-a">
      <div class="ui-block-a">
        <widget class="\XLite\View\Button\Link" label="{t(#Re-order#)}" dataTheme="b" dataInline="false" location="{getReorderURL()}" />
      </div>
      <div class="ui-block-b">
        <widget class="\XLite\View\Button\Link" label="{t(#Continue shopping#)}" dataInline="false" location="{getContinueURL()}" />
      </div>
    </div>
  </div>
</div>
