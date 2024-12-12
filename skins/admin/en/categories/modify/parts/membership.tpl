{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Category membership
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2013 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *
 * @ListChild (list="category.modify.list", weight="500")
 *}

<tr IF="!isRoot()">
  <td>{t(#Membership#)}</td>
  <td class="star"></td>
  <td>
    <widget
      IF="!category.getMembership()"
      class="\XLite\View\MembershipSelect"
      template="common/select_membership.tpl"
      field="{getNamePostedData(#membership#)}"
      value="0" />
    <widget
      IF="category.getMembership()"
      class="\XLite\View\MembershipSelect"
      template="common/select_membership.tpl"
      field="{getNamePostedData(#membership#)}"
      value="{category.membership.getMembershipId()}" />
  </td>
</tr>
