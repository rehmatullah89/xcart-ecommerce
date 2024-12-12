{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Order transactions
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2013 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}

{foreach:getTransactions(),index,transaction}
<div class="unit" FOREACH="getTransactionUnits(transaction),id,unit">
  <widget class="\XLite\View\Order\Details\Admin\PaymentActionsUnit" transaction="{transaction}" unit="{unit}" />
  <span IF="!isLastUnit(id)" class="payment-actions-separator">{t(#OR#)}</span>
</div>
{end:}
