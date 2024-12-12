{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Top messages
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2013 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}


<div id="status-messages" data-role="popup" data-theme="c"  data-overlay-theme="a" IF="isVisible()">

  <a href="#" data-rel="back" data-role="button" data-icon="delete" data-iconpos="notext" class="ui-btn-right">{t(#Close#)}</a>

  <ul class="message-points">
    <li FOREACH="getTopMessages(),data" class="{getType(data)}">
      <strong IF="getPrefix(data)">{getPrefix(data)}</strong> {getText(data):h}
    </li>
  </ul>

</div>
