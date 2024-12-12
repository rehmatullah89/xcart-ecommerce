{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Save cell
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2013 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *
 * @ListChild (list="product.details.page.mobile.header", weight="100")
 *}

<li IF="isShowMarketPrice()" data-theme="c" class="save-percent-container">
  <span class="save">
    <span id="save_percent">{getYouSaveValue()}</span>%&nbsp;{t(#less#)}
  </span>
</li>
