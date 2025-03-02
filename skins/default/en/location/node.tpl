{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Common node
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2013 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}

<li class="location-node{if:getSubnodes()} expandable{end:}{if:isLast()} last{end:}">

  <a IF="getLink()" href="{getLink()}" class="location-title">{t(getName())}</a>
  <span IF="!getLink()" class="location-text">{t(getName())}</span>

  <ul class="location-subnodes" IF="getSubnodes()">
    <li FOREACH="getSubnodes(),node">
      <a href="{node.getLink()}" IF="!node.getName()=getName()">{t(node.getName())}</a>
      <a href="{node.getLink()}" IF="node.getName()=getName()" class="current">{t(node.getName())}</a>
    </li>
  </ul>

</li>
