{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Product thumbnail zoom
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2013 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}

<div class="image">
  <div class="image-box">

    <ul class="gallery" data-role="listview" data-inset="true">
      {foreach:product.getImages(),i,image}
        <li data-icon="false">
          <a href="#det_{product.product_id}{i}" data-rel="popup" data-position-to="window" data-transition="fade">
            <widget class="\XLite\View\Image" image="{image}" maxWidth="600" maxHeight="600" centerImage=0 />
            <img src="images/spacer.gif" class="leveler" alt="" />
          </a>
          <div id="det_{product.product_id}{i}" class="detailed-image" data-role="popup" data-overlay-theme="a" data-theme="c" data-corners="false">
            <a href="#" data-rel="back" data-role="button" data-theme="a" data-icon="delete" data-iconpos="notext" class="ui-btn-right">{t(#Close#)}</a>
            <img src="{image.getFrontURL()}" alt="" />
          </div>
        </li>
      {end:}
    </ul>

  </div>
</div>