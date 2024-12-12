{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Product element
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2013 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *
 * @ListChild (list="product.modify.list", weight="200")
 *}

<tr>
  <td class="name-attribute">{t(#Product Name#)}</td>
  <td class="star">*</td>
  <td class="value-attribute">
    <input type="text" id="product-name" name="{getNamePostedData(#name#)}" size="45" value="{product.name:r}" class="validate[required,maxSize[255]]"/>
  </td>
</tr>