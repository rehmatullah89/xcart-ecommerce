{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Delete confirmation template
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2013 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}

<form action="admin.php" name="confirm_delete_profile" method="post">
  <widget class="\XLite\View\FormField\Input\FormId" />

  {t(#WARNING! There are no more available administrators' profiles. You will not be able to manage your store after you delete this profile.#)}<br />

  <br />

  {t(#Are you sure you want to delete this profile?#)}

  <br />
  <br />

  <input type="hidden" foreach="allParams,_name,_value" name="{_name}" value="{_value}" />
  <input type="hidden" name="action" value="delete" />

  <a href="javascript: void();" onclick="javascript: document.confirm_delete_profile.submit();"><img src="skins/admin/en/images/go.gif" width="13" height="13" align="absmiddle" alt="" /> {t(#Yes#)}</a>
  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  <a href="javascript: history.go(-1)"><img src="skins/admin/en/images/go.gif" width="13" height="13" align="absmiddle" alt="" /> {t(#No#)}</a>

</form>
