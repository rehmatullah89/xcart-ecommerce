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


namespace XLite\Module\XC\Mobile\View\Checkout;

/**
 * Checkout steps block
 *
 */
class Steps extends \XLite\View\Checkout\Steps implements \XLite\Base\IDecorator
{
    /**
     * Current step
     *
     * @var \XLite\View\Checkout\Step\AStep
     */
    protected $currentStep;

    /**
     * Define checkout widget steps
     *
     * @return array
     */
    protected function defineSteps()
    {
        return \XLite\Core\Request::isMobileDevice()
            ? $this->defineMobileCheckoutSteps()
            : parent::defineSteps();
    }

    /**
     * Define checkout widget steps for mobile device
     *
     * @return array
     */
    protected function defineMobileCheckoutSteps()
    {
        $steps = array();
        if ($this->isNewCustomer()) {
            $steps[] = '\XLite\Module\XC\Mobile\View\Checkout\Step\Login';
        }
        $steps[] = '\XLite\Module\XC\Mobile\View\Checkout\Step\ShippingInfo';
        $steps[] = '\XLite\Module\XC\Mobile\View\Checkout\Step\Methods';
        $steps[] = '\XLite\View\Checkout\Step\Review';

        return $steps;
    }

    /**
     * Check - specified step is completed or not
     *
     * @param \XLite\View\Checkout\Step\AStep $step Step
     *
     * @return boolean
     */
    public function isCompletedStep(\XLite\View\Checkout\Step\AStep $step)
    {
        return $step->isCompleted();
    }

    /**
     * Get current step
     *
     * @return \XLite\View\Checkout\Step\AStep
     */
    public function getCurrentStep()
    {
        if (!isset($this->currentStep)) {
            foreach ($this->getSteps() as $k => $step) {
                if (!$step->isCompleted() ||  \XLite\Core\Request::getInstance()->step == $k) {
                    $this->currentStep = $step;
                    break;
                }
            }
        }

        return $this->currentStep;
    }

    /**
     * Check - specified step is current or not
     *
     * @param \XLite\View\Checkout\Step\AStep $step Step
     *
     * @return boolean
     */
    public function isCurrentStep(\XLite\View\Checkout\Step\AStep $step)
    {
        return $this->getCurrentStep() == $step;
    }

    /**
     * The checkout steps structure will be slightly changed for mobile skin
     *
     * @return array
     */
    protected function getMobileSteps()
    {
        $result = array();
        $index = 1;
        foreach($this->getSteps() as $key => $widget) {
            $result[$key] = array(
                'widget'        => $widget,
                'stepNumber'    => $widget->getTitle() ? ($index++) : false,
            );
        }
        return $result;
    }

}
