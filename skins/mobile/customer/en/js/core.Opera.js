/* vim: set ts=2 sw=2 sts=2 et: */

/**
 * Opera browser fix
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2013 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 */
jQuery(document).bind('mobileinit', function() {
  jQuery.mobile.selectmenu.prototype.options.nativeMenu = false;
});

jQuery(function() {
  jQuery('.ui-select .ui-btn').removeClass('ui-select-nativeonly');
});