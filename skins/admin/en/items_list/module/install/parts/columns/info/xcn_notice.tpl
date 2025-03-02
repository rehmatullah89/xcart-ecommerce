{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * X-Cart module notice
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2014 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *
 * @ListChild (list="itemsList.module.install.columns.module-main-section", weight="200")
 *}
<div class="note error xcn-module-notice" IF="showXCNModuleNotice(module)">
{t(#Module available editions#,_ARRAY_(#list#^getEditions(module),#URL#^getPurchaseURL())):h}
<div class="or-activate">
  <widget class="\XLite\View\Button\ActivateKey" label="Activate license key" />
</div>
</div>
