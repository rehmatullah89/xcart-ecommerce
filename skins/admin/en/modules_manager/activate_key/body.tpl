{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Activate license key form
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2013 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}

<div class="activate-key-form">

  <widget class="\XLite\View\Form\Module\ActivateKey" formAction="register_key" formName="getAddonForm" name="activate_key_form" />

    <div class="enter-key-hint">
      {t(#Enter here your X-Cart 5 license key or your license key for a commercial module to activate it in your shop.#)}
    </div>

    <div class="buttons">

    <div class="addon-key">
      <input type="text" name="key" value="" placeholder="{t(#Enter key here#)}" />
    </div>

    <widget class="\XLite\View\Button\Submit" label="{t(#Activate key#)}" />

    </div>

    <div class="clear"></div>

  <widget name="activate_key_form" end />

  <div class="title">{t(#Do you need the license key?#)}</div>

  <div class="bottom-buttons">
    <widget class="\XLite\View\Button\Regular" label="Purchase license" style="purchase-button" jsCode="window.open('{getPurchaseURL()}', '_blank');" />
    <div class="text or">{t(#or#)}</div>
    <div class="text"><a href="http://www.x-cart.com/contact-us.html" target="_blank">{t(#Contact us#)}</a> {t(#if you have any questions#)}</div>
  </div>
</div>
