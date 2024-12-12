{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Category image
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2013 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *
 * @ListChild (list="category.modify.list", weight="400")
 *}

<tr IF="hasImage()">
  <td>{t(#Image#)}</td>
  <td class="star"></td>
  <td>
    <img IF="category.hasImage()" src="{category.image.getURL()}" alt="" />
    <img IF="!category.hasImage()" src="images/no_image.png" alt="" />
    <br />
    <widget class="\XLite\View\Button\FileSelector" label="Image upload" object="category" objectId="{category.getCategoryId()}" fileObject="image" />
  </td>
</tr>
