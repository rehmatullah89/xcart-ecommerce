{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Shipping rates list
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2013 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}

<ul class="shipping-rates">
  <li FOREACH="getRates(),rate">
    <input type="radio" id="method{getMethodId(rate)}" name="methodId" value="{getMethodId(rate)}" checked="{isRateSelected(rate)}" />
    <label for="method{getMethodId(rate)}">{getMethodName(rate):h}: <span class="value"><widget class="XLite\View\Surcharge" surcharge="{getTotalRate(rate)}" currency="{cart.getCurrency()}" /></span></label>
    
  </li>
</ul>
