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

namespace XLite\Module\CDev\XPaymentsConnector\View\Model;

/**
 * Export payment methods form
 *
 */
class Settings extends \XLite\View\Model\Settings implements \XLite\Base\IDecorator
{
    /**
     * Check if this is X-Payments Connectr settings. Return module ID if any
     *
     * @return integer
     */
    protected function isXpaymentsConnector()
    {
        $result = false;

        $options = $this->getOptions();

        if (
            'CDev\XPaymentsConnector' == $options[0]->category
            && $this->getModule()
            && $this->getModule()->getModuleId()
            && 'CDev\XPaymentsConnector' == $this->getModule()->getActualName()
        ) {
            $result = $this->getModule()->getModuleId();
        }

        return $result;
    }

    /**
     * Return fields list by the corresponding schema
     *
     * @return array
     */
    protected function getFormFieldsForSectionDefault()
    {
        $result = parent::getFormFieldsForSectionDefault();

        if (
            $this->isXpaymentsConnector()
            && 'payment_methods' == \XLite\Core\Request::getInstance()->section
        ) {
            $result = $this->getFieldsBySchema(array());
        }

        return $result;
    }

    /**
     * Return list of the "Button" widgets
     *
     * @return array
     */
    protected function getFormButtons()
    {
        if ($this->isXpaymentsConnector()) {

            if ('connection' == \XLite\Core\Request::getInstance()->section) {
                $result['submit'] = new \XLite\View\Button\Submit(
                    array(
                        \XLite\View\Button\AButton::PARAM_LABEL => 'Submit and test module',
                        \XLite\View\Button\AButton::PARAM_STYLE => 'action',
                    )
                );
            } elseif ('payment_methods' == \XLite\Core\Request::getInstance()->section) {

                $result = array();

            }

        } else {

            $result = parent::getFormButtons();

        }

        return $result;
    }

    /**
     * Return form templates directory name
     *
     * @param string $template Template file base name
     *
     * @return void
     */
    protected function getFormTemplate($template)
    {
        if (
            $this->isXpaymentsConnector()
            && 'footer' == $template
            && 'connection' == \XLite\Core\Request::getInstance()->section
            && \XLite\Module\CDev\XPaymentsConnector\Core\XPaymentsClient::getInstance()->isModuleConfigured()
        ) {
            $result = '../modules/CDev/XPaymentsConnector/settings/connection/test.tpl';
        } else {
            $result = parent::getFormTemplate($template);
        }

        return $result;
    }
}
