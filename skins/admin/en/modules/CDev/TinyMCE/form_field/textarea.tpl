{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * ____file_title____
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2013 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}

<table class="tinymce-widget">
  <tr><td class="textarea">
    {displayCommentedData(getTinyMCEConfiguration())}
    <textarea class="tinymce" {getAttributesCode():h}>{getValue()}</textarea>
  </td>
  <td class="button">
    <widget class="\XLite\View\Button\SwitchButton" first="makeTinyAdvanced" second="makeTinySimple" />
  </td>
  </tr>
</table>

