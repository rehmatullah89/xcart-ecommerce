{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Test module 
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2014 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}

<br/>
<br/>

<p>{t(#X-Cart automatically checks the connection to X-Payments after the settings are saved.<br/> If the module is configured properly, a "Test transaction completed successfully" message is displayed at the top of the page.#):h}</p>

<br/>

<p>
  {t(#Once the connection is verified, you should proceed to the#)}
  <b><a href="{buildUrl(#module#,##,_ARRAY_(#moduleId#^module.getModuleID(),#section#^#payment_methods#))}">{t(#Payment methods#)}</a></b>
  {t(#section.#)}
</p>

<br/>
