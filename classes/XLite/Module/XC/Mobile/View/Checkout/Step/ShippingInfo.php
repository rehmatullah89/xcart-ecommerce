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


namespace XLite\Module\XC\Mobile\View\Checkout\Step;

/**
 * Shipping step
 */
class ShippingInfo extends \XLite\View\Checkout\Step\Shipping
{
    /**
     * Get step title
     *
     * @return string
     */
    public function getTitle()
    {
        return static::t('Shipping / Billing address');
    }

    /**
     * Check - step is complete or not
     *
     * @return boolean
     */
    public function isCompleted()
    {
        return $this->isShippingCompleted() && $this->isPaymentCompleted();
    }

    /**
     * Check - shipping substep is complete or not
     *
     * @return boolean
     */
    protected function isShippingCompleted()
    {
        return !$this->isShippingEnabled()
            || (
                $this->isShippingAddressCompleted()
                && $this->getCart()->getProfile()->getLogin()
            );
    }

    /**
     * Check if payment substep is completed
     *
     * @return boolean
     */
    protected function isPaymentCompleted()
    {
        return $this->getCart()->getProfile()
            && $this->getCart()->getProfile()->getBillingAddress()
            && $this->getCart()->getProfile()->getBillingAddress()->isCompleted(\XLite\Model\Address::BILLING);
    }

    /**
     * Get step name
     *
     * @return string
     */
    public function getStepName()
    {
        return 'shipping';
    }
}
