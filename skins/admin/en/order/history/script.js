/* vim: set ts=2 sw=2 sts=2 et: */

/**
 * ____file_title____
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2013 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 */

function OrderEventDetails()
{
  jQuery(this.base).each(function (index, elem) {
    var $elem = jQuery(elem);

    jQuery('.action', $elem)
    .bind('click', function(event) {
      jQuery('.order-event-details .details', $elem).trigger('toggle-action');
    })
    .bind('toggle-action', function() {
      jQuery(this).toggleClass('show-details');
    });

    jQuery('.order-event-details .details', $elem).bind('toggle-action', function() {
      jQuery(this).toggleClass('show-details');
    });
  });
}

OrderEventDetails.prototype.base = 'li.event';

core.autoload('OrderEventDetails');