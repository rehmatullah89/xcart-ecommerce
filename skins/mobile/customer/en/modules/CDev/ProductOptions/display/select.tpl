{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Display product options as select box
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2013 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}


<select name="product_options[{option.getGroupId()}]">
  <option FOREACH="option.getActiveOptions(),opt" value="{opt.getOptionId()}" selected="{isOptionSelected(opt)}" >
    {option.getDisplayName()}: {opt.getName()}
    <widget class="\XLite\Module\CDev\ProductOptions\View\ProductOptionModifier" option="{opt}" />
  </option>
</select>
