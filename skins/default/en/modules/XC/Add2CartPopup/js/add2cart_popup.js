/* vim: set ts=2 sw=2 sts=2 et: */

/**
 * JS controller
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2014 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 */

function PopupButtonAdd2CartPopup()
{
  core.bind('updateCart', this.handleOpenPopup);
  core.bind(
    'afterPopupPlace',
    function() {
      core.autoload(ProductsListController);
    }
  );

  PopupButtonAdd2CartPopup.superclass.constructor.apply(this, arguments);
}

// Extend AController
extend(PopupButtonAdd2CartPopup, AController);

PopupButtonAdd2CartPopup.prototype.popupResult = null;

// Re-initialize products list controller
PopupButtonAdd2CartPopup.prototype.handleOpenPopup = function(event)
{
  setTimeout(
    function()
    {
      this.popupResult = !popup.load(
        '?target=add2_cart_popup',
        'add2cartpopup',
        false,
        0,
        1
      );
    },
    1
  );

  return this.popupResult;
}

// Autoloading new POPUP widget
core.autoload(PopupButtonAdd2CartPopup);
