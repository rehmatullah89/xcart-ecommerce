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

namespace XLite\Model\Payment\Base;

/**
 * Processor
 */
abstract class Processor extends \XLite\Base
{
    /**
     * Payment procedure result codes
     */
    const PROLONGATION = 'R';
    const SILENT       = 'W';
    const SEPARATE     = 'E';
    const COMPLETED    = 'S';
    const PENDING      = 'P';
    const FAILED       = 'F';


    /**
     * Transaction (cache)
     *
     * @var \XLite\Model\Payment\Transaction
     */
    protected $transaction;

    /**
     * Request cell with transaction input data
     *
     * @var array
     */
    protected $request;


    /**
     * Do initial payment
     *
     * @return string Status code
     */
    abstract protected function doInitialPayment();

    /**
     * Get allowed transactions list
     *
     * @return string Status code
     */
    public function getAllowedTransactions()
    {
        return array();
    }

    /**
     * Return tru if backend transaction is allowed for current payment transaction
     * 
     * @param \XLite\Model\Payment\Transaction $transaction     Payment transaction object
     * @param string                           $transactionType Backend transaction type
     *  
     * @return boolean
     */
    public function isTransactionAllowed(\XLite\Model\Payment\Transaction $transaction, $transactionType)
    {
        $result = false;

        if (in_array($transactionType, $this->getAllowedTransactions())) {

            $methodName = 'is' . ucfirst($transactionType) . 'TransactionAllowed';

            if (method_exists($transaction, $methodName)) {
                // Call transaction tyoe specific method 
                $result = $transaction->$methodName();
            }
            
            if (method_exists($this, $methodName)) {
                $result = $this->{'is' . ucfirst($transactionType) . 'TransactionAllowed'}($transaction);
            }
        }

        return $result;
    }

    /**
     * doTransaction 
     * 
     * @param \XLite\Model\Payment\Transaction $transaction     Payment transaction object
     * @param string                           $transactionType Backend transaction type
     *  
     * @return void
     */
    public function doTransaction(\XLite\Model\Payment\Transaction $transaction, $transactionType)
    {
        if ($this->isTransactionAllowed($transaction, $transactionType)) {

            $methodName = 'do' . ucfirst($transactionType);

            if (method_exists($this, $methodName)) {
                $this->transaction = $transaction;
                $txn = $transaction->createBackendTransaction($transactionType);
                // Call backend transaction type specific method
                $this->$methodName($txn);

                $txn->registerTransactionInOrderHistory();
            }
        }
    }

    /**
     * Pay
     *
     * @param \XLite\Model\Payment\Transaction $transaction Transaction
     * @param array                            $request     Input data request OPTIONAL
     *
     * @return string
     */
    public function pay(\XLite\Model\Payment\Transaction $transaction, array $request = array())
    {
        $this->transaction = $transaction;
        $this->request = $request;

        $this->saveInputData();

        return $this->doInitialPayment();
    }

    /**
     * Get input template
     *
     * @return string|void
     */
    public function getInputTemplate()
    {
        return null;
    }

    /**
     * Get input errors
     *
     * @param array $data Input data
     *
     * @return array
     */
    public function getInputErrors(array $data)
    {
        return array();
    }

    /**
     * Check - payment method is configurable or not
     * 
     * @param \XLite\Model\Payment\Method $method Payment method
     *  
     * @return boolean
     */
    public function isConfigurable(\XLite\Model\Payment\Method $method)
    {
        return (bool)$this->getConfigurationURL($method);
    }

    /**
     * Get payment method configuration page URL
     *
     * @param \XLite\Model\Payment\Method $method Payment method
     *
     * @return string
     */
    public function getConfigurationURL(\XLite\Model\Payment\Method $method)
    {
        $url = null;

        if ($this->getSettingsWidget()) {
            $url = \XLite\Core\Converter::buildURL('payment_method', '', array('method_id' => $method->getMethodId()));

        } elseif ($this->hasModuleSettings() && $this->getModule() && $this->getModule()->getSettingsForm()) {
            $url = $this->getModule()->getSettingsForm();
            $url .= (false === strpos($url, '?') ? '?' : '&')
                . 'return=' . urlencode(\XLite\Core\Converter::buildURL('payment_settings'));
        }

        return $url;
    }

