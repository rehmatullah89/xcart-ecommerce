{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Item thumbnail
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2013 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}

<div class="product-thumbnail">
  
  <widget 
    class="\XLite\View\Image" 
    image="{product.getImage()}" 
    maxWidth="{getMobileImageSize(#width#,#list#)}"
    maxHeight="{getMobileImageSize(#height#,#list#)}" 
    alt="{product.name}"
    verticalAlign="top"
    className="list"
    centerImage=0 />
  
  <widget 
    class="\XLite\View\Image" 
    image="{product.getImage()}" 
    maxWidth="{getMobileImageSize(#width#,#grid#)}" 
    maxHeight="{getMobileImageSize(#height#,#grid#)}" 
    alt="{product.name}" 
    verticalAlign="top" 
    className="grid" 
    centerImage=0 />
  
</div>