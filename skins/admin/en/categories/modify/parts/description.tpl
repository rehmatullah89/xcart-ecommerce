{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Category description
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2013 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *
 * @ListChild (list="category.modify.list", weight="300")
 *}

<tr>
  <td>{t(#Description#)}</td>
  <td class="star"></td>
  <td>
    <widget
      class="\XLite\View\FormField\Textarea\Advanced"
      fieldOnly="true"
      fieldName="{getNamePostedData(#description#)}"
      cols="50"
      rows="10"
      value="{category.getDescription()}" />
  </td>
</tr>
