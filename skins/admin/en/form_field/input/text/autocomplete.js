/* vim: set ts=2 sw=2 sts=2 et: */

/**
 * Float field microcontroller
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2014 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 */

CommonForm.elementControllers.push(
  {
    pattern: '.input-field-wrapper input.auto-complete',
    handler: function () {

      if ('undefined' == typeof(this.autocompleteSource)) {
        this.autocompleteSource = function(request, response)
        {
          core.get(
            unescape(jQuery(this).data('source-url')).replace('%term%', request.term),
            null,
            {},
            {
              dataType: 'json',
              success: function (data) {
                response(data);
              }
            }
          );
        }
      }

      if ('undefined' == typeof(this.autocompleteAssembleOptions)) {
        this.autocompleteAssembleOptions = function()
        {
          var input = this;

          return {
            source: function(request, response) {
              input.autocompleteSource(request, response);
            },
            minLength: jQuery(this).data('min-length') || 2,
            close: function() {jQuery(this).keyup()},
            select: function() {jQuery(this).dblclick()}
          };
        }
      }

      jQuery(this).autocomplete(this.autocompleteAssembleOptions());
    }
  }
);

