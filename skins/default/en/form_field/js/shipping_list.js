/* vim: set ts=2 sw=2 sts=2 et: */

/**
 * Controller
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2013 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 */

CommonElement.prototype.handlers.push(
  {
    canApply: function () {
      return this.$element.is('select#methodid');
    },
    handler: function () {
      var count = 10;

      var handler = _.bind(
        function() {
          var widget = this.$element.multiselect('widget');
          if (widget && widget.is('div')) {
            widget.find('ul.ui-multiselect-checkboxes li').each(
              _.bind(
                function(idx, elm) {
                  var methodId = jQuery(elm).find('input').val();
                  var html = jQuery('.shipping-rates-data li#shippingMethod' + methodId).html();
                  if (html) {
                    jQuery(elm).find('label span').html(html);
                  }
                },
                this
              )
            );

            this.$element.multiselect(
              'option',
              'selectedText',
              function(index, length, checked) {
                return jQuery('.shipping-rates-data li#shippingMethod' + checked[0].value).html();
              }
            );

          } else if (count > 0) {
            count--;
            setTimeout(_.bind(arguments.callee, this), 500);
          }
        },
        this
      );

      handler();
    }
  }
);

