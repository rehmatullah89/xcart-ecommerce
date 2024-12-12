/* vim: set ts=2 sw=2 sts=2 et: */

/**
 * Password (visible) controller
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2013 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 */

CommonElement.prototype.handlers.push(
  {
    canApply: function () {
      return 0 < this.$element.filter('input.password-visible').length;
    },
    handler: function () {
      var handler = function(event)
      {
        var p = this.$element.parent();
        this.$element.remove();

        if (jQuery(event.currentTarget).hasClass('close')) {
          this.$element.attr('type', 'text');

        } else {
          this.$element.attr('type', 'password');
        }
        p.prepend(this.$element);

        if (jQuery(event.currentTarget).hasClass('close')) {
          this.$element.parent().nextAll('.eye').eq(0).addClass('opened');

        } else {
          this.$element.parent().nextAll('.eye').eq(0).removeClass('opened');
        }

        return false;
      }

      this.$element.parent().nextAll('.eye').eq(0).find('.open,.close').click(_.bind(handler, this));
    }
  }
);

