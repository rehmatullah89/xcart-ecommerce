/* vim: set ts=2 sw=2 sts=2 et: */

/**
 * Modules list controller (install)
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2013 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 */

ItemsList.prototype.listeners.popup = function(handler)
{
  // TODO: REWORK to load it dynamically with POPUP button widget JS files
  core.autoload(PopupButtonInstallAddon);
  core.autoload(PopupButtonSelectInstallationType);
}

jQuery(document).ready(
  function () {
    jQuery('#addons-sort').bind('multiselectclick', function(event, ui) {
      location.replace(ui.value);
    });

    jQuery('#price-filter').bind('multiselectclick', function(event, ui) {
      location.replace(ui.value);
    });

    jQuery('#tag-filter').bind('multiselectclick', function(event, ui) {
      location.replace(ui.value);
    });
  }
)

