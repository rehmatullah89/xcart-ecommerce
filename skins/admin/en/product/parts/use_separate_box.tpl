{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * 'Use separate box' element
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2013 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *
 * @ListChild (list="product.modify.list", weight="750")
 *}

<tr id="field-use-separate-box"{if:isSelected(product,#free_shipping#,#1#)} style="display: none;"{end:}>
  <td class="name-attribute">{t(#Ship in a separate box#)}</td>
  <td class="star">&nbsp;</td>
  <td class="value-attribute">
    <select id="selector-use-separate-box" name="{getNamePostedData(#useSeparateBox#)}">
      <option value="1" selected="{isSelected(product,#useSeparateBox#,#1#)}">{t(#Yes#)}</option>
      <option value="0" selected="{isSelected(product,#useSeparateBox#,#0#)}">{t(#No#)}</option>
    </select>
    <div id="block-use-separate-box"{if:isSelected(product,#useSeparateBox#,#0#)} style="display: none;"{end:}><widget class="\XLite\View\Product\ProductBox" product="{product}" /></div>
  </td>
</tr>
