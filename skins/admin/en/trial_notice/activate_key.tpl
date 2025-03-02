{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Activate key part of trial notice dialog
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2013 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}

<div class="activate-key-form">

  <widget class="\XLite\View\Form\Module\ActivateKey" formAction="register_key" name="activate_key_form" />

    <div class="addon-key">
      <input type="text" name="key" value="" placeholder="{t(#Enter license key#)}" />
    </div>

    <widget class="\XLite\View\Button\Submit" label="{t(#Activate key#)}" />

    <div class="clear"></div>

  <widget name="activate_key_form" end />

  <div class="need-key-text">{t(#Need license key?#)} <a href="http://www.x-cart.com/contact-us.html" target="_blank">{t(#Contact us#)}</a></div>

</div>

<div class="or">{t(#or#)}</div>
