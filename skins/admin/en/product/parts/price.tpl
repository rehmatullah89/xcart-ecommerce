{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Product element
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2013 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *
 * @ListChild (list="product.modify.list", weight="500")
 *}

<tr>
  <td class="name-attribute">{t(#Price#)}</td>
  <td class="star">&nbsp;*&nbsp;</td>
  <td class="value-attribute">
    <input type="text" id="product-price" name="{getNamePostedData(#price#)}" size="18" value="{product.price}" class="validate[required,maxSize[255],custom[number]]" />
  </td>
</tr>
