{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Dropdown button
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2013 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}
<div class="btn-dropdown">
  <button{if:hasName()} name="{getName()}"{end:}{if:hasValue()} value="{getValue()}"{end:} class="main{if:getStyle()} {getStyle()}{end:}" type="button">
    <span>{t(getButtonLabel())}</span>
  </button>
  {if:getAdditionalButtons()}
  <button class="arrow{if:hasClass()} {getClass()}{end:}" type="button"><span></span></button>
  <ul>
    <li FOREACH="getAdditionalButtons(),button">{button.display():h}</li>
  </ul>
  {end:}
</div>
