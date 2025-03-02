/* vim: set ts=2 sw=2 sts=2 et: */

/**
 * Install modules selected
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2013 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 */

function unsetModule(id)
{
  jQuery('#install-' + id).attr('checked', '');

  jQuery('.install-modules-button').removeClass('disabled')
  if (jQuery('.install-module-action:checked').length === 0) {
    jQuery('.install-modules-button').addClass('disabled');
  }

  jQuery('.sticky-panel button, .sticky-panel .actions').trigger(
    'select-to-install-module',
    {
      id: id,
      checked: false,
      moduleName: ''
    }
  );
}

jQuery(document).ready(function () {
  jQuery('.sticky-panel .install-modules-button').bind(
    'select-to-install-module',
    function (event, arg) {
      event.stopImmediatePropagation();
      var $this = jQuery(this);

      if (arg.checked) {
        $this.append('<input type="hidden" name="moduleIds[]" value="' + arg.id + '" id="moduleids_' + arg.id + '">');
        core.get(
          URLHandler.buildURL({'target': 'addons_list_marketplace', 'action': 'set_install', 'id': arg.id}),
          function(xhr, status, data) {
          },
          {},
          {timeout: 10000}
        );
      } else {
        jQuery('input#moduleids_' + arg.id, $this).remove();
        core.get(
          URLHandler.buildURL({'target': 'addons_list_marketplace', 'action': 'unset_install', 'id': arg.id}),
          function(xhr, status, data) {
          },
          {},
          {timeout: 10000}
        );
      }

      $this.removeClass('disabled')
      if (jQuery('.install-module-action:checked').length === 0) {
        $this.addClass('disabled');
      }

      return false;
    }
  );
    
  jQuery('.sticky-panel .modules-selected-box').bind(
    'select-to-install-module',
    function (event, arg) {
      event.stopImmediatePropagation();
      var $this = jQuery(this);
      
      if (arg.checked) {
        $this.append('<div class="module-box" id="module-box-' + arg.id + '"><div class="remove-action"><span class="info">' + arg.id + '</span></div>' + arg.moduleName + '</div>');
        jQuery('.remove-action', $this).unbind('click').bind('click', function (event, arg) {
          unsetModule(jQuery('.info', this).html());
        });
      } else {
        jQuery('div#module-box-' + arg.id, $this).remove();
      }
      
      jQuery('.sticky-panel .more-actions .modules-amount').html(
        jQuery('.module-box', $this).length
      );
      
      if (jQuery('.module-box', $this).length > 0) {
        $this.removeClass('hide-selected');
        jQuery('.modules-not-selected', $this.parent()).addClass('hide-selected');
      } else {
        $this.addClass('hide-selected');
        jQuery('.modules-not-selected', $this.parent()).removeClass('hide-selected');
      }
        
      return false;
    }
  );    

  jQuery('.sticky-panel .remove-action').bind(
    'click', 
    function (event, arg) {
      unsetModule(jQuery('.info', this).html());
    }
  );
});
