{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Selected options
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2013 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}

<ul class="selected-options">
  {foreach:item.getOptions(),option}
    <li IF="!isOptionEmpty(option)">
      <span>{option.getActualName()}:</span>
      {option.getActualValue()}{if:!optionArrayPointer=optionArraySize}, {end:}
    </li>
  {end:}
</ul>

<div IF="getParam(#source#)" class="item-change-options">
  <widget
    class="\XLite\View\Button\Link"
    label="{t(#Change#)}"
    dataTheme="b"
    dataMini="false"
    dataRel="dialog"
    dataTransition="slidedown"
    location="{getChangeOptionsLink()}"
  />
</div>
