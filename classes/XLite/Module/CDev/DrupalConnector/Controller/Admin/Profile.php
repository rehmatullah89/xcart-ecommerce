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

namespace XLite\Module\CDev\DrupalConnector\Controller\Admin;

/**
 * \XLite\Module\CDev\DrupalConnector\Controller\Admin\Profile
 */
class Profile extends \XLite\Controller\Admin\Profile implements \XLite\Base\IDecorator
{

    /**
     * Set if the form id is needed to make an actions
     * Form class uses this method to check if the form id should be added
     *
     * @return boolean
     */
    public static function needFormId()
    {
        return parent::needFormId() && !defined('MAINTENANCE_MODE');
    }

    /**
     * Prevent users registering by administrator
     *
     * @return void
     */
    public function handleRequest()
    {
        if ($this->isRegisterMode() || 'delete' === \XLite\Core\Request::getInstance()->action) {

            \XLite\Core\TopMessage::addError(
                'It is impossible to delete or create user accounts because your store currently works as an integration with Drupal and shares users with Drupal. Deleting/creating user accounts is possible via Drupal administrator interface.'
            );

            $this->markAsAccessDenied();
        }

        return parent::handleRequest();
    }
}
