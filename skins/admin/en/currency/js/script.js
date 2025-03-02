/* vim: set ts=2 sw=2 sts=2 et: */

/**
 * Currency page routines
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2013 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 */

function CurrencyManageForm()
{
  this.initialize();
}

CurrencyManageForm.prototype.patternCurrencyViewInfo = '.currency-view-info *';

CurrencyManageForm.prototype.initialize = function ()
{
  var obj = this;

  jQuery('#currency-id').change(
    function () {
      jQuery(this).closest('form').trigger('sticky_undo_buttons');
      document.location = URLHandler.buildURL({'target': 'currency', 'currency_id': jQuery(this).val()});
    }
  );

  jQuery('#format').change(function() {
    jQuery(obj.patternCurrencyViewInfo).trigger(
      'formatCurrencyChange',
      [
        jQuery(this).val(),
        jQuery(this).data('e'),
        jQuery(this).data('thousandPart'),
        jQuery(this).data('hundredsPart'),
        jQuery(this).data('delimiter')
      ]
    );
  });

  jQuery('#prefix').keyup(function(event) {
    jQuery(obj.patternCurrencyViewInfo).trigger('prefixCurrencyChange', [jQuery(this).val()]);
  });

  jQuery('#suffix').keyup(function(event) {
    jQuery(obj.patternCurrencyViewInfo).trigger('suffixCurrencyChange', [jQuery(this).val()]);
  });

  jQuery('#trailing-zeroes').bind(
    'trailingZeroesClick',
    function (event) {
      jQuery(obj.patternCurrencyViewInfo).trigger('trailingZeroesClick',[jQuery(this).attr('checked')]);
    }
  ).click(function (event) {
      jQuery(this).trigger('trailingZeroesClick');
  });

  jQuery(document).ready(function () {
    jQuery('#format').trigger('change');

    jQuery('#prefix, #suffix').trigger('keyup');

    jQuery('#trailing-zeroes').trigger('trailingZeroesClick');

    jQuery('#format').bind(
      'change',
      function (e) {
        jQuery(this).closest('form').trigger('sticky_changed_buttons');
      }
    );

    jQuery('#prefix, #suffix').bind(
      'keyup',
      function (e) {
        jQuery(this).closest('form').trigger('sticky_changed_buttons');
      }
    );

    jQuery('#trailing-zeroes').bind(
      'click',
      function (e) {
        jQuery(this).closest('form').trigger('sticky_changed_buttons');
      }
    );

  });
}

core.autoload(CurrencyManageForm);
