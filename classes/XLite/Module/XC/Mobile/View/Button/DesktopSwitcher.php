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


namespace XLite\Module\XC\Mobile\View\Button;

/**
 * Switcher from Desktop to Mobile version
 */
class DesktopSwitcher extends \XLite\View\Button\Link
{
    /**
     * Set widget params
     *
     * @param array $params Handler params
     *
     * @return void
     */
    public function setWidgetParams(array $params)
    {
        parent::setWidgetParams($params);

        $this->widgetParams[static::PARAM_LOCATION]->setValue($this->getMobileLink());
    }

    /**
     * Defines the CSS files for the widget
     *
     * @return array
     */
    public function getCSSFiles()
    {
        $list = parent::getCSSFiles();
        $list[] = 'modules/XC/Mobile/switcher.css';

        return $list;
    }

    /**
     * Defines the link to the mobile version
     *
     * @return string
     */
    protected function getMobileLink()
    {
        return $this->buildURL('main', 'switch_mobile', array('returnURL' => $this->getURL()));
    }

    /**
     * getDefaultLabel
     *
     * @return string
     */
    protected function getDefaultLabel()
    {
        return 'Switch to mobile version';
    }

    /**
     * The mobile switcher is visible if the customer uses the mobile device but switches to the desktop version
     *
     * @return bool
     */
    protected function isVisible()
    {
        return parent::isVisible() && (
            // Mobile device is detected
            \XLite\Core\Request::detectMobileDevice()
            // But the mobile skin was disabled
            && !\XLite\Core\Request::isMobileEnabled()
        );
    }

    /**
     * getDefaultStyle
     *
     * @return string
     */
    protected function getDefaultStyle()
    {
        return parent::getDefaultStyle() . ' desktop-switcher-button';
    }
}
