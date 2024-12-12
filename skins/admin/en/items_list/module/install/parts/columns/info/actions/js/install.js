/* vim: set ts=2 sw=2 sts=2 et: */

/**
 * Modules list controller (install)
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2013 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 */

jQuery(document).ready(function () {
  jQuery('.install-module-action').each(function (index, element) {
    var $this = jQuery(element);
    $this.click(function () {
      jQuery('.sticky-panel button, .sticky-panel .actions').trigger(
        'select-to-install-module', 
        {
          id: $this.attr('data'), 
          checked: $this.attr('checked'), 
          moduleName: jQuery('.module-name', $this.closest('.module-main-section')).html()
        }
      );
    });
  });
});
