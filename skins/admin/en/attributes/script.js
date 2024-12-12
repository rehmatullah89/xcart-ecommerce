/* vim: set ts=2 sw=2 sts=2 et: */

/**
 * Attributes
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2014 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 */

var ppr = popup.postprocessRequest;
popup.postprocessRequest = function(XMLHttpRequest, textStatus, data, isValid) {
  ppr.call(this, XMLHttpRequest, textStatus, data, isValid);
  TableItemsListQueue();

  jQuery('.select-attributetypes select').change(
    function () {
      if (jQuery(this).data('value') == jQuery(this).val()) {
        jQuery('.select-attributetypes .form-field-comment').hide();
        jQuery('li.custom-field').show();
      } else {
        jQuery('.select-attributetypes .form-field-comment').show();
        jQuery('li.custom-field').hide();
      }
    }
  );

  jQuery('.tooltip-main').each(
    function () {
      attachTooltip(
        jQuery('img', this),
        jQuery('.help-text', this).hide().html()
      );
    }
  );

  jQuery('.ajax-container-loadable form.attribute', this.base).commonController('submitOnlyChanged', false);
}

jQuery().ready(
  function () {

    var attributeChanged = false;

    jQuery('button.manage-groups').click(
      function () {
        var product_class_id = jQuery(this).parent().data('class-id')
          ? jQuery(this).parent().data('class-id')
          : 0;
        return !popup.load(
          URLHandler.buildURL({
            target:             'attribute_groups',
            product_class_id:   product_class_id,
            widget:             'XLite\\View\\AttributeGroups'
          }),
          null,
          function () {
            if (attributeChanged) {
              self.location.reload();
            }
          }
        );
      }
    );

    jQuery('button.new-attribute, a.edit-attribute').click(
      function () {
        var product_class_id = jQuery(this).parent().data('class-id')
          ? jQuery(this).parent().data('class-id')
          : 0;
        return !popup.load(
          URLHandler.buildURL({
            target:             'attribute',
            product_class_id:   product_class_id,
            id:                 jQuery(this).parent().data('id'),
            widget:             'XLite\\View\\Attribute'
          }),
          null,
          function () {
            if (attributeChanged) {
              self.location.reload();
            }
          }
        );
      }
    );

    core.bind(
      'updateAttribute',
      function() {
        attributeChanged = true;
      }
    );
  }
);
