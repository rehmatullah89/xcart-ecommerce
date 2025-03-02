{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Remove button
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2013 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}
<div class="remove-wrapper {getStyle}">
  <button type="button" class="{getStyle()}" title="{getButtonLabel()}" tabindex="-1">
    <img src="images/spacer.gif" alt="" />
  </button>
  <input type="checkbox" name="{getName()}" value="1" tabindex="-1" />
</div>
