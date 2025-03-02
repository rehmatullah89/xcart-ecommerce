{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Regular button
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2013 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}

<button type="button"{if:getClass()} class="{getClass()}"{end:}>
{displayCommentedData(getURLParams())}
  <div>
    <span>
      <img src="images/spacer.gif" alt="" />
      {t(getButtonLabel())}
    </span>
  </div>
  <div id="iframe-placeholder" class="iframe-placeholder"></div>
</button>

