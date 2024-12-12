{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Modules main section list
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2013 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *
 * @ListChild (list="itemsList.module.manage.columns.module-main-section", weight="30")
 * @ListChild (list="itemsList.module.install.columns.module-main-section", weight="400")
 *}

<div IF="hasErrors(module)">
  <list name="cannot_enable" type="nested" module="{module}" />
</div>
