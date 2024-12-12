{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Product element
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2013 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *
 * @ListChild (list="product.modify.list", weight="1040")
 *}

<tr>
  <td class="name-attribute">{t(#Clean URL#)}</td>
  <td class="star"></td>
  <td class="value-attribute">
    <widget 
      class="XLite\View\FormField\Input\Text\CleanURL" 
      fieldName="{getNamePostedData(#cleanURL#)}" 
      value="{product.getCleanURL()}"
      fieldId="cleanurl"
      fieldOnly="true"
      objectClassName="\XLite\Model\Product"
      objectIdName="product_id" /> 
  </td>
</tr>
