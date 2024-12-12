{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Test module 
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2014 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}

<div class="no-payments-requested">

  <h3 IF="isPaymentMethodsImported()">{t(#Re-import payment methods#)}</h3>
  <h3 IF="!isPaymentMethodsImported()">{t(#Import payment methods#)}</h3>

    <widget class="\XLite\Module\CDev\XPaymentsConnector\View\Form\ExportPaymentMethods" name="import" />

      <p IF="isPaymentMethodsImported()">{t(#Click the button below to re-import payment methods from X-Payments.#)}</p>
      <p IF="!isPaymentMethodsImported()">{t(#To be able to use the payment methods defined in X-Payments you should import information about them from X-Payments. Click the button below and X-Payments will return a list of payment methods available for this shopping cart.#)}</p>

      <br/>

      <widget class="\XLite\View\Button\Submit" label="{t(#Request payment methods#)}" style="main" />

  <widget name="import" end />

</div>
