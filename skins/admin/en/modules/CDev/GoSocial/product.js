/* vim: set ts=2 sw=2 sts=2 et: */

/**
 * Additional product page controller
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2013 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 */

jQuery().ready(
  function () {
    jQuery('.og-tags .control select').change(
      function () {
        if (1 == this.options[this.selectedIndex].value) {
          jQuery('.og-tags .og-textarea').show();

        } else {
          jQuery('.og-tags .og-textarea').hide();
        }
      }
    );
  }
);
