{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Product element (actions). Actions start after 10000 weight
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2013 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *
 * @ListChild (list="product.modify.list", weight="10010")
 *}

<tr>
<td colspan="2"></td>
<td>
  <br />
{if:isNew()}
  <widget class="\XLite\View\Button\Submit" label="{t(#Add product#)}" style="model-button orange" />
  <div class="add-product-notification">
  {t(#You will be able to provide additional product info (images, attributes, etc.) after you submit this form.#)}
  </div>
{else:}
  <widget class="\XLite\View\Button\Submit" label="{t(#Update product#)}" style="model-button orange" />
  <widget 
    class="\XLite\View\Button\Link" 
    label="{t(#Clone this product#)}" 
    style="model-button" 
    location="{buildURL(#product#,#clone#,_ARRAY_(#product_id#^product.product_id))}" />
  <widget 
    class="\XLite\View\Button\Link" 
    label="{t(#Preview product page#)}" 
    style="model-button link" 
    blank="true"
    location="{buildProductPreviewURL(product.product_id)}" />
{end:}
</td>
</tr>
