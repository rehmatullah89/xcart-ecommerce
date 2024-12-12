/* vim: set ts=2 sw=2 sts=2 et: */

/**
 * Product details controller
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2013 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 */

/**
 * Controller
 */

jQuery().ready(
  function() {

    // Tabs
    jQuery('#selector-free-shipping', this.base).change(
      function () {

        if (0 == jQuery('#selector-free-shipping option:selected').val()) {
          jQuery('#field-use-separate-box').show();

        } else {
          jQuery('#field-use-separate-box').hide();
        }

        return true;
      }
    );

    // Tabs
    jQuery('#selector-use-separate-box', this.base).change(
      function () {

        if (1 == jQuery('#selector-use-separate-box option:selected').val()) {
          jQuery('#block-use-separate-box').show();

        } else {
          jQuery('#block-use-separate-box').hide();
        }

        return true;
      }
    );
  }
);
