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

namespace XLite\Module\CDev\DrupalConnector\View\Checkout;

/**
 * Profile widget on Checkout page
 */
class Profile extends \XLite\View\Checkout\Profile implements \XLite\Base\IDecorator
{
    /**
     * Get cart Drupal's user name
     *
     * @return string
     */
    public function getUsername()
    {
        return \XLite\Core\Session::getInstance()->order_username ?: '';
    }

    /**
     * Get current profile username
     *
     * @return string
     */
    public function getProfileUsername()
    {
        $profile = $this->getCart()->getProfile()->getCMSProfile();

        return $profile ? $profile->name : parent::getProfileUsername();
    }

    /**
     * Get profile page URL
     *
     * @return string
     */
    public function getProfileURL()
    {
        return \XLite\Module\CDev\DrupalConnector\Handler::getInstance()->checkCurrentCMS()
            ? url('user')
            : parent::getProfileURL();
    }

    /**
     * Get log-off page URL
     *
     * @return string
     */
    public function getLogoffURL()
    {
        return \XLite\Module\CDev\DrupalConnector\Handler::getInstance()->checkCurrentCMS()
            ? url('user/logout')
            : parent::getLogoffURL();
    }
}