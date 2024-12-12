{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Category title
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2013 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *
 * @ListChild (list="category.modify.list", weight="200")
 *}

<tr>
  <td>{t(#Category page title#)}</td>
  <td class="star"></td>
  <td>
    <select name="{getNamePostedData(#show_title#)}">
      <option value="1" selected="{#1#=category.getShowTitle()}">{t(#Use the category name#)}</option>
      <option value="0" selected="{#0#=category.getShowTitle()}">{t(#Hide#)}</option>
    </select>
  </td>
</tr>
