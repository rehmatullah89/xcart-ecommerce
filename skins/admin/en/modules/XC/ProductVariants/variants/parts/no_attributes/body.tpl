{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * No attributes
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2013 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}

<div class="{getBlockStyle()}">
  <div class="header">
    <span class="title">{t(#The product does not have the attributes with multiple options#)}</span>
    <widget
      class="\XLite\View\Tooltip"
      text="{t(#To set product variants you should select attributes with multiple options. The product variants will be based on these attributes. E.g. If you select Size and Color, you should create product variants with all possible intersections of these two attributes.#)}"
      isImageTag="true"
      className="help-icon" />
  </div>
  <div class="content">
    <div class="note">{t(#Please add the attributes with multiple options first to create product variants#)}</div>
    <widget class="\XLite\View\Button\Link" style="main-button" label="{t(#Add attributes#)}" location={buildURL(#product#,##,_ARRAY_(#product_id#^product.product_id,#page#^#attributes#))} />
  </div>
</div>
