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

namespace XLite\Module\CDev\DrupalConnector\View\Menu\Admin;

/**
 * 'Powered by' widget
 */
class TopLinks extends \XLite\View\Menu\Admin\TopLinks implements \XLite\Base\IDecorator
{
    /**
     * Gathering Drupal return URL from request and save it in session
     *
     * @return void
     */
    public function init()
    {
        parent::init();

        $paramReturnURL = \XLite\Module\CDev\DrupalConnector\Drupal\Module::PARAM_DRUPAL_RETURN_URL;

        // User come from Drupal - save return URL in session
        if (\XLite\Core\Request::getInstance()->$paramReturnURL) {
            \XLite\Core\Session::getInstance()->$paramReturnURL = \XLite\Core\Request::getInstance()->$paramReturnURL;
        }
    }


    /**
     * Disable storefront menu in top links
     *
     * @return boolean
     */
    protected function isStorefrontMenuVisible()
    {
        return false;
    }

    /**
     * Return Drupal frontend URL
     *
     * @return string
     */
    protected function getDrupalURL()
    {
        return \XLite\Core\Config::getInstance()->CDev->DrupalConnector->drupal_root_url
            ?
            : \XLite\Core\Converter::buildURL(null, null, array(), \XLite::CART_SELF);
    }

    /**
     * Check if Drupal URL is stored in config variables
     *
     * @return boolean
     */
    protected function hasDrupalURL()
    {
        return (bool)$this->getDrupalURL();
    }

    /**
     * Returns a Drupal return URL
     *
     * @return string
     */
    protected function getDrupalReturnURL()
    {
        return \XLite\Core\Session::getInstance()
            ->{\XLite\Module\CDev\DrupalConnector\Drupal\Module::PARAM_DRUPAL_RETURN_URL};
    }

    /**
     * Check if Drupal return URL is saved in session
     *
     * @return boolean
     */
    protected function hasDrupalReturnURL()
    {
        $paramReturnURL = \XLite\Module\CDev\DrupalConnector\Drupal\Module::PARAM_DRUPAL_RETURN_URL;

        return isset(\XLite\Core\Session::getInstance()->$paramReturnURL)
            && !empty(\XLite\Core\Session::getInstance()->$paramReturnURL)
            && !($this->hasDrupalURL() && \XLite\Core\Session::getInstance()->$paramReturnURL == $this->getDrupalURL());
    }

    /**
     * check if Drupal menu is visible in top links
     *
     * @return boolean
     */
    protected function isDrupalStorefrontLinkVisible()
    {
        return $this->hasDrupalURL() || $this->hasDrupalReturnURL();
    }
}
