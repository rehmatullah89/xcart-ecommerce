{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Payment methods 
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2014 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}

<div class="no-payments-requested" IF="!hasPaymentMethodsList()">

  <h3>{t(#Payment methods#)}</h3>

  <p>
    {t(#These payment methods were imported from your X-Payments. You can add them to your store at the #)}
    <b><a href="{buildUrl(#payment_settings#)}">{t(#Payment settings#)}</a></b>
    {t(#page.#)}
  </p>
  
  <br/>

  <p>{t(#<b>Note:</b> In case of any problems you should review your X-Payments Connector module settings and, if they are correct, review your payment configurations settings on the X-Payments side.#):h}</p>

  <br/>

  <widget class="\XLite\Module\CDev\XPaymentsConnector\View\Form\PaymentMethods" name="payment_methods" />

    <widget class="XLite\Module\CDev\XPaymentsConnector\View\ItemsList\Model\PaymentMethods" />

  <widget name="payment_methods" end />

  <br />

</div>
