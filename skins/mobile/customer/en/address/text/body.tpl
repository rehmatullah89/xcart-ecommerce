{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * ____file_title____
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2013 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}

<table class="address-entry">
{foreach:getSchemaFields(),fieldName,fieldData}
<tr class="address-text-cell address-text-{fieldName}" IF="{getFieldValue(fieldName)}">
  <td class="address-text-label address-text-label-{fieldName}">{fieldData.label}:</td>
  <td class="address-text-value">{getFieldValue(fieldName,1)}</td>
</tr>
{end:}
</table>
