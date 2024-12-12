{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Trial notice popup dialog
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2013 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}

<div class="trial-notice-form">

  <div class="indent title">{t(#Your X-Cart 5 installation is licensed for evaluation purposes only.#)}</div>

  <div class="indent">{t(#You can build your web-site during FREE evaluation, but you cannot use this installation for real sales without buying a license.#)}</div>

  <div class="buttons">
    <widget class="\XLite\View\Button\Regular" label="Purchase license" style="purchase-button" jsCode="window.open('{getPurchaseURL()}', '_blank');" />
    <div class="text or">{t(#or#)}</div>
    <div class="text"><a href="http://www.x-cart.com/contact-us.html" target="_blank">{t(#Contact us#)}</a> {t(#if you have any questions#)}</div>
  </div>

  <div class="indent faq">{t(#For details refer to#)} <a href="http://www.x-cart.com/license-agreement.html" target="_blank">{t(#X-Cart 5 license agreement#)}</a>.</div>

  <div class="indent important">{t(#Removing this message without buying a Full license is prohibited and will result in legal proceedings.#)}</div>

  <div class="clear"></div>
</div>