    /**
     * Get settings widget or template
     *
     * @return string Widget class name or template path
     */
    public function getSettingsWidget()
    {
        return null;
    }

    /**
     * Payment method has settings into Module settings section
     *
     * @return boolean
     */
    public function hasModuleSettings()
    {
        return false;
    }

    /**
     * Check - payment method is configured or not
     *
     * @param \XLite\Model\Payment\Method $method Payment method
     *
     * @return boolean
     */
    public function isConfigured(\XLite\Model\Payment\Method $method)
    {
        return true;
    }

    /**
     * Return true if payment method supports currency defined in store
     *
     * @param \XLite\Model\Payment\Method $method Payment method
     *
     * @return boolean
     */
    public function isCurrencyApplicable(\XLite\Model\Payment\Method $method)
    {
        $currencies = $this->getAllowedCurrencies($method);

        return !$currencies || in_array(\XLite::getInstance()->getCurrency()->getCode(), $currencies);
    }

    /**
     * Check - payment processor is applicable for specified order or not
     *
     * @param \XLite\Model\Order          $order  Order
     * @param \XLite\Model\Payment\Method $method Payment method
     *
     * @return boolean
     */
    public function isApplicable(\XLite\Model\Order $order, \XLite\Model\Payment\Method $method)
    {
        $currencies = $this->getAllowedCurrencies($method);

        return !$currencies || in_array($order->getCurrency()->getCode(), $currencies);
    }

    /**
     * Get payment method icon path
     *
     * @param \XLite\Model\Order          $order  Order
     * @param \XLite\Model\Payment\Method $method Payment method
     *
     * @return string
     */
    public function getIconPath(\XLite\Model\Order $order, \XLite\Model\Payment\Method $method)
    {
        return null;
    }

    /**
     * Get payment method row checkout template
     *
     * @param \XLite\Model\Payment\Method $method Payment method
     *
     * @return string
     */
    public function getCheckoutTemplate(\XLite\Model\Payment\Method $method)
    {
        return 'checkout/steps/shipping/parts/paymentMethod.tpl';
    }

    /**
     * Get processor module
     *
     * @return \XLite\Model\Module
     */
    public function getModule()
    {
        return preg_match('/XLite\\\Module\\\(\w+)\\\(\w+)\\\/Ss', get_called_class(), $match)
            ? \XLite\Core\Database::getRepo('XLite\Model\Module')
                ->findOneBy(array('author' => $match[1], 'name' => $match[2]))
            : null;
    }

    /**
     * Get initial transaction type (used when customer places order)
     *
     * @param \XLite\Model\Payment\Method $method Payment method object OPTIONAL
     *
     * @return string
     */
    public function getInitialTransactionType($method = null)
    {
        return \XLite\Model\Payment\BackendTransaction::TRAN_TYPE_SALE;
    }

    /**
     * Get current transaction order
     *
     * @return \XLite\Model\Order
     */
    protected function getOrder()
    {
        return $this->transaction->getOrder();
    }

    /**
     * Get current transaction order profile
     *
     * @return \XLite\Model\Profile
     */
    protected function getProfile()
    {
        return $this->transaction->getOrder()->getProfile();
    }

    /**
     * Get setting value by name
     *
     * @param string $name Name
     *
     * @return mixed
     */
    protected function getSetting($name)
    {
        return $this->transaction
            ? $this->transaction->getPaymentMethod()->getSetting($name)
            : null;
    }

    /**
     * Save input data
     *
     * @return void
     */
    protected function saveInputData($backendTransaction = null)
    {
        $labels = $this->getInputDataLabels();
        $accessLevels = $this->getInputDataAccessLevels();

        foreach ($this->request as $name => $value) {
            if (isset($accessLevels[$name])) {
                $this->setDetail(
                    $name,
                    $value,
                    isset($labels[$name]) ? $labels[$name] : null,
                    isset($backendTransaction) ? $backendTransaction : null
                );
            }
        }
    }

