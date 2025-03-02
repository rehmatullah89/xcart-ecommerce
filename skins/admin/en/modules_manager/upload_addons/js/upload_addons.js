/* vim: set ts=2 sw=2 sts=2 et: */

/**
 * Upload addons controller
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2013 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 */

function PopupButtonUploadAddon()
{
  PopupButtonUploadAddon.superclass.constructor.apply(this, arguments);
}

extend(PopupButtonUploadAddon, PopupButton);

PopupButtonUploadAddon.prototype.pattern = '.upload-addons';

PopupButtonUploadAddon.prototype.enableBackgroundSubmit = false;

core.autoload(PopupButtonUploadAddon);

window.core.multiAdd = function (addArea, addObj, removeElement)
{
  var cloneObj;

  if (cloneObj == undefined) {
    cloneObj = {};
  }

  jQuery(addObj).click(
    function ()
    {
      if (cloneObj[addArea] == undefined) {
        cloneObj[addArea] = jQuery(addArea);
      }

      cloneObj[addArea].clone().append(
        jQuery(removeElement).click(
          function()
          {
            jQuery(this).closest(addArea).remove();
          }
        )
      )
      .insertAfter(cloneObj[addArea]);
    }
  );
}
