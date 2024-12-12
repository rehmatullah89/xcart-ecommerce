{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * ____file_title____
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2013 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}

<widget class="\XLite\View\Form\Login\Customer\Main" name="login_form" />

<input IF="checkoutStep" type="hidden" name="returnURL" value="{buildURL(#checkout#)}" />

<ul class="auth-form">

  <li class="alternative-login" IF="!checkoutStep">
    <list name="customer.signin" />
  </li>

  <li>
    <input type="email" name="login" value="{login:r}" placeholder="{t(#E-Mail#)}" size="30" maxlength="128">
  </li>

  <li>
    <input type="password" name="password" value="" placeholder="{t(#Password#)}" size="30" maxlength="128">
  </li>

  <li IF="!valid" class="error">
    <strong>{t(#Invalid login or password#)}</strong>
  </li>

  <li IF="!checkoutStep">
    <widget class="\XLite\View\Button\Submit" label="{t(#Sign in#)}" dataInline="false" />
  </li>

  <li>

    <div IF="!checkoutStep" class="ui-grid-a">
      <div class="ui-block-a">
        <widget
          class="\XLite\View\Button\Link"
          dataTheme="e"
          dataInline="false"
          location="{buildURL(#profile#,##,_ARRAY_(#mode#^#register#))}"
          label="{t(#Create account#)}" />
      </div>
      <div class="ui-block-b">
        <widget
          class="\XLite\View\Button\Link"
          dataInline="false"
          location="{buildURL(#recover_password#)}"
          label="{t(#Forgot password?#)}" />
      </div>
    </div>

    <div IF="checkoutStep">
        <widget
          IF="checkoutStep"
          class="\XLite\View\Button\Submit"
          label="{t(#Login#)}"
          style="login-checkout-button"
          dataInline="false" />
    </div>

  </li>

</ul>

<widget name="login_form" end />
