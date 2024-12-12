/* vim: set ts=2 sw=2 sts=2 et: */

/**
 * Move controller
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2014 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 */

CommonForm.elementControllers.push(
  {
    pattern: 'tbody.lines',
    condition: '.inline-field.inline-move',
    handler: function (form) {

      jQuery(this).find('.inline-move').disableSelection();

      var tds = jQuery(this).find('td');

      tds.each(
        function () {
          var td = jQuery(this);
          td.data('saved-width', td.width());
        }
      );

      jQuery(this).sortable(
        {
          axis:   'y',
          handle: '.inline-move',
          items:  'tr:not(.dump-entity)',
          cancel: '.dump-entity',
          opacity: 0.8,
          placeholder: 'sortable-placeholder',
          forcePlaceholderSize: true,
          start:  function (event, ui)
          {
            for (var i = 0; i < ui.item.find('td').length; i++) {
              jQuery('.sortable-placeholder').append('<td></td>');
            }
            if (ui.item.hasClass('remove-mark')) {
              ui.item.parent().sortable('cancel');

            } else {
              tds.each(
                function () {
                  var td = jQuery(this);
                  td.width(td.data('saved-width'));
                }
              );
            }
          },
          update: function(event, ui)
          {
            ui.item.css('width', 'auto');
            tds.removeAttr('style');

            // Reassign position values
            var min = 10;
            form.find('.inline-field.inline-move input').each(
              function () {
                min = parseInt(10 == min ? min : Math.min(this.value, min));
              }
            );

            form.find('.inline-field.inline-move input').each(
              function () {
                jQuery(this).attr('value', min);
                jQuery(this).parents('.inline-move').eq(0).find('.move').attr('title', min);
                min+=10;
              }
            );

            // Change
            ui.item.parents('tbody.lines').trigger('positionChange');
            ui.item.parents('form').change();
          }
        }
      );
    }
  }
);
