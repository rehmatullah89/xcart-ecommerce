{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Product element
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2013 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *
 * @ListChild (list="product.modify.list", weight="700")
 *}

<tr>
  <td class="name-attribute">{t(#Shippable#)}</td>
  <td class="star">*</td>
  <td class="value-attribute">
    <select id="selector-free-shipping" name="{getNamePostedData(#free_shipping#)}">
      <option value="0" selected="{isSelected(product,#free_shipping#,#0#)}">{t(#Yes#)}</option>
      <option value="1" selected="{isSelected(product,#free_shipping#,#1#)}">{t(#No#)}</option>
    </select>
  </td>
</tr>
