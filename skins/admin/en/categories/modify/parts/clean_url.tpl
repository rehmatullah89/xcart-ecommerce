{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Category clean URL
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2013 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *
 * @ListChild (list="category.modify.list", weight="1000")
 *}

<tr IF="!isRoot()">
  <td>{t(#Clean URL#)}</td>
  <td class="star"></td>
  <td>
    <widget class="XLite\View\FormField\Input\Text\CleanURL" fieldName="{getNamePostedData(#cleanURL#)}" value="{category.getCleanURL()}" maxlength="{getCleanURLMaxLength()}" label="{t(#Clean URL#)}" fieldOnly="true" disabled="{category.getAutogenerateCleanURL()}" />
  </td>
</tr>
