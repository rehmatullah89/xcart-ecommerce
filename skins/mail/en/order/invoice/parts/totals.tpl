{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Invoice totals
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2013 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *
 * @ListChild (list="invoice.base", weight="40")
 *}

<div style="width: 40%; float: right; display: block; padding-top: 25px; padding-bottom: 25px;">
<b>{t(#Totals#)}</b>
<table cellspacing="1" cellpadding="3" width="100%">
  <list name="invoice.base.totals" />
</table>
</div>