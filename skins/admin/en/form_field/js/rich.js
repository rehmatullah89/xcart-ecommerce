/* vim: set ts=2 sw=2 sts=2 et: */

/**
 * Multiselect microcontroller
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2013 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 */

CommonElement.prototype.handlers.push(
  {
    canApply: function () {
      return 0 < this.$element.filter('select.rich').length;
    },
    handler: function () {

      var options = {
        minWidth: this.$element.width(),
        header: false,
        multiple: false,
        selectedList: 1,
        classes: ''
      };

      if (this.$element.data('none-selected-text')) {
        options.noneSelectedText = this.$element.data('none-selected-text');
      }

      if (this.$element.data('selected-text')) {
        options.selectedText = this.$element.data('selected-text');
      }

      if (this.$element.data('header')) {
        options.header = true;

      } else if (this.$element.data('filter')) {
        options.header = 'close';
      }

      if (this.$element.data('filter')) {
        options.classes = options.classes + 'ui-multiselect-with-filter';
      }

      if (this.$element.data('classes')) {
        options.classes = options.classes + ' ' + this.$element.data('classes');
      }

      if (this.$element.data('height')) {
        options.height = this.$element.data('height');
      }

      this.$element.multiselect(options);

      if (this.$element.data('filter')) {
        options = {placeholder: this.$element.data('filter-placeholder')};

        this.$element.multiselectfilter(options);

        jQuery('.ui-multiselect-filter').each(
          function () {
            if (3 == this.childNodes[0].nodeType) {
              this.removeChild(this.childNodes[0]);
            }
          }
        );

      }
    }
  }
);
