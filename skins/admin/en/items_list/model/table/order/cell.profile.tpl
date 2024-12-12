{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Profile cell
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2014 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}

<img src="images/spacer.gif" alt="{t(#Anonymous Customer#)}" class="anonym {if:!entity.origProfile.anonymous} hidden{end:}" title="{t(#Anonymous Customer#)}" />
<div class="profile-box">
  {if:isProfileRemoved(entity)}
    <span class="removed-profile-name">{getColumnValue(column,entity)}</span>
  {else:}
    <a href="{buildURL(#profile#,##,_ARRAY_(#profile_id#^entity.origProfile.getProfileId()))}">{getColumnValue(column,entity)}</a>
  {end:}
  <span class="profile-email">(<a href="mailto:{entity.profile.getLogin()}">{entity.profile.getLogin()}</a>)</span>
  <img IF="column.noWrap" src="images/spacer.gif" class="right-fade" alt="" />
</div>
