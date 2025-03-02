{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Email testing feature
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2013 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}

 <h2>{t(#Test email configuration#)}</h2>

  <widget class="\XLite\View\Form\TestEmail" name="test_email" />

  <div IF="hasTestEmailError()" class="test-email-error">
    {getTestEmailError():h}
  </div>

  <table class="settings-table">

    <tr>
      <td>{t(#From email#)}</td>
      <td><widget class="\XLite\View\FormField\Input\Text" fieldName="test_from_email_address" fieldOnly="true" /></td>
    </tr>


    <tr>
      <td>{t(#To email#)}</td>
      <td><widget class="\XLite\View\FormField\Input\Text" fieldName="test_to_email_address" fieldOnly="true" /></td>
    </tr>

    <tr>
      <td>{t(#Email body#)}</td>
      <td><widget class="\XLite\View\FormField\Textarea\Simple" fieldName="test_email_body" fieldOnly="true" /></td>
    </tr>

  </table>

  <widget class="\XLite\View\Button\Submit" label="{t(#Send test email#)}" style="main" />

  <widget name="test_email" end />