    /**
     * Set transaction detail record
     *
     * @param string                                  $name               Code
     * @param string                                  $value              Value
     * @param string                                  $label              Label OPTIONAL
     * @param \XLite\Model\Payment\BackendTransaction $backendTransaction Backend transaction object OPTIONAL
     *
     * @return void
     */
    protected function setDetail($name, $value, $label = null, $backendTransaction = null)
    {
        $transaction = isset($backendTransaction) ? $backendTransaction : $this->transaction;

        $transaction->setDataCell($name, $value, $label);
    }

    /**
     * Get input data labels list
     *
     * @return array
     */
    protected function getInputDataLabels()
    {
        return array();
    }

    /**
     * Get input data access levels list
     *
     * @return array
     */
    protected function getInputDataAccessLevels()
    {
        return array();
    }

    /**
     * Get allowed currencies
     *
     * @param \XLite\Model\Payment\Method $method Payment method
     *
     * @return array
     */
    protected function getAllowedCurrencies(\XLite\Model\Payment\Method $method)
    {
        return array();
    }

    // {{{ Method helpers

    /**
     * Get payment method admin zone icon URL
     *
     * @param \XLite\Model\Payment\Method $method Payment method
     *
     * @return string
     */
    public function getAdminIconURL(\XLite\Model\Payment\Method $method)
    {
        return null;
    }

    /**
     * Check - payment method has enabled test mode or not
     *
     * @param \XLite\Model\Payment\Method $method Payment method
     *
     * @return boolean
     */
    public function isTestMode(\XLite\Model\Payment\Method $method)
    {
        return \XLite\View\FormField\Select\TestLiveMode::TEST === $method->getSetting('mode');
    }

    /**
     * Get warning note by payment method
     *
     * @param \XLite\Model\Payment\Method $method Payment method
     *
     * @return string
     */
    public function getWarningNote(\XLite\Model\Payment\Method $method)
    {
        return null;
    }

    /**
     * Check - payment method is forced enabled or not
     *
     * @param \XLite\Model\Payment\Method $method Payment method
     *
     * @return boolean
     */
    public function isForcedEnabled(\XLite\Model\Payment\Method $method)
    {
        return false;
    }

    /**
     * Get note with explanation why payment method was forcibly enabled
     *
     * @param \XLite\Model\Payment\Method $method Payment method
     *
     * @return string
     */
    public function getForcedEnabledNote(\XLite\Model\Payment\Method $method)
    {
        return null;
    }

    /**
     * Check - payment method can be enabled or not
     *
     * @param \XLite\Model\Payment\Method $method Payment method
     *
     * @return boolean
     */
    public function canEnable(\XLite\Model\Payment\Method $method)
    {
        return true;
    }

    /**
     * Get note with explanation why payment method can not be enabled
     *
     * @param \XLite\Model\Payment\Method $method Payment method
     *
     * @return string
     */
    public function getForbidEnableNote(\XLite\Model\Payment\Method $method)
    {
        return null;
    }

    /**
     * Get links
     *
     * @param \XLite\Model\Payment\Method $method Payment method
     *
     * @return array
     */
    public function getLinks(\XLite\Model\Payment\Method $method)
    {
        return array();
    }

    /**
     * Get URL of referral page
     *
     * @return string
     */
    public function getReferralPageURL(\XLite\Model\Payment\Method $method)
    {
        return null;
    }

    /**
     * Return true if payment method settings form should use default submit button.
     * Otherwise, settings widget must define its own button
     * 
     * @return boolean
     */
    public function useDefaultSettingsFormButton()
    {
        return true;
    }

    /**
     * Do something when payment method is enabled 
     * 
     * @return void
     */
    public function enableMethod(\XLite\Model\Payment\Method $method)
    {
        return null;
    }

    /**
     * Return true if processor is for COD payment method
     *
     * @return boolean
     */
    public function isCOD()
    {
        return false;
    }

    // }}}
}
