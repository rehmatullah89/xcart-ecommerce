{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Submit
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2013 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}

<button
  type="submit"
  class="{getClass()}"
  data-role="button"
  data-theme="{getDataTheme()}">
  <span>
    <span class="currency" IF="getCurrency()">{t(getCurrency())}</span>
    {t(getButtonLabel())}
  </span>
</button>
