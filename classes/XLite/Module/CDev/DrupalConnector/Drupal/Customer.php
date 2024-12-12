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

namespace XLite\Module\CDev\DrupalConnector\Drupal;

/**
 * Customer
 */
class Customer extends \XLite\Module\CDev\DrupalConnector\Drupal\ADrupal
{
    /**
     * Modify login form
     *
     * @param array &$form      Form description
     * @param array &$formState Form state
     *
     * @return void
     */
    public function alterLoginForm(array &$form, array &$formState)
    {
        $form[\XLite\Core\CMSConnector::NO_REDIRECT] = array(
            '#type'  => 'hidden',
            '#value' => true,
        );
    }

    /**
     * Return content for the "Orders" tab
     *
     * @param \stdClass $account Current user descriptor
     *
     * @return void
     */
    public function getOrderHistoryPage(\stdClass $account)
    {
        $this->getHandler()->mapRequest(array('target' => 'order_list'));
        
        drupal_set_title(t('Orders list'));

        return \XLite\Module\CDev\DrupalConnector\Drupal\Controller::getInstance()->getContent();
    }
}