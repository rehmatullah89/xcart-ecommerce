{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Language selector
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2013 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}

<a href="#popup-lang" data-role="button" data-inline="false" data-theme="a" data-rel="popup" data-position-to="window" data-transition="slidedown"><img src="{currentLanguage.flagURL}" alt="{currentLanguage.code}" />&nbsp;{currentLanguage.name}</a>

<div id="popup-lang" data-role="popup" data-overlay-theme="a" data-theme="c">
  <a href="#" data-rel="back" data-role="button" data-icon="delete" data-iconpos="notext" class="ui-btn-right">{t(#Close#)}</a>
  <ul data-role="listview" data-theme="c">
    <li data-role="list-divider" data-theme="b">{t(#Select language#)}</li>
    {foreach:getActiveLanguages(),language}
      <li IF={!isLanguageSelected(language)}><a href="{getChangeLanguageLink(language)}" rel="external"><img src="{language.flagURL}" class="ui-li-icon" alt="{language.code}" />{language.name}</a></li>
    {end:}
  </ul>
</div>