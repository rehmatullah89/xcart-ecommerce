{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Name
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2014 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}

<div class="form-action contact-us-form-actions">
  <widget
    class="\XLite\View\Button\Submit"
    label="{t(#Send#)}"
    style="action" />
  <widget
    dataTheme="d"
    style="call-us-button"
    class="\XLite\Module\XC\Mobile\View\Button\CallButton"
    label="{t(#Call us: #)}{config.Company.company_phone}"
    phone="{config.Company.company_phone}" />
</div>
