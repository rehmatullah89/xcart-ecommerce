<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * X-Cart
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the software license agreement
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.x-cart.com/license-agreement.html
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
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 */


namespace XLite\Module\XC\Mobile\Controller;

/**
 * Abstract controller
 *
 */
abstract class AController extends \XLite\Controller\AController implements \XLite\Base\IDecorator
{
    /**
     * Data URL cache
     *
     * @var string
     */
    static protected $jQmDataURL;

    /**
     * params
     *
     * @var string
     */
    protected $params = array('target', 'widget');

    /**
     * Defines the data URL for jQuery Mobile
     *
     * @return string
     */
    public function getDataURL()
    {
        if (!isset(static::$jQmDataURL)) {
            static::$jQmDataURL = \XLite\Core\URLManager::getShopURL($this->getURL());
        }
        return static::$jQmDataURL;
    }

    /**
     * Defines the data URL ID for jQuery Mobile
     *
     * @return string
     */
    public function getIdDataURL()
    {
        return 'data-url-id-' . str_replace(array(' ', '.'), '-', microtime());
    }

    /**
     * Print AJAX request output
     *
     * @param mixed $viewer Viewer to display in AJAX
     *
     * @return void
     */
    protected function printAJAXOuput($viewer)
    {
        if (\XLite\Core\Request::isMobileDevice()) {
            if (
                !empty(\XLite\Core\Request::getInstance()->body)
                && 'dialog' == \XLite\Core\Request::getInstance()->body
            ) {
                echo '<div data-role="page" class="dialog-window" data-add-back-btn="true" data-dom-cache="true" data-url="' . $this->getDataURL() . '" id="' . $this->getIdDataURL() . '">
                <div data-role="header" data-inline="true">
                <h1>' . static::t($this->getTitle()) . '</h1>
                </div>
                <div data-role="content">
                ' . $viewer->getContent() . '
                </div>
                </div>';
            } else {
                echo $viewer->getContent();
            }
        } else {
            parent::printAJAXOuput($viewer);
        }

        \XLite\Core\TopMessage::getInstance()->clearAJAX();
    }

    /**
     * Determine search page
     *
     * @return boolean
     */
    public function isSearchPage()
    {
        return $this instanceof \XLite\Controller\Customer\Search;
    }

    protected function doActionSwitchMobile()
    {
        \XLite\Core\Request::doEnableMobile();
        $this->setReturnURL(\XLite\Core\Request::getInstance()->returnURL);
    }

    protected function doActionSwitchDesktop()
    {
        \XLite\Core\Request::doDisableMobile();
        $this->setReturnURL(\XLite\Core\Request::getInstance()->returnURL);
    }
}