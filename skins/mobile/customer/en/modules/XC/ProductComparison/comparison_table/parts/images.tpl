{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Images
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2013 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}


<tr class="images">
  <td class="clear-list">
    <widget class="\XLite\View\Button\Link" label="{t(#Clear list#)}" location="{buildURL(#compare#,#clear#)}" dataRel="external" /> 
  </td>
  <td FOREACH="getProducts(),product" class="image">
    <a
      href="{buildURL(#product#,##,_ARRAY_(#product_id#^product.product_id))}"
      class="product-thumbnail">
        <widget
          class="\XLite\View\Image"
          image="{product.getImage()}"
          maxWidth="110"
          maxHeight="70"
          alt="{product.name}"
          className="photo" />
    </a>
    <widget class="\XLite\View\Button\Link" label="{t(#Remove#)}" location="{buildURL(#compare#,#delete#,_ARRAY_(#product_id#^product.product_id))}" dataTheme="f" dataIcon="delete" dataIconPos="notext" dataInline="false" dataRel="external" /> 
  </td>
</tr>
