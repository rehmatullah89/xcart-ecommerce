{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Shopping cart item : subtotal
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2013 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *
 * @ListChild (list="cart.item.price-row", weight="30")
 *}

<div class="price-row">
  <span class="price-parts subtotal{if:item.getExcludeSurcharges()} modified-subtotal{end:}">
    <widget class="XLite\View\Surcharge" surcharge="{item.getTotal()}" currency="{cart.getCurrency()}" />
  </span>
</div>

<div class="clearing"></div>

<div IF="item.getExcludeSurcharges()" class="including-modifiers display-none">
  <table class="including-modifiers" cellspacing="0">
    <tr FOREACH="item.getExcludeSurcharges(),surcharge">
      <td class="name">
        {t(#Including X#,_ARRAY_(#name#^surcharge.getName()))}:
      </td>
      <td class="value">
        <widget class="XLite\View\Surcharge" surcharge="{surcharge.getValue()}" currency="{cart.getCurrency()}" />
      </td>
    </tr>
  </table>
</div>
<list name="cart.item.actions" item="{item}" />
