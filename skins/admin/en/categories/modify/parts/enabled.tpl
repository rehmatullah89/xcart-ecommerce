{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Category availability
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2013 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *
 * @ListChild (list="category.modify.list", weight="600")
 *}

<tr>
  <td>{t(#Availability#)}</td>
  <td class="star">*</td>
  <td>
    <select name="{getNamePostedData(#enabled#)}">
      <option value="1" selected="{category.getEnabled()=#1#}">{t(#Enabled#)}</option>
      <option value="0" selected="{category.getEnabled()=#0#}">{t(#Disabled#)}</option>
    </select>
  </td>
</tr>
