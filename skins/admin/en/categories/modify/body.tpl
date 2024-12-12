{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Add/Modify category template
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2013 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}

<p>{t(#Mandatory fields are marked with an asterisk#)} (<span class="star">*</span>).<br /><br />

<widget class="XLite\View\Form\Category\Modify\Single" name="modify_form" />

<table title="{t(#Category modify form#)}">
  <list name="category.modify.list" />
</table>

<widget name="modify_form" end />
