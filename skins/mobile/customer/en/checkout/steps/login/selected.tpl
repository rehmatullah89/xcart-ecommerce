{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Order review checkout step (selected)
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2013 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}

<div class="ui-grid-a checkout-profile">
  <list name="customer.signin" />
</div>

<div class="login-form-block">
  <widget template="authentication.tpl" checkoutStep=1 />
</div>

<div class="label-or">{t(#or#)}</div>

<widget
  class="\XLite\View\Button\Link"
  dataTheme="e"
  dataInline="false"
  dataRel="external"
  location="{buildURL(#checkout#,#update_profile#,_ARRAY_(#email#^##))}"
  label="{t(#Continue as guest#)}" />

