{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Product options
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2013 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}

<fieldset FOREACH="getOptions(),option" data-role="controlgroup" class="product-option">
  <legend class="subtitle" IF="showOptionsTitle(option)">{option.getDisplayName()}</legend>
  <widget template="{getTemplateNameByOption(option)}" option="{option}" />
</fieldset>

<widget template="modules/CDev/ProductOptions/options_exception.tpl" />
