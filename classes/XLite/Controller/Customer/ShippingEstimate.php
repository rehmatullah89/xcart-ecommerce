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

namespace XLite\Controller\Customer;

/**
 * Shipping estimator
 */
class ShippingEstimate extends \XLite\Controller\Customer\ACustomer
{
    /**
     * Modifier (cache)
     *
     * @var \XLite\Model\Order\Modifier
     */
    protected $modifier;

    /**
     * Get page title
     *
     * @return string
     */
    public function getTitle()
    {
        return 'Estimate shipping cost';
    }

    /**
     * Get address
     *
     * @return array
     */
    public function getAddress()
    {
        return \XLite\Model\Shipping::getInstance()->getDestinationAddress($this->getModifier()->getModifier());
    }

    /**
     * Get modifier
     *
     * @return \XLite\Model\Order\Modifier
     */
    public function getModifier()
    {
        if (!isset($this->modifier)) {
            $this->modifier = $this->getCart()->getModifier(\XLite\Model\Base\Surcharge::TYPE_SHIPPING, 'SHIPPING');
        }

        return $this->modifier;
    }

    /**
     * Common method to determine current location
     *
     * @return string
     */
    protected function getLocation()
    {
        return $this->getTitle();
    }

    /**
     * Set estimate destination
     *
     * @return void
     */
    protected function doActionSetDestination()
    {
        $country = \XLite\Core\Database::getRepo('XLite\Model\Country')
            ->find(\XLite\Core\Request::getInstance()->destination_country);

        $state = null;

        if (0 < intval(\XLite\Core\Request::getInstance()->destination_state)) {
            $state = \XLite\Core\Database::getRepo('XLite\Model\State')
                ->find(\XLite\Core\Request::getInstance()->destination_state);

            if (isset($state) && $state->getCountry()->getCode() != \XLite\Core\Request::getInstance()->destination_country) {
                $state = null;
            }
        }

        if (!$state) {
            $state = \XLite\Core\Database::getRepo('XLite\Model\State')
                ->getOtherState(strval(\XLite\Core\Request::getInstance()->destination_custom_state));
        }

        if (
            $country
            && $country->getEnabled()
            && $state
            && \XLite\Core\Request::getInstance()->destination_zipcode
        ) {

            $address = $this->getCartProfile()->getShippingAddress();
            if (!$address) {
                $profile = $this->getCartProfile();
                $address = new \XLite\Model\Address;
                $address->setProfile($profile);
                $address->setIsShipping(true);
                $address->setIsWork(true);
                $profile->addAddresses($address);
                \XLite\Core\Database::getEM()->persist($address);
            }

            $address->setCountry($country);

            if (0 < $state->getStateId()) {
                $address->setState($state);

            } else {
                $address->setState(null);
                $address->setCustomState($state->getState());
            }

            $address->setZipcode(\XLite\Core\Request::getInstance()->destination_zipcode);
            $address->update();

            $this->updateCart();

            $modifier = $this->getCart()->getModifier('shipping', 'SHIPPING');

            if ($modifier) {
                $shippingAddress = \XLite\Model\Shipping::getInstance()
                    ->getDestinationAddress($modifier->getModifier());
                \XLite\Core\Event::updateCart(
                    array(
                        'items'            => array(),
                        'shipping_address' => $shippingAddress,
                    )
                );
            }

            $this->valid = true;

            $this->setInternalRedirect();

        } else {
            \XLite\Core\TopMessage::addError('Shipping address is invalid');

            $this->valid = false;

        }
    }

    /**
     * Change shipping method
     *
     * @return void
     */
    protected function doActionChangeMethod()
    {
        if (
            \XLite\Core\Request::getInstance()->methodId
            && $this->getCart()->getShippingId() != \XLite\Core\Request::getInstance()->methodId
        ) {
            $this->getCart()->getProfile()->setLastShippingId(\XLite\Core\Request::getInstance()->methodId);
            $this->getCart()->setShippingId(\XLite\Core\Request::getInstance()->methodId);

            $address = $this->getCartProfile()->getShippingAddress();
            if (!$address) {

                // Default address
                $profile = $this->getCartProfile();
                $address = new \XLite\Model\Address;

                $addr = $this->getAddress();

                // Country
                $c = 'US';

                if ($addr && isset($addr['country'])) {
                    $c = $addr['country'];

                } elseif (\XLite\Core\Config::getInstance()->General->default_country) {
                    $c = \XLite\Core\Config::getInstance()->General->default_country;
                }

                $country = \XLite\Core\Database::getRepo('XLite\Model\Country')->find($c);

                if ($country) {
                    $address->setCountry($country);
                }

                // State
                $state = null;

                if ($addr && !empty($addr['state'])) {
                    $state = \XLite\Core\Database::getRepo('XLite\Model\State')->find($addr['state']);

                } elseif (
                    !$addr
                    && \XLite\Core\Config::getInstance()->Shipping->anonymous_custom_state
                ) {

                    $state = new \XLite\Model\State();
                    $state->setState(\XLite\Core\Config::getInstance()->Shipping->anonymous_custom_state);

                }

                if ($state) {
                    $address->setState($state);
                }

                // Zip code
                $address->setZipcode(\XLite\Core\Config::getInstance()->General->default_zipcode);

                $address->setProfile($profile);
                $address->setIsShipping(true);
                $profile->addAddresses($address);
                \XLite\Core\Database::getEM()->persist($address);
            }

            $this->updateCart();

            \XLite\Core\Event::updateCart(
                array(
                    'items'    => array(),
                    'shipping' => $this->getCart()->getShippingId(),
                )
            );
        }

        $this->valid = true;
        $this->setSilenceClose();
    }
}
