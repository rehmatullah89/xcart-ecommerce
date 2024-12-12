{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Import payment methods 
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2014 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}

<widget template="modules/CDev/XPaymentsConnector/settings/payment_methods/import.header.tpl" IF="!hasPaymentMethodsList()">

<div IF="hasPaymentMethodsList()" class="items-list-table">

  <h3>{t(#X-Payments returned the following payment methods for your shopping cart:#)}</h3>

  <widget class="\XLite\Module\CDev\XPaymentsConnector\View\Form\ImportPaymentMethods" name="export" />

    <table class="list" cellspacing="0">
      <thead>
        <tr>
          <th>{t(#Payment method#)}</th>
          <th>{t(#X-Payments configuration ID#)}</th>
          <th>{t(#Sale#)}</th>
          <th>{t(#Auth#)}</th>
          <th>{t(#Capture#)}</th>
          <th>{t(#Void#)}</th>
          <th>{t(#Refund#)}</th>
        </tr>
      </thead>
      <tbody class="lines">
        <tr FOREACH="getPaymentMethodsList(),pm" class="line">
          <td class="cell no-wrap">{pm.name}</td>
          <td class="cell no-wrap">{pm.id}</td>
          <td class="cell no-wrap">{getTransactionTypeStatus(pm,#sale#)}</td>
          <td class="cell no-wrap">{getTransactionTypeStatus(pm,#auth#)}</td>
          <td class="cell no-wrap">{getTransactionTypeStatus(pm,#capture#)}</td>
          <td class="cell no-wrap">{getTransactionTypeStatus(pm,#void#)}</td>
          <td class="cell no-wrap">{getTransactionTypeStatus(pm,#refund#)}</td>
        </tr>
      </tbody>  
    </table>

    <br/>

    {if:isPaymentMethodsImported()}

      <p>{t(#<b>Warning! Payment methods have already been imported from X-Payments earlier.</b><br/> All payment methods previously imported from X-Payments will be removed from your store's database if you choose to replace the payment methods.#):h}</p>

      <br/>

      <widget class="\XLite\View\Button\Submit" label="{t(#Replace payment methods#)}" style="main" />

      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

      <a href="{buildUrl(#module#,#xpc_clear#,_ARRAY_(#moduleId#^module.getModuleID(),#section#^#payment_methods#))}">{t(#Cancel import and keep current payment methods#)}</a>

    {else:}

      <widget class="\XLite\View\Button\Submit" label="{t(#Import payment methods#)}" style="main" />

    {end:}

  <widget name="export" end />

</div>
