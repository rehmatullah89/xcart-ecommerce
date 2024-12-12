{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Center zone
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2014 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}

<div data-role="content">
  <widget IF="!isForceChangePassword()" template="center.tpl" />
  <widget IF="isForceChangePassword()" class="\XLite\View\Model\Profile\ForceChangePassword" />
</div>
