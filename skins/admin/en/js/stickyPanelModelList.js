/* vim: set ts=2 sw=2 sts=2 et: */

/**
 * Sticky panel controller
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2014 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 */

function StickyPanelModelList(base)
{
  StickyPanel.apply(this, arguments);
}

extend(StickyPanelModelList, StickyPanel);

// Autoloader
StickyPanelModelList.autoload = function()
{
  jQuery('.sticky-panel.model-list').each(
    function() {
      new StickyPanelModelList(this);
    }
  );
};

// Process widget (initial catch widget)
StickyPanelModelList.prototype.process = function()
{
  StickyPanel.prototype.process.apply(this);

  var widget = this.base.parents('form').eq(0).find('.widget.items-list').length > 0
    ? this.base.parents('form').eq(0).find('.widget.items-list').get(0).itemsListController
    : null;

  if (widget) {
    widget.bind('local.selector.checked', _.bind(this.markAllListActions, this))
      .bind('local.selector.unchecked', _.bind(this.unmarkAllListActions, this));
  }
}

StickyPanelModelList.prototype.markAllListActions = function()
{
  this.getListActionButtons().each(
    function() {
      this.enable();
    }
  );

  this.getListActionButtons().removeClass('disabled');
}

StickyPanelModelList.prototype.unmarkAllListActions = function()
{
  this.getListActionButtons().each(
    function() {
      this.disable();
    }
  );

  this.getListActionButtons().addClass('disabled');
}

StickyPanelModelList.prototype.getListActionButtons = function()
{
  return this.base.find('button.list-action')
    .not('.always-enabled');
}

core.autoload(StickyPanelModelList);

