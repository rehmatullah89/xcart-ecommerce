/* vim: set ts=2 sw=2 sts=2 et: */

/**
 * File selector button and popup controller
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2013 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 */

var lastFileSelectorButton;

function PopupButtonFileSelector()
{
  PopupButtonFileSelector.superclass.constructor.apply(this, arguments);
}

extend(PopupButtonFileSelector, PopupButton);

PopupButtonFileSelector.prototype.pattern = '.file-selector-button';

decorate(
  'PopupButtonFileSelector',
  'callback',
  function (selector)
  {
    // Autoloading of browse server link (popup widget).
    // TODO. make it dynamically and move it to ONE widget initialization (Main widget)
    core.autoload(PopupButtonBrowseServer);
    var base = jQuery('.file-select-form ul');
    jQuery('.local-computer-input input, .browse-server-button, #local-server-file, #url', base).click(
      function() {
        jQuery(this).parents('li').eq(0).prev().find('input').click();
      }
    );

    jQuery('.local-computer-input input, .browse-server-button, #local-server-file', base).click(
      function() {
        jQuery('#url-copy-to-local', base).attr('disabled', 'disabled');
      }
    );

    jQuery('#url', base).click(
      function() {
        jQuery('#url-copy-to-local', base).attr('disabled', '');
      }
    );

    // File select dialog cannot be submitted if no file is selected
    jQuery('.file-select-form').submit(function (event) {
      var fileInputEmpty = true;
      jQuery('.file-select-form input[type="text"],.file-select-form input[type="file"]')
      .each(
        function (index, elem) {
          if (jQuery(elem).val() !== "") {
            fileInputEmpty = false;
          }
        }
      );
      return !fileInputEmpty;
    });

    lastFileSelectorButton = lastPopupButton;      
  }
);

core.autoload(PopupButtonFileSelector);
