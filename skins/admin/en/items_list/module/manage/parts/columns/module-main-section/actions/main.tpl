{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Modules actions list
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2013 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *
 * @ListChild (list="itemsList.module.manage.columns.module-main-section.actions", weight="10")
 *}
<span class="disable" IF="{module.getEnabled()}">
  <input type="hidden" name="switch[{module.getModuleId()}][old]" value="1" />
  {* To prevent disabling modules with the disabled checkbox *}
  <input IF="!canDisable(module)" type="hidden" name="switch[{module.getModuleId()}][new]" value="1" />
  <label for="switch{module.getModuleId()}">
  <input
    type="checkbox"
    name="switch[{module.getModuleId()}][new]"
    {if:!canDisable(module)} disabled="disabled"{end:}
    checked="checked"
    id="switch{module.getModuleId()}" />
  {t(#Enabled#)}</label>
</span>

<span class="enable" IF="{!module.getEnabled()}">
  <input type="hidden" name="switch[{module.getModuleId()}][old]" value="0" />
  <label for="switch{module.getModuleId()}">
  <input
    type="checkbox"
    name="switch[{module.getModuleId()}][new]"
    {if:!canEnable(module)} disabled="disabled"{end:}
    id="switch{module.getModuleId()}" />
  {t(#Enabled#)}</label>
</span>
