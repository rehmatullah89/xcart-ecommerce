{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Environment footer
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2013 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *
 * @ListChild (list="crud.settings.footer", zone="admin", weight="100")
 *}
{if:page=#Security#}

  <h2>{t(#HTTPS check#)}</h2>

<script type="text/javascript">
<!--
/* uncheck & disable checkboxes */
var customer_security_value = jQuery('input[name="customer_security"][type="checkbox"]').attr('checked');
var full_customer_security_value = jQuery('input[name="full_customer_security"][type="checkbox"]').attr('checked');
var admin_security_value = jQuery('input[name="admin_security"][type="checkbox"]').attr('checked');
var httpsEnabled = false;

function https_checkbox_click()
{
    if (!httpsEnabled) {
      jQuery('input[name="customer_security"][type="checkbox"]').attr('checked', '');
      jQuery('input[name="admin_security"][type="checkbox"]').attr('checked', '');
      jQuery('input[name="full_customer_security"][type="checkbox"]').attr('disabled', 'disabled');

      document.getElementById("httpserror-message").style.cssText = "";

      alert("No HTTPS is available. See the red message below.");
    }

    if (jQuery('input[name="customer_security"][type="checkbox"]').attr('checked') == false) {
      jQuery('input[name="full_customer_security"][type="checkbox"]').attr({'checked' : '', 'disabled' : 'disabled'});
    } else {
      jQuery('input[name="full_customer_security"][type="checkbox"]').attr('disabled', '');
    }
}

function enableHTTPS()
{
    httpsEnabled = true;
    jQuery('input[name="customer_security"][type="checkbox"]').attr('checked', customer_security_value);

    if (customer_security_value)
      jQuery('input[name="full_customer_security"][type="checkbox"]').attr('disabled', '');
    else
      jQuery('input[name="full_customer_security"][type="checkbox"]').attr('disabled', 'disabled');

    jQuery('input[name="full_customer_security"][type="checkbox"]').attr('checked', full_customer_security_value);
    jQuery('input[name="admin_security"][type="checkbox"]').attr('checked', admin_security_value);

    document.getElementById("httpserror-message").style.cssText = "";
    document.getElementById("httpserror-message").innerHTML = "<span class='success-message'>" + xliteConfig.success_lng + "</span>";
}

jQuery('input[name="customer_security"][type="checkbox"]').attr('checked', '');
jQuery('input[name="full_customer_security"][type="checkbox"]').attr({'checked': '', 'disabled': 'disabled'});
jQuery('input[name="admin_security"][type="checkbox"]').attr('checked', '');

jQuery(
'input[name="customer_security"][type="checkbox"],input[name="full_customer_security"][type="checkbox"], input[name="admin_security"][type="checkbox"]'
).click(https_checkbox_click);
-->
</script>

  {* Check if https is available *}
  {t(#Trying to access the shop at X#,_ARRAY_(#url#^getShopURL(#cart.php#,#1#))):h}
  <span id="httpserror-message" style="visibility:hidden">
    <p class="error-message"><strong>{t(#Failed#)}:</strong> {t(#Secure connection cannot be established.#)}</p>
    {t(#To fix this problem, do the following: 3 points#):h}
  </span>

<script type="text/javascript" src="{getShopURL(#https_check.php#,#1#)}"></script>
<script type="text/javascript">
<!--
if (!httpsEnabled) {
    document.getElementById('httpserror-message').style.cssText = '';
}
-->
</script>

{end:}
