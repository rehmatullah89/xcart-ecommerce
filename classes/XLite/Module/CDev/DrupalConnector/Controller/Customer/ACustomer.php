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

namespace XLite\Module\CDev\DrupalConnector\Controller\Customer;

/**
 * Abstract controller (customer interface)
 */
class ACustomer extends \XLite\Controller\Customer\ACustomer implements \XLite\Base\IDecorator
{
    /**
     * Die if trying to access storefront and DrupalConnector module is enabled
     *
     * @return void
     */
    protected function checkStorefrontAccessibility()
    {
        // Run parent method to make some "parent" changes.
        parent::checkStorefrontAccessibility();

        return \XLite\Module\CDev\DrupalConnector\Handler::getInstance()->checkCurrentCMS();
    }

    /**
     * Return Drupal URL
     *
     * @return string|void
     */
    protected function getDrupalLink()
    {
        return \XLite\Core\Config::getInstance()->CDev->DrupalConnector->drupal_root_url
            ?
            : \XLite\Core\Converter::buildURL(null, null, array(), \XLite::CART_SELF);
    }

    /**
     * Perform some actions to prohibit access to storefornt
     *
     * @return void
     */
    protected function closeStorefront()
    {
        $this->getDrupalLink() ? \XLite\Core\Operator::redirect($this->getDrupalLink()) : parent::closeStorefront();
    }
}
