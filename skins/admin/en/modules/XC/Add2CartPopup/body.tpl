{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Add2CartPopup module settings template
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2014 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}

<div class="sources-note">
  {t(#Please choose the sources of products that will be displayed in the 'Customer also bought' section of the 'Add to Cart' popup dialog and set the priority of sources.#)}
</div>

<div class="sources-block">

  <widget class="\XLite\Module\XC\Add2CartPopup\View\Form\Options" name="options_form" />
    <widget class="\XLite\Module\XC\Add2CartPopup\View\Options" />
  <widget name="options_form" end />

</div>

<div class="sources-promo">{getPromotionMessage():h}</div>

<div class="model-form-buttons">
  <div class="button addons-list">
    <widget class="\XLite\View\Button\Link" label="Back to modules" style="action addons-list-back-button" location="{buildURL(#addons_list_installed#)}" />
  </div>
</div>
