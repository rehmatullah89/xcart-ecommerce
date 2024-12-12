{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Additional buttons list
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2013 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}

<div class="additional-buttons">
  <span class="or" IF="isDisplayORLabel()">{t(#or#)}</span>
  <div class="menu">
    <span class="more-actions">{getMoreActionsText():h}</span>
    <div class="popup">
      <div FOREACH="getAdditionalButtons(),i,button" class="{getSubcellClass(buttonArrayPointer,i,button)}" >{button.display():h}</div>
      <div class="more">
       <span class="more-actions">{getMoreActionsPopupText():h}</span>
      </div>
    </div>
  </div>
</div>
