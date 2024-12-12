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
 * @copyright Copyright (c) 2011-2014 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 */

namespace XLite\Module\CDev\XPaymentsConnector\View\Settings;

/**
 * Test module
 *
 * @ListChild (list="crud.modulesettings.header", zone="admin", weight="10")
 */
class Tabs extends \XLite\Module\CDev\XPaymentsConnector\View\Settings\ASettings
{
    /**
     * Tab/section of the current setting
     */

    /**
     * Tab/section of the current setting
     * 
     * @var string
     */
    protected $section = self::SECTION_BOTH;

    /**
     * Return navigation tabs
     *
     * @return array
     */
    public function getTabs()
    {
        $tabs = array(
            self::SECTION_CONNECTION => array(
                'title' => 'Connection',
            ),
            self::SECTION_PAYMENT_METHODS => array(
                'title' => 'Payment methods',
            ),
        );

        foreach ($tabs as $key => $tab) {
            $tabs[$key]['url'] = \XLite\Core\Converter::buildUrl(
                'module',
                '',
                array(
                    'moduleId' => $this->getModule()->getModuleId(),
                    'section' => $key
                )
            );
        }

        if ($tabs[\XLite\Core\Request::getInstance()->section]) {
            $tabs[\XLite\Core\Request::getInstance()->section]['selected'] = true;
        }

        return $tabs;
    }

    /**
     * Return widget default template
     *
     * @return string
     */
    protected function getDefaultTemplate()
    {
        return $this->getDir() . '/tabs.tpl';
    }

}
