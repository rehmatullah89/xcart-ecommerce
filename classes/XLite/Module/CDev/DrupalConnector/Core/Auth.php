<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * X-Cart
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the GNU General Pubic License (GPL 2.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.gnu.org/licenses/gpl-2.0.html
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to licensing@x-cart.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not modify this file if you wish to upgrade X-Cart to newer versions
 * in the future. If you wish to customize X-Cart for your needs please
 * refer to http://www.x-cart.com/ for more information.
 *
 * @category  X-Cart 5
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2013 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU General Pubic License (GPL 2.0)
 * @link      http://www.x-cart.com/
 */

namespace XLite\Module\CDev\DrupalConnector\Core;

/**
 * Authorization routine
 */
class Auth extends \XLite\Core\Auth implements \XLite\Base\IDecorator
{
    /**
     * Get stored profiel id
     *
     * @return integer
     */
    protected function getStoredProfileId()
    {
        $profileId = parent::getStoredProfileId();

        if (
            !$profileId
            && \XLite\Module\CDev\DrupalConnector\Handler::getInstance()->checkCurrentCMS()
            && !empty($GLOBALS['user'])
            && !empty($GLOBALS['user']->uid)
        ) {
            $profileId = \XLite\Module\CDev\DrupalConnector\Handler::getInstance()
                ->getProfileIdByCMSId($GLOBALS['user']->uid);
            
            if ($profileId) {
                // Save profile Id in session
                \XLite\Core\Session::getInstance()->profile_id = $profileId;
            }
        }

        return $profileId;
    }
}
