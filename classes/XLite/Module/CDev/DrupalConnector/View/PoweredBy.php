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

namespace XLite\Module\CDev\DrupalConnector\View;

/**
 * 'Powered by' widget
 */
class PoweredBy extends \XLite\View\PoweredBy implements \XLite\Base\IDecorator
{
    /**
     * Advertise phrases
     *
     * @var array
     */
    protected $phrases = array(
        'Powered by [e-commerce CMS]: X-Cart 5 plus Drupal',
        'Powered by [e-commerce CMS]: X-Cart 5 plus Drupal',
        'Powered by [e-commerce CMS]: X-Cart 5 plus Drupal',
        'Powered by [eCommerce CMS]: X-Cart 5 plus Drupal',
        'Powered by [eCommerce CMS]: X-Cart 5 plus Drupal',
        'Powered by [eCommerce CMS]: X-Cart 5 plus Drupal',
        'Powered by [e-commerce CMS software]: X-Cart 5 plus Drupal',
        'Powered by [eCommerce CMS software]: X-Cart 5 plus Drupal',
        'Powered by [e-commerce CMS solution]: X-Cart 5 plus Drupal',
        'Powered by [eCommerce CMS solution]: X-Cart 5 plus Drupal',
        'Powered by X-Cart 5 [shopping cart] and Drupal CMS',
        'Powered by X-Cart 5 [shopping cart software] and Drupal CMS',
        'Powered by X-Cart 5 [eCommerce shopping cart] and Drupal CMS',
        'Powered by X-Cart 5 [eCommerce software] and Drupal CMS',
        'Powered by X-Cart 5 [eCommerce solution] and Drupal CMS',
        'Powered by X-Cart 5 [e-commerce software] and Drupal CMS',
        'Powered by X-Cart 5 [e-commerce solution] and Drupal CMS',
    );


    /**
     * Check - display widget as link or as box
     *
     * @return boolean
     */
    public function isLink()
    {
        return \XLite\Module\CDev\DrupalConnector\Handler::getInstance()->checkCurrentCMS()
            ? drupal_is_front_page()
            : parent::isLink();
    }

    /**
     * Return a Powered By message
     *
     * @return string
     */
    public function getMessage()
    {
        if ($this->isLink()) {
            $phrase = 'Powered by <a href="http://www.x-cart.com/">X-Cart 5</a>'
                . ' integrated with <a href="http://drupal.org/">Drupal</a>';

        } else {
            $phrase = 'Powered by X-Cart 5 integrated with Drupal';
        }

        return $phrase;
    }
}
