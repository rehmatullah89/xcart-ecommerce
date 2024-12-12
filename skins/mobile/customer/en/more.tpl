{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * "More" page layout
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2013 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}

<h2>{t(#Your Account#)}</h2>

<ul data-role="listview" data-inset="true">
  <list IF="!isLoggedMore()" name="layout.header.bar.links.newby" />
  <list IF="isLoggedMore()" name="layout.header.bar.links.logged" />
  <li IF="isContactUs()" class="contact-us-link" data-theme="g">
    <a href="{buildURL(#contact_us#)}">{t(#Contact us#)}</a>
  </li>
</ul>

<widget IF="!isLoggedMore()&isSocialLogin()" template="modules/CDev/SocialLogin/checkout/checkout.social.tpl" />

<div IF="showComparisonButton()" class="compare-button">
  <h2>{t(#More#)}</h2>
  <ul data-role="listview" data-inset="true">
    <li><a href="{buildURL(#compare#)}">{t(#See comparison chart#)}</a></li>
  </ul>
</div>
