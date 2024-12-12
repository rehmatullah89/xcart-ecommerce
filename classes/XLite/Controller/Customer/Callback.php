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

namespace XLite\Controller\Customer;

/**
 * Payment method callback
 */
class Callback extends \XLite\Controller\Customer\ACheckoutReturn
{
    /**
     * Define the detection method to check the ownership of the transaction
     *
     * @return string
     */
    protected function getDetectionMethodName()
    {
        return 'getCallbackOwnerTransaction';
    }

    /**
     * Hard-coded value to prevent the doAction{action}() calls if the request goes with the "action" parameter
     *
     * @return string
     */
    public function getAction()
    {
        return 'callback';
    }

    /**
     * Process callback
     *
     * @return void
     */
    protected function doActionCallback()
    {
        $txn = $this->detectTransaction();

        if ($txn) {
            $txn->getPaymentMethod()->getProcessor()->processCallback($txn);
            $cart = $txn->getOrder();

            if (!$cart->isOpen()) {
                // TODO: move it to \XLite\Controller\ACustomer

                if ($cart->isPayed()) {
                    $status = $txn->isCaptured()
                        ? \XLite\Model\Order::STATUS_PROCESSED
                        : \XLite\Model\Order::STATUS_AUTHORIZED;
                } else {
                    if ($txn->isRefunded()) {
                        $paymentTransactionSums = $cart->getPaymentTransactionSums();
                        $refunded = isset($paymentTransactionSums[static::t('Refunded amount')])
                            ? $paymentTransactionSums[static::t('Refunded amount')]
                            : 0;

                        // Check if the whole refunded sum (along with the previous refunded transactions for the order)
                        // covers the whole total for order
                        $status = $refunded < ((float)$cart->getTotal())
                            ? \XLite\Model\Order::STATUS_PART_REFUNDED
                            : \XLite\Model\Order::STATUS_REFUNDED;

                    } elseif ($txn->isFailed()) {
                        $status = \XLite\Model\Order::STATUS_FAILED;

                    } elseif ($txn->isVoid()) {
                        $status = \XLite\Model\Order::STATUS_DECLINED;

                    } else {
                        $status = \XLite\Model\Order::STATUS_QUEUED;
                    }
                }
                $cart->setStatus($status);
            }

        } else {
            \XLite\Logger::getInstance()->log(
                'Request callback with undefined payment transaction' . PHP_EOL
                . 'IP address: ' . $_SERVER['REMOTE_ADDR'] . PHP_EOL
                . 'Data: ' . var_export(\XLite\Core\Request::getInstance()->getData(), true),
                LOG_ERR
            );
        }

        \XLite\Core\Database::getEM()->flush();
        $this->set('silent', true);
    }

    /**
     * Check - is service controller or not
     *
     * @return boolean
     */
    protected function isServiceController()
    {
        return true;
    }

}
