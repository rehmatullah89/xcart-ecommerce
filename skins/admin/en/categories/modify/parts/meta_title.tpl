{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Category meta title
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2013 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *
 * @ListChild (list="category.modify.list", weight="700")
 *}

<tr>
  <td>{t(#HTML title ('title' tag)#)}</td>
  <td class="star"></td>
  <td>
    <input type="text" name="{getNamePostedData(#metaTitle#)}" value="{category.getMetaTitle()}" size="50" />
  </td>
</tr>
