{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Product element
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2013 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *
 * @ListChild (list="product.modify.list", weight="350")
 *}

<tr>
  <td class="name-attribute">{t(#Memberships#)}</td>
  <td class="star"></td>
  <td class="value-attribute">
    <widget class="\XLite\View\FormField\Select\Memberships" fieldName="{getNamePostedData(#membership_ids#)}" fieldOnly=true value="{product.getMemberships()}" />
  </td>
</tr>
