{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Product images management template
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2013 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}
{* TODO: refactor into lists*}
<p class="error-message" IF="!product.getImages()">{t(#There are no images loaded for this product#)}</p>
<form IF="product.getImages()" action="admin.php" name="images_form" method="post">
  <input FOREACH="allparams,_name,_val" type="hidden" name="{_name}" value="{_val}" />
  <input type="hidden" name="action" value="update_images" />
  <input type="hidden" name="image_id" value="" />
  <widget class="\XLite\View\FormField\Input\FormId" />
  
  <div class="images-items-list" FOREACH="product.getImages(),id,image">
    <p><br /><span class="admin-head">{t(#Image#)} #{inc(id)}</span></p>
    <br />
    <table>
    <tr>
      <td></td>
      <td></td>
      <td rowspan="4" style="vertical-align:top;">
        <a href="{image.getURL()}" target="_blank">
        <img
          src="{image.getURL()}"
          width="auto"
          height="auto"
          style="border: 1px solid #b2b2b3;margin-left: 20px;max-height: 150px;max-width: 300px;"
          alt=""
          title="Original size: {image.getWidth()}px X {image.getHeight()}px" />
        </a>
      </td>
    </tr>
    <tr>
      <td align="right">{t(#Alternative text#)}:</td>
	    <td><input type="text" name="alt[{image.getId()}]" value="{image.getAlt():r}" size="55" /></td>
    </tr>
    <tr>
      <td align="right">{t(#Position#)}:</td>
	    <td><input type="text" name="orderby[{image.getId()}]" value="{image.getOrderby():r}" class="orderby field-integer" /></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>
        <widget class="\XLite\View\Button\Submit" label="{t(#Update#)}" />&nbsp;
        <widget 
          class="\XLite\View\Button\Regular" 
          label="{t(#Delete the image#)}" 
          jsCode="images_form.image_id.value='{image.getId()}';images_form.action.value='delete_image';images_form.submit()" />
	    </td>
    </tr>
    </table>
    <br />
  </div>
</form>
<br />
<widget
  class="\XLite\View\Button\FileSelector"
  style="main-button"
  label="Add image"
  object="product"
  objectId="{product.getProductId()}"
  fileObject="images" />
