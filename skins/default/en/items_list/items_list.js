/* vim: set ts=2 sw=2 sts=2 et: */

/**
 * Common list controller
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2013 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 */

// Main class
function ListsController(base)
{
  ListsController.superclass.constructor.apply(this, arguments);

  if (this.base && this.base.length) {
    this.block = this.getListView();
  }
}

extend(ListsController, AController);

ListsController.prototype.name = 'ItemsListController';

ListsController.prototype.findPattern = '.items-list';

ListsController.prototype.block = null;

ListsController.prototype.selfUpdated = false;

ListsController.prototype.getListView = function()
{
  return new ListView(this.base);
};

// Initialize controller
ListsController.prototype.initialize = function()
{
  var o = this;

  this.base.bind(
    'reload',
    function(event, box) {
      o.bind(box);
    }
  );
};

/**
 * Main widget (listView)
 */

function ListView(base)
{
  this.widgetClass  = core.getCommentedData(base, 'widget_class');
  this.widgetTarget = core.getCommentedData(base, 'widget_target');
  this.widgetParams = core.getCommentedData(base, 'widget_params');
  this.listenToHash = core.getCommentedData(base, 'listenToHash');
  this.listenToHashPrefix = core.getCommentedData(base, 'listenToHashPrefix');
  
  ListView.superclass.constructor.apply(this, arguments);  
}

extend(ListView, ALoadable);

ListView.prototype.shadeWidget = true;

ListView.prototype.sessionCell = null;

ListView.prototype.postprocess = function(isSuccess, initial)
{
  ListView.superclass.postprocess.apply(this, arguments);

  if (isSuccess) {

    var o = this;

    // Register page click handler
    jQuery('.pager a', this.base).click(
      function() {
        return !o.load({'pageId': core.getValueFromClass(this, 'page')});
      }
    );

    // Register page count change handler
    jQuery('input.page-length', this.base).change(
      function() {
        count = parseInt(jQuery(this).val());

        if (isNaN(count)) {
          //TODO We must take it from the previous widget parameters ...
          count = 10;
        } else {
          if (count < 1) {
            count = 1;
          }
        }

        if (count != jQuery(this).val()) {
          jQuery(this).val(count);
        }

        return !o.load({'itemsPerPage': count});
      }
    );

    // Fix for Opera. Opera does not interpret onChange event if client presses Enter key.
    if (jQuery.browser.opera) {
      jQuery('input.page-length', this.base).bind('keypress',
        function (e) {
          if (e.keyCode == '13') {
            jQuery(this).change();
          }
        }
      );
    }

  }
};
