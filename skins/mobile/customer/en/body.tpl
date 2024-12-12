{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Mobile layout
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2013 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}

<!DOCTYPE html>
<html>
  <widget class="\XLite\View\Header" />
  <body {if:getBodyClasses()}class="{getBodyClasses()}"{end:}>
    <list name="top.message">
    <div 
      data-role="page" 
      class="page-holder" 
      data-dom-cache="true" 
      data-add-back-btn="true" 
      data-url="{getDataURL()}" 
      id="{getIdDataURL()}">
      <list name="body" />
    </div>
  </body>
</html>
