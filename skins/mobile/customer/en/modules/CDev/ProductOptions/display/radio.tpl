{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Display product options as radio buttons list
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2013 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}

{* TODO: decide if we need radiobuttons in mobile
<ul>
  <li FOREACH="option.getOptions(),opt">
    <input type="radio" id="product_option_{opt.getOptionId()}" name="product_options[{option.getGroupId()}]" value="{opt.getOptionId()}" checked="{isOptionSelected(opt)}" />
    <label for="product_option_{opt.getOptionId()}">
      {option.getDisplayName()}: {opt.getName()}
      <widget class="\XLite\Module\CDev\ProductOptions\View\ProductOptionModifier" option="{opt}" />
    </label>
  </li>
</ul>
*}
<select name="product_options[{option.getGroupId()}]">
  <option FOREACH="option.getActiveOptions(),opt" value="{opt.getOptionId()}" selected="{isOptionSelected(opt)}" >
    {option.getDisplayName()}: {opt.getName()}
    <widget class="\XLite\Module\CDev\ProductOptions\View\ProductOptionModifier" option="{opt}" />
  </option>
</select>
