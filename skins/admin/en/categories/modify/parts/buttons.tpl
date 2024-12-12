{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Buttons
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2013 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *
 * @ListChild (list="category.modify.list", weight="1200")
 *}

<tr>
  <td colspan="3">
    <widget IF="category.getCategoryId()" class="\XLite\View\Button\Submit" label="Update" />
    <widget IF="!category.getCategoryId()" class="\XLite\View\Button\Submit" label="Create category" />
  </td>
</tr>
