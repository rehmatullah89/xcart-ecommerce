{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * TODO: the View\Model should be used instead
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2013 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}

<p>{t(#Mandatory fields are marked with an asterisk#)} (<span class="star">*</span>).<br /><br />

<widget class="XLite\View\Form\Product\Modify\Single" name="modify_form" className="product-modify-form" />

<table class="product-list">

<tr>
  <td class="name-attribute">&nbsp;</td>
  <td class="star">&nbsp;</td>
  <td class="value-attribute">&nbsp;</td>
</tr>

<list name="product.modify.list" />

</table>

<widget name="modify_form" end />
