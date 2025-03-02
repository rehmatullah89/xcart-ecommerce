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

namespace XLite\Module\CDev\XPaymentsConnector\Core;

/**
 * XPayments client
 */
class XPaymentsClient extends \XLite\Base\Singleton
{
    const REQ_CURL    = 1;
    const REQ_OPENSSL = 2;
    const REQ_DOM     = 4;

    const XPC_SYSERR_CARTID      = 1;
    const XPC_SYSERR_URL         = 2;
    const XPC_SYSERR_PUBKEY      = 4;
    const XPC_SYSERR_PRIVKEY     = 8;
    const XPC_SYSERR_PRIVKEYPASS = 16;

    const XPC_WPP_DP   = 'PayPal WPP Direct Payment';
    const XPC_WPPPE_DP = 'PayPal WPPPE Direct Payment';

    const XPC_API_EXPIRED = 506;
    const XPC_API_VERSION = '1.1';

    /**
     * Salt block length
     */
    const XPC_SALT_LENGTH = 32;

    /**
     * Salt generator start character code
     */
    const XPC_SALT_BEGIN = 33;

    /**
     * Salt generator end character code
     */
    const XPC_SALT_END = 255;

    /**
     * Encryption check length
     */
    const XPC_CHUNK_LENGTH = 128;

    /**
     * Root-level tag for all XML messages
     */
    const XPC_TAG_ROOT = 'data';

    /**
     * Value of the 'type' attribute for list items in XML
     */
    const XPC_TYPE_CELL = 'cell';

    const XPC_MODULE_INFO = 'payment_module';

    const DEFAULT_CHARSET = 'UTF-8';

    /**
     * Paypal dp solutions
     *
     * @var array
     */
    protected $xpcPaypalDpSolutions = array(
        'pro' => self::XPC_WPP_DP,
        'uk'  => self::XPC_WPPPE_DP,
    );

    /**
     * Errors
     *
     * @var array
     */
    protected $xpcErrors = array(
        self::XPC_API_EXPIRED => 'To update your X-Payments connector module download the file xpc_api.php from the File Area of your Qualiteam account and copy it to the <xcart_dir>/modules/XPayments_Connector/ directory, replacing the existing file.',
    );

    /**
     * Check - module is configured or not
     *
     * @return boolean
     */
    public function isModuleConfigured()
    {
        return 0 === $this->getModuleSystemErrors();
    }

    /**
     * Make test request to X-Payments
     *
     * @return boolean
     */
    public function requestTest()
    {
        $hashCode = strval(rand(0, 1000000));

        // Make test request
        list($status, $response) = $this->getApiRequest(
            'connect',
            'test',
            array('testCode' => $hashCode),
            $this->getRequestTestSchema()
        );

        // Compare MD5 hashes
        if ($status) {
            $status = md5($hashCode) === $response['hashCode'];
            if (!$status) {
                $this->getApiError('Test connection data is not valid');
            }
        }

        return array(
            'status'   => $status,
            'response' => $response,
        );
    }

    /**
     * Get payment info
     *
     * @param integer $txnId   Transaction id
     * @param boolean $refresh Refresh OPTIONAL
     *
     * @return array Operation status & payment data array
     */
    public function requestPaymentInfo($txnId, $refresh = false)
    {
        $data = array(
            'txnId'   => $txnId,
            'refresh' => $refresh ? 1 : 0
        );

        list($status, $response) = $this->getApiRequest('payment', 'get_info', $data);

        if ($status) {
            if (!is_array($response) || !isset($response['status'])) {
                $this->getApiError('GetInfo request. Server response has not status');
                $status = false;

            } elseif (!isset($response['message'])) {
                $this->getApiError('GetInfo request. Server response has not message');
                $status = false;

            } elseif (!isset($response['transactionInProgress'])) {
                $this->getApiError('GetInfo request. Server response has not transaction progress status');
                $status = false;

            } elseif (!isset($response['isFraudStatus'])) {
                $this->getApiError('GetInfo request. Server response has not fraud filter status');
                $status = false;

            } elseif (!isset($response['currency']) || strlen($response['currency']) != 3) {
                $this->getApiError(
                    'GetInfo request. Server response has not currency code or currency code has wrong format'
                );
                $status = false;

            } elseif (!isset($response['amount'])) {
                $this->getApiError('GetInfo request. Server response has not payment amount');
                $status = false;

            } elseif (!isset($response['capturedAmount'])) {
                $this->getApiError('GetInfo request. Server response has not captured amount');
                $status = false;

            } elseif (!isset($response['capturedAmountAvail'])) {
                $this->getApiError('GetInfo request. Server response has not available for capturing amount');
                $status = false;

            } elseif (!isset($response['refundedAmount'])) {
                $this->getApiError('GetInfo request. Server response has not refunded amount');
                $status = false;

            } elseif (!isset($response['refundedAmountAvail'])) {
                $this->getApiError('GetInfo request. Server response has not available for refunding amount');
                $status = false;

            } elseif (!isset($response['voidedAmount'])) {
                $this->getApiError('GetInfo request. Server response has not voided amount');
                $status = false;

            } elseif (!isset($response['voidedAmountAvail'])) {
                $this->getApiError('GetInfo request. Server response has not available for cancelling amount');
                $status = false;

            }
        }

        return array($status, $response);
    }

    /**
     * Get list of available payment configurations from X-Payments
     *
     * @return array
     */
    public function requestPaymentMethods()
    {
        list($status, $response) = $this->getApiRequest(
            'payment_confs',
            'get',
            array(),
            $this->getRequestPaymentMethodsSchema()
        );

        if ($status) {
            $status = (!isset($response['payment_module']) || !is_array($response['payment_module']))
                ? array()
                : $response['payment_module'];
        }

        return $status;
    }

    /**
     * Get recharge request via saved credit card 
     *
     * @param string                           $txnId       Transaction ID
     * @param \XLite\Model\Payment\Transaction $transaction Payment transaction
     * @param string                           $description Description OPTIONAL
     *
     * @return array
     */
    public function requestPaymentRecharge($txnId, \XLite\Model\Payment\Transaction $transaction, $description = null)
    {
        $xpcBackReference = $this->generateXpcBackReference();

        // Save back refernece to transaction from  X-Payments
        $transaction->setDataCell('xpcBackReference', $xpcBackReference, 'X-Payments back reference', 'C');
        \XLite\Core\Database::getEM()->flush();

        $callbackUrl = \XLite::getInstance()->getShopUrl(
            \XLite\Core\Converter::buildUrl(
                'callback',
                'callback',
                array('xpcBackReference' => $xpcBackReference)
            )
        );

        return $this->getApiRequest(
            'payment',
            'recharge',
            array(
                'callbackUrl' => $callbackUrl,
                'txnId'       => $txnId,
                'amount'      => $transaction->getValue(),
                'description' => !isset($description) ? 'New payment for tranaction #' . $txnId : $description 
            )
        );
    }

    /**
     * Clear init payment form data from session
     *
     * @param integer $paymentId Payment id OPTIONAL
     *
     * @return void
     */
    public function clearInitDataFromSession($paymentId = null)
    {
        if (
            $paymentId
            && \XLite\Core\Session::getInstance()->xpc_form_data
            && \XLite\Core\Session::getInstance()->xpc_form_data[$paymentId]
        ) {

            unset(\XLite\Core\Session::getInstance()->xpc_form_data[$paymentId]);

        } else {

            unset(\XLite\Core\Session::getInstance()->xpc_form_data);

        }

        $msg = 'SESSION DATA CLEARED FOR: ' . var_export($paymentId, true) . PHP_EOL
            . 'SESSION: ' . var_export(\XLite\Core\Session::getInstance()->xpc_form_data, true) . PHP_EOL;

        \XLite\Logger::getInstance()->logCustom('xp-connector', $msg);
    }

    /**
     * Save init payment form data to session
     *
     * @param \XLite\Model\Payment\Transaction $transaction Transaction OPTIONAL
     * @param array                            $data        Form data OPTIONAL
     *
     * @return void 
     */
    public function saveInitDataToSession(\XLite\Model\Payment\Transaction $transaction = null, $data = null)
    {
        if ($transaction && $this->isInitDataValid($data)) {
            $formData = \XLite\Core\Session::getInstance()->xpc_form_data;

            if (!is_array($formData)) {
                $formData = array();
            }

            $data['savedCart'] = $this->prepareCart($transaction->getOrder());

            $formData[$transaction->getPaymentMethod()->getMethodId()] = $data;

        } else {
            $formData = null;
        }

        \XLite\Core\Session::getInstance()->xpc_form_data = $formData;
    }

    /**
     * Get redirect form fields list
     *
     * @param \XLite\Model\Payment\Transaction $transaction Transaction
     *
     * @return array
     */
    public function getFormFields(\XLite\Model\Payment\Transaction $transaction)
    {
        if (!$transaction) {
            $this->setXpcError($transaction, 'Internal error.');
        }

        // 1. Try to get data from session
        $data = $this->getInitDataFromSession($transaction);
        $msg = 'FROM SESSION' . PHP_EOL;

        if (!$data) {

            // 2. Try to get data from X-Payments
            $data = $this->getInitDataFromXpayments($transaction);
            $msg = 'FROM XPAYMENTS' . PHP_EOL;
        }

        if ($data) {

            // Save X-Payments transaction id in transaction data
            $transaction->setDataCell('xpc_txnid', $data['txnId'], 'X-Payments transaction id', 'C');

            // Save back refernece to transaction from  X-Payments 
            $transaction->setDataCell('xpcBackReference', $data['xpcBackReference'], 'X-Payments back reference', 'C');

            $msg .= 'TRANSACTION ID: ' . var_export($transaction->getTransactionId(), true) . PHP_EOL
                . 'XP TXNID: ' . var_export($data['txnId'], true) . PHP_EOL
                . 'SESSION: ' . var_export(\XLite\Core\Session::getInstance()->xpc_form_data, true) . PHP_EOL;

            \XLite\Logger::getInstance()->logCustom('xp-connector', $msg);

            try {
                \XLite\Core\Database::getEM()->flush();

            } catch (Exception $e) {
                $this->setXpcError($transaction, 'Internal error.');
            }

            $data = $data['fields'];

        } else {

            $data = array();

        }

        return $data;
    }

    /**
     * Make X-Payments API request
     *
     * @param string $target Request target
     * @param string $action Request action
     * @param array  $data   Request data OPTIONAL
     * @param string $schema Request schema OPTIONAL
     *
     * @return array
     */
    public function getApiRequest($target, $action, array $data = array(), $schema = '')
    {
        $result = null;

        $config = \XLite\Core\Config::getInstance()->CDev->XPaymentsConnector;

        // Check requirements
        if (!$this->isModuleConfigured()) {
            $result = $this->getApiError('Module is not configured');

        } elseif (0 !== $this->checkRequirements()) {
            $result = $this->getApiError('Check module requirements is failed');

        } else {

            $data['target'] = $target;
            $data['action'] = $action;

            // Send API version
            $data['api_version'] = static::XPC_API_VERSION;

            // Convert array to XML
            $xml = $this->convertHashToXml($data);

            if (!$xml) {
                $result = $this->getApiError('Data is not valid');

            } else {

                // Encrypt
                $xml = $this->encryptXml($xml);

                if (!$xml) {
                    $result = $this->getApiError('Data is not encrypted');

                } else {

                    $result = $this->sendAPIRequest($config, $xml);
                }
            }
        }

        return $result;
    }

    /**
     * Decrypt (RSA)
     *
     * @param string $data Encrypted data
     *
     * @return array
     */
    public function decryptXml($data)
    {
        $result = null;
        $config = \XLite\Core\Config::getInstance()->CDev->XPaymentsConnector;

        // Decrypt
        $res = openssl_get_privatekey($config->xpc_private_key, $config->xpc_private_key_password);
        if (!$res) {
            $result = array(false, 'Private key is not initialized');

        } else {

            $data = substr($data, 3);

            $data = explode("\n", $data);
            $data = array_map('base64_decode', $data);
            foreach ($data as $k => $s) {
                if (!openssl_private_decrypt($s, $newsource, $res)) {
                    $result = array(false, 'Can not decrypt chunk');
                    break;
                }

                $data[$k] = $newsource;
            }

            if (!$result) {
                openssl_free_key($res);

                // Postprocess
                $result = $this->decryptXmlPostprocess(implode('', $data));
            }
        }

        return $result;
    }

    /**
     * Convert XML to hash array
     *
     * @param string $xml XML string
     *
     * @return array|string
     */
    public function convertXmlToHash($xml)
    {
        $data = array();

        while (
            !empty($xml)
            && preg_match('/<([\w\d]+)(?:\s*type=["\'](\w+)["\']\s*)?' . '>(.*)<\/\1>/Us', $xml, $matches)
        ) {

            // Sublevel tags or tag value
            if (static::XPC_TYPE_CELL === $matches[2]) {
                $data[$matches[1]][] = $this->convertXmlToHash($matches[3]);

            } else {
                $data[$matches[1]] = $this->convertXmlToHash($matches[3]);
            }

            // Exclude parsed part from XML
            $xml = str_replace($matches[0], '', $xml);
        }

        return empty($data) ? $xml : $data;
    }

    /**
     * Prepare shopping cart data
     *
     * @param \XLite\Model\Order $cart      X-Cart shopping cart
     * @param integer            $refId     Transaction ID OPTIONAL
     * @param boolean            $forceAuth Force enable AUTH mode OPTIONAL
     *
     * @return array
     */
    public function prepareCart(\XLite\Model\Order $cart, $refId = null, $forceAuth = false)
    {
        $config = \XLite\Core\Config::getInstance()->CDev->XPaymentsConnector;

        $profile = $cart->getProfile();

        $result = array(
            'login'                => $profile->getLogin() . ' (User ID #' . $profile->getProfileId() . ')',
            'billingAddress'       => array(),
            'shippingAddress'      => array(),
            'items'                => array(),
            'currency'             => $cart->getCurrency()->getCode(),
            'shippingCost'         => 0.00,
            'taxCost'              => 0.00,
            'discount'             => 0.00,
            'totalCost'            => 0.00,
            'description'          => 'Order(s) #' . $cart->getOrderId(),
            'merchantEmail'        => \XLite\Core\Config::getInstance()->Company->orders_department,
            'forceTransactionType' => $forceAuth ? 'A' : '',
        );

        $namePrefixes = array(
            'billing',
            'shipping',
        );

        $addressFields = array(
            'firstname' => '',
            'lastname'  => '',
            'address'   => '',
            'city'      => '',
            'state'     => 'N/A',
            'country'   => '',
            'zipcode'   => '',
            'phone'     => '',
            'fax'       => '',
            'company'   => '',
        );

        $repo = \XLite\Core\Database::getRepo('\XLite\Model\AddressField');

        // Prepare shipping and billing address
        foreach ($namePrefixes as $type) {

            $addressIndex = $type . 'Address';

            foreach ($addressFields as $field => $defValue) {
                $method = 'address' == $field ? 'street' : $field;
                $address = $profile->$addressIndex;
                if (
                    $address
                    && ($repo->findOneBy(array('serviceName' => $method)) || method_exists($address, 'get' . $method))
                    && $address->$method
                ) {
                    $result[$addressIndex][$field] = is_object($profile->$addressIndex->$method)
                        ? $profile->$addressIndex->$method->getCode()
                        : $profile->$addressIndex->$method;

                } else {
                    $result[$addressIndex][$field] = $defValue;
                }
            }

            $result[$addressIndex]['email'] = $profile->getLogin();
        }

        // Set items
        if ($cart->getItems()) {

            foreach ($cart->getItems() as $item) {
                $result['items'][] = array(
                    'sku'      => $item->getSku(),
                    'name'     => $item->getName(),
                    'price'    => $this->roundCurrency($item->getItemNetPrice()),
                    'quantity' => $item->getAmount(),
                );
            }

        }

        // Set costs
        $result['shippingCost'] = $this->roundCurrency(
            $cart->getSurchargesSubtotal(\XLite\Model\Base\Surcharge::TYPE_SHIPPING, false)
        );
        $result['taxCost'] = $this->roundCurrency(
            $cart->getSurchargesSubtotal(\XLite\Model\Base\Surcharge::TYPE_TAX, false)
        );
        $result['totalCost'] = $this->roundCurrency($cart->getTotal());
        $result['discount'] = $this->roundCurrency(
            $cart->getSurchargesSubtotal(\XLite\Model\Base\Surcharge::TYPE_DISCOUNT, false)
        );

        return $result;
    }

    /**
     * Convert hash array to XML
     *
     * @param array   $data  Hash array
     * @param integer $level Current recursion level OPTIONAL
     *
     * @return string
     */
    public function convertHashToXml(array $data, $level = 0)
    {
        $xml = '';

        foreach ($data as $name => $value) {

            if ($this->isAnonymousArray($value)) {
                foreach ($value as $item) {
                    $xml .= $this->writeXmlTag($item, $name, $level, static::XPC_TYPE_CELL);
                }

            } else {
                $xml .= $this->writeXmlTag($value, $name, $level);
            }

        }

        return $xml;
    }

    /**
     * Encrypt data (RSA)
     *
     * @param string $data Request data
     *
     * @return string
     */
    public function encryptXml($data)
    {
        $result = false;

        $config = \XLite\Core\Config::getInstance()->CDev->XPaymentsConnector;

        // Preprocess
        srand(time());
        $salt = '';
        for ($i = 0; static::XPC_SALT_LENGTH > $i; $i++) {
            $salt .= chr(rand(static::XPC_SALT_BEGIN, static::XPC_SALT_END));
        }

        $lenSalt = strlen($salt);

        $crcType = 'MD5';
        $crc = md5($data, true);

        $crc = str_repeat(' ', 8 - strlen($crcType)) . $crcType . $crc;
        $lenCRC = strlen($crc);

        $lenData = strlen($data);

        $data = str_repeat('0', 12 - strlen((string)$lenSalt)) . $lenSalt . $salt
            . str_repeat('0', 12 - strlen((string)$lenCRC)) . $lenCRC . $crc
            . str_repeat('0', 12 - strlen((string)$lenData)) . $lenData . $data;

        // Encrypt
        $key = openssl_pkey_get_public($config->xpc_public_key);
        if ($key) {
            $data = str_split($data, static::XPC_CHUNK_LENGTH);
            $crypttext = null;
            $error = false;
            foreach ($data as $k => $chunk) {
                if (!openssl_public_encrypt($chunk, $crypttext, $key)) {
                    $error = true;
                    break;
                }

                $data[$k] = $crypttext;
            }

            // Postprocess
            if (!$error) {
                $data = array_map('base64_encode', $data);

                $result = 'API' . implode("\n", $data);
            }
        }

        return $result;
    }

    /**
     * Send API request 
     * 
     * @param object $config Config
     * @param string $xml    XML
     *  
     * @return array
     */
    protected function sendAPIRequest($config, $xml)
    {
        // HTTPS request
        $post = array(
            'cart_id' => $config->xpc_shopping_cart_id,
            'request' => $xml,
        );

        $this->getCurlHeadersCollector(false);
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $config->xpc_xpayments_url . '/api.php');
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 15000);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
        curl_setopt($ch, CURLOPT_HEADERFUNCTION, array($this, 'getCurlHeadersCollector'));

        curl_setopt($ch, CURLOPT_SSLVERSION, 3);

        if (!empty(\XLite\Core\Config::getInstance()->Security->https_proxy)) {
            // uncomment this line if you need proxy tunnel
            // curl_setopt ($ch, CURLOPT_HTTPPROXYTUNNEL, true);
            curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_HTTP);
            curl_setopt($ch, CURLOPT_PROXY, \XLite\Core\Config::getInstance()->Security->https_proxy);
        }

        // insecure key is supported by curl since version 7.10
        $version = curl_version();

        if (is_array($version)) {
            $version = 'libcurl/' . $version['version'];
        }

        if (preg_match('/libcurl\/([^ $]+)/Ss', $version, $m)) {
            $parts = explode('.', $m[1]);
            if (7 < $parts[0] || (7 == $parts[0] && 10 <= $parts[1])) {
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 1);
            }
        }

        $body = curl_exec($ch);
        $errno = curl_errno($ch);
        $error = curl_error($ch);

        $headers = $this->getCurlHeadersCollector(true);

        curl_close($ch);

        // Check raw data
        if (substr($body, 0, 3) !== 'API') {

            $this->getApiError(
                'Response is not valid.' . "\n"
                . 'Response headers: ' . var_export($headers, true) . "\n"
                . 'Response: ' . $body . "\n"
            );

            $result = array(false, 'Response is not valid.<br />Check logs.');

        } else {

            // Decrypt
            list($responseStatus, $response) = $this->decryptXml($body);

            if (!$responseStatus) {
                $result = $this->getApiError('Response is not decrypted (Error: ' . $response . ')');

            } elseif (!empty($schema) && !$this->validateXmlAgainstSchema($response, $schema, $error)) {

                // Validate XML
                $result = $this->getApiError('XML in response has a wrong format. Additional info: "' . $error . '"');

            } else {

                // Convert XML to array
                $response = $this->convertXmlToHash($response);

                if (!is_array($response)) {
                    $result = $this->getApiError('Unable to convert response into XML');

                } elseif (!isset($response[static::XPC_TAG_ROOT])) {

                    // The 'Data' tag must be set in response
                    $result = $this->getApiError('Response does not contain any data');

                } else {
                    $result = $this->postprocessAPIRequest($response[static::XPC_TAG_ROOT]);
                }
            }
        }

        return $result;
    }

    /**
     * Postprocess API request 
     * 
     * @param array $response Response
     *  
     * @return array
     */
    protected function postprocessAPIRequest(array $response)
    {
        $error = $this->processApiError($response);

        return $error
            ? array(
                null,
                array(
                    'status'        => 0,
                    'message'       => $error,
                    'error_message' => '' == $response['is_error_message'] ? '' : $response['error_message'],
                )
            )
            : array(true, $response);
    }

    /**
     * Decrypt XML postprocess 
     * 
     * @param string $data Decrypted data_
     *  
     * @return array
     */
    protected function decryptXmlPostprocess($data)
    {
        $lenSalt = substr($data, 0, 12);
        if (!preg_match('/^\d+$/Ss', $lenSalt)) {
            $result = array(false, 'Salt length prefix has wrong format');

        } else {
            $lenSalt = intval($lenSalt);
            $data = substr($data, 12 + intval($lenSalt));

            $lenCRC = substr($data, 0, 12);
            if (!preg_match('/^\d+$/Ss', $lenCRC) || 9 > $lenCRC) {
                $result = array(false, 'CRC length prefix has wrong format');

            } else {

                $lenCRC = intval($lenCRC);
                $crcType = trim(substr($data, 12, 8));
                if ('MD5' !== $crcType) {
                    $result = array(false, 'CRC hash is not MD5');

                } else {
                    $crc = substr($data, 20, $lenCRC - 8);

                    $data = substr($data, 12 + $lenCRC);

                    $lenData = substr($data, 0, 12);
                    if (!preg_match('/^\d+$/Ss', $lenData)) {
                        $result = array(false, 'Data block length prefix has wrong format');

                    } else {

                        $data = substr($data, 12, intval($lenData));

                        $currentCRC = md5($data, true);
                        $result = $currentCRC !== $crc
                            ? array(false, 'Original CRC and calculated CRC is not equal')
                            : array(true, $data);
                    }
                }
            }
        }

        return $result;
    }

    /**
     * Error codes of messages which should be shown to admin only
     *
     * @return array
     */
    protected function getAdminErrorCodes()
    {
        return array(
            '502', // Payment configuration is not initialized
            '503', // Unable to create a new payment
            '504', // Specified currency is not allowed
            '505', // Payment interface template files have been modified
            '506', // API Version mismatch
        );
    }

    /**
     * Detect access level of API error. Should it be shown to customer or not
     *
     * @return string
     */
    protected function detectAccessLevel($code)
    {
        return in_array($code, $this->getAdminErrorCodes())
            ? 'A'
            : 'C';
    }

    /**
     * Set X-Payments API error to:
     *  - Logs
     *  - Transaction data
     *  - Controller
     *
     * @param \XLite\Model\Payment\Transaction $transaction Transaction
     * @param mixed                            $response    Response
     *
     * @return void
     */
    protected function setXpcError(\XLite\Model\Payment\Transaction $transaction, $response)
    {
        \XLite\Logger::getInstance()->logCustom(
            'xp-connector',
            'X-Paymets payment initialization failed: ' . var_export($response, true)
        );

        $accessLevel = 'C';

        $message = $errorMessage = isset($response['error_message'])
            ? $response['error_message']
            : isset($response['message'])
                ? $response['message']
                : 'Internal error.';

        if (preg_match('/X-Payments error \(code: (\d+)\)/', $message, $m)) {
            $accessLevel = $this->detectAccessLevel($m[1]);
        }

        if ('A' == $accessLevel) {
            $transaction->setDataCell('status', $errorMessage, 'X-Payments detailed error', 'A');

        } else {
            $message = $errorMessage;
        }

        $transaction->setDataCell('status', $message, 'X-Payments error', 'C');

        $iframe = \XLite::getController()->getIframe();

        $iframe->setError($message);

        if (\XLite::getController()->isCheckoutReady()) {
            if ('A' == $accessLevel) {
                $iframe->setType(\XLite\Module\CDev\XPaymentsConnector\Core\Iframe::IFRAME_CHANGE_METHOD);

            } else {
                $iframe->setType(\XLite\Module\CDev\XPaymentsConnector\Core\Iframe::IFRAME_ALERT);
            }

        } else {
            $iframe->setType(\XLite\Module\CDev\XPaymentsConnector\Core\Iframe::IFRAME_DO_NOTHING);
        }

        $this->clearInitDataFromSession();

        $iframe->finalize();
    }


    /**
     * Check if data is valid for init payment form
     * It should contain form fields and transaction ID
     *
     * @param array $data Data
     *
     * @return boolean
     */
    protected function isInitDataValid($data)
    {
        return !empty($data)
            && is_array($data)
            && !empty($data['txnId'])
            && !empty($data['xpcBackReference'])
            && is_array($data['fields'])
            && !empty($data['fields']);
    }

    /**
     * Get init payment form data from session 
     *
     * @param \XLite\Model\Payment\Transaction $transaction Transaction
     *
     * @return array || bool
     */
    protected function getInitDataFromSession(\XLite\Model\Payment\Transaction $transaction)
    {
        $paymentId = $transaction->getPaymentMethod()->getMethodId();

        $formData = \XLite\Core\Session::getInstance()->xpc_form_data;

        $data = ($formData && $formData[$paymentId] && $this->isInitDataValid($formData[$paymentId]))
            ? $formData[$paymentId]
            : false;

        if (
            $data
            && !empty($data['savedCart'])
            && is_array($data['savedCart'])
            && $this->isCartFingerprintDifferent($data['savedCart'], $this->prepareCart(\XLite\Model\Cart::getInstance()))
        ) {
            $this->clearInitDataFromSession($paymentId);
            $data = false;
        }

        return $data;
    }

    /**
     * Get init payment form data from XPayments
     *
     * @param \XLite\Model\Payment\Transaction $transaction Transaction
     *
     * @return array 
     */
    protected function getInitDataFromXpayments(\XLite\Model\Payment\Transaction $transaction)
    {
        list($status, $response) = $this->requestPaymentInit(
            $transaction->getPaymentMethod(),
            \XLite\Model\Cart::getInstance()
        );

        if (
            $status
            && $this->isInitDataValid($response)
        ) {

            $data = array(
                'xpcBackReference' => $response['xpcBackReference'],
                'txnId'            => $response['txnId'],
                'fields'           => $response['fields'],
            );

            $this->saveInitDataToSession($transaction, $data);

        } else {

            $data = null;
            $this->setXpcError($transaction, $response);

        }

        return $data;
    }

    /**
     * Back reference from X-Payments to X-Cart 5.
     * We cannot use Order ID, Order number, Transaction ID etc,
     * since these values can change
     *
     * @return string
     */
    protected function generateXpcBackReference()
    {
        return md5(uniqid('', true) . time());
    }

    /**
     * Check - cart fingerprint is different or not
     * 
     * @param array $old Old saved cart 
     * @param array $new Current cart
     *  
     * @return boolean
     */
    protected function isCartFingerprintDifferent(array $old, array $new)
    {
        return $old != $new;
    }

    /**
     * Send request to X-Payments to initialize new payment
     *
     * @param \XLite\Model\Payment\Method $paymentMethod Payment method
     * @param \XLite\Model\Cart           $cart          Shopping cart info
     * @param boolean                     $forceAuth     Force enable AUTH mode OPTIONAL
     *
     * @return array
     */
    protected function requestPaymentInit(\XLite\Model\Payment\Method $paymentMethod, \XLite\Model\Cart $cart, $forceAuth = false)
    {
        $config = \XLite\Core\Config::getInstance()->CDev->XPaymentsConnector;

        // Prepare cart
        $preparedCart = $this->prepareCart($cart, null, $forceAuth);

        if (!$cart || !$preparedCart) {
            $result = $this->getApiError('Unable to prepare cart data');

        } else {

            $xpcBackReference = $this->generateXpcBackReference();

            $returnUrl = \XLite::getInstance()->getShopUrl(
                \XLite\Core\Converter::buildUrl(
                    'payment_return',
                    'return',
                    array('xpcBackReference' => $xpcBackReference)
                )
            );
            $callbackUrl = \XLite::getInstance()->getShopUrl(
                \XLite\Core\Converter::buildUrl(
                    'callback',
                    'callback',
                    array('xpcBackReference' => $xpcBackReference)
                )
            );

            // Data to send to X-Payments
            $data = array(
                'confId'      => intval($paymentMethod->getSetting('id')),
                'refId'       => $xpcBackReference,
                'cart'        => $preparedCart,
                'language'    => 'en',
                'returnUrl'   => $returnUrl,
                'callbackUrl' => $callbackUrl,
            );

            list($status, $response) = $this->getApiRequest(
                'payment',
                'init',
                $data,
                $this->getRequestInitSchema()
            );

            // The main entry in the response is the 'token'
            if ($status && (!isset($response['token']) || !is_string($response['token']))) {
                $this->getApiError('Transaction token is not found or has a wrong type');
                $status = false;
            }

            if ($status) {

                // Use the default URL if X-Payments did not return one
                if (substr($config->xpc_xpayments_url, -1) == '/') {
                    $config->xpc_xpayments_url = substr($config->xpc_xpayments_url, 0, -1);
                }

                // Set fields for the "Redirect to X-Payments" form
                $response = array(
                    'xpcBackReference' => $xpcBackReference,
                    'txnId'            => $response['txnId'],
                    'module_name'      => $paymentMethod->getSetting('moduleName'),
                    'url'              => $config->xpc_xpayments_url . '/payment.php',
                    'fields'           => array(
                        'target' => 'main',
                        'action' => 'start',
                        'token'  => $response['token'],
                    ),
                );

            } else {

                if (isset($response['error_message'])) {
                    $detailedErrorMessage = $response['error_message'];

                } elseif (is_string($response)) {
                    $detailedErrorMessage = $response;

                } else {
                    $detailedErrorMessage = 'Unknown';
                }

                $response = array_merge(
                    $response,
                    array('detailed_error_message' => $detailedErrorMessage)
                );

            }

            $result = array($status, $response);
        }

        return $result;
    }

    /**
     * Get X-Payments Connector configuration errors
     *
     * @return integer
     */
    protected function getModuleSystemErrors()
    {
        $config = \XLite\Core\Config::getInstance()->CDev->XPaymentsConnector;

        $failed = 0;

        // Check shopping cart id
        if (
            empty($config->xpc_shopping_cart_id)
            || !preg_match('/^[\da-f]{32}$/Ss', $config->xpc_shopping_cart_id)
        ) {
            $failed |= static::XPC_SYSERR_CARTID;
        }

        // Check URL
        if (empty($config->xpc_xpayments_url)) {
            $failed |= static::XPC_SYSERR_URL;
        }

        $parsedURL = @parse_url($config->xpc_xpayments_url);

        if (
            !$parsedURL
            || !isset($parsedURL['scheme'])
            || !in_array($parsedURL['scheme'], array( 'https', 'http'))
        ) {
            $failed |= static::XPC_SYSERR_URL;
        }

        // Check public key
        if (empty($config->xpc_public_key)) {
            $failed |= static::XPC_SYSERR_PUBKEY;
        }

        // Check private key
        if (empty($config->xpc_private_key)) {
            $failed |= static::XPC_SYSERR_PRIVKEY;
        }

        // Check private key password
        if (empty($config->xpc_private_key_password)) {
            $failed |= static::XPC_SYSERR_PRIVKEYPASS;
        }

        return $failed;
    }

    /**
     * Check module requirements
     *
     * @return integer
     */
    protected function checkRequirements()
    {
        $code = 0;

        if (!function_exists('curl_init')) {
            $code = $code | static::REQ_CURL;
        }

        if (
            !function_exists('openssl_pkey_get_public') || !function_exists('openssl_public_encrypt')
            || !function_exists('openssl_get_privatekey') || !function_exists('openssl_private_decrypt')
            || !function_exists('openssl_free_key')
        ) {
            $code = $code | static::REQ_OPENSSL;
        }

        if (!class_exists('DOMDocument')) {
            $code = $code | static::REQ_DOM;
        }

        return $code;
    }

    /**
     * Format and log API errors
     *
     * @param string $msg Error message
     *
     * @return array
     */
    protected function getApiError($msg)
    {
        \XLite\Logger::getInstance()->logCustom('xp-connector', $msg);

        return array(false, $msg);
    }

    /**
     * Check if passed variable is an array with numeric keys
     *
     * @param array $data Data to check
     *
     * @return boolean
     */
    protected function isAnonymousArray($data)
    {
        return is_array($data)
            && (1 > count(preg_grep('/^\d+$/', array_keys($data), PREG_GREP_INVERT)));
    }

    /**
     * Write XML tag for current level
     *
     * @param mixed   $data  Node content
     * @param string  $name  Node name
     * @param integer $level Current recursion level OPTIONAL
     * @param string  $type  Value for 'type' attribute OPTIONAL
     *
     * @return string
     */
    protected function writeXmlTag($data, $name, $level = 0, $type = '')
    {
        $xml = '';
        $indent = str_repeat('  ', $level);

        // Open tag
        $xml .= $indent . '<' . $name . (empty($type) ? '' : ' type="' . $type . '"') . '>';

        // Sublevel tags or tag value
        $xml .= is_array($data)
            ? "\n" . $this->convertHashToXml($data, $level + 1) . $indent
            : $this->convertLocalToUtf8($data);

        // Close tag
        $xml .= '</' . $name . '>' . "\n";

        return $xml;
    }

    /**
     * Convert local string ti UTF-8
     *
     * @param string $string  Request data
     * @param string $charset Charset OPTIONAL
     *
     * @return string
     */
    protected function convertLocalToUtf8($string, $charset = null)
    {
        if (is_null($charset)) {
            $charset = static::DEFAULT_CHARSET;
        }

        $charset = strtolower(trim($charset));

        if (function_exists('utf8_encode') && 'iso-8859-1' == $charset) {
            $string = utf8_encode($string);

        } elseif (function_exists('iconv')) {
            $string = iconv($charset, 'utf-8', $string);

        } else {

            $len = strlen($string);
            $data = '';
            for ($i = 0; $i < $len; $i++) {
                $c = ord(substr($string, $i, 1));
                if (!(22 > $c || 127 < $c)) {
                    $data .= substr($string, $i, 1);
                }
            }

            $string = $data;
        }

        return $string;
    }

    /**
     * CURL headers collector callback
     *
     * @return mixed
     */
    protected function getCurlHeadersCollector()
    {
        static $headers = '';

        $args = func_get_args();

        if (count($args) == 1) {

            $return = '';

            if ($args[0] == true) {
                $return = $headers;
            }

            $headers = '';

        } else {

            if (trim($args[1]) != '') {
                $headers .= $args[1];
            }
            $return = strlen($args[1]);
        }

        return $return;
    }

    /**
     * Validate received XML
     *
     * @param string $xml    XML to validate
     * @param string $schema XML schema
     * @param string &$error Error message
     *
     * @return boolean
     */
    protected function validateXmlAgainstSchema($xml, $schema, &$error)
    {
        // We use DOMDocument object to validate XML againest schema
        $dom = new \DOMDocument;
        $dom->loadXML($xml);

        // Add common schema elements
        $schema = '
<xsd:schema xmlns:xsd="http://www.w3.org/2001/XMLSchema">

 <xsd:element name="' . static::XPC_TAG_ROOT . '">

  <xsd:complexType>
   <xsd:sequence>

    ' . $schema . '
    <xsd:element name="error" type="xsd:string"/>
    <xsd:element name="error_message" type="xsd:string"/>
    <xsd:element name="is_error_message" type="xsd:string" minOccurs="0"/>

   </xsd:sequence>
  </xsd:complexType>

 </xsd:element>

</xsd:schema>';

        // Validate XML againest schema
        $result = @$dom->schemaValidateSource($schema);

        return $result;
    }

    /**
     * Process API response errors
     *
     * @param array $response Response data
     *
     * @return boolean
     */
    protected function processApiError($response)
    {
        $error = false;

        if (isset($response['error']) && $response['error']) {

            $error = 'X-Payments error (code: ' . $response['error'] . '): '
                . (isset($response['error_message']) ? $response['error_message'] : 'Unknown')
                . (isset($this->xpcErrors[$response['error']]) ? $this->xpcErrors[$response['error']] : '');

            $this->getApiError($error);
        }

        return $error;
    }

    /**
     * Return validation schema for test request
     *
     * @return string
     */
    protected function getRequestTestSchema()
    {
        return '
<xsd:element name="hashCode" minOccurs="0">

 <xsd:simpleType>
  <xsd:restriction base="xsd:string">

   <xsd:maxLength value="32"/>
   <xsd:minLength value="32"/>

  </xsd:restriction>
 </xsd:simpleType>

</xsd:element>';
    }

    /**
     * Return validation schema for the "init payment" action
     *
     * @return string
     */
    protected function getRequestInitSchema()
    {
        return '
<xsd:element name="token" minOccurs="0">

 <xsd:simpleType>
  <xsd:restriction base="xsd:string">

   <xsd:maxLength value="32"/>
   <xsd:minLength value="32"/>

  </xsd:restriction>
 </xsd:simpleType>

</xsd:element>
<xsd:element name="txnId" minOccurs="0">

 <xsd:simpleType>
  <xsd:restriction base="xsd:string">

   <xsd:maxLength value="32"/>
   <xsd:minLength value="32"/>

  </xsd:restriction>
 </xsd:simpleType>

</xsd:element>';
    }

    /**
     * Return validation schema for test request
     *
     * @return string
     */
    protected function getRequestPaymentMethodsSchema()
    {
        return '
<xsd:element name="' . static::XPC_MODULE_INFO . '" minOccurs="0" maxOccurs="unbounded">
 <xsd:complexType>
  <xsd:sequence>

   <xsd:element name="name" type="xsd:string"/>

   <xsd:element name="id" type="xsd:positiveInteger"/>

   <xsd:element name="transactionTypes">
    <xsd:complexType>
     <xsd:sequence>
       <xsd:element name="'
            . \XLite\Model\Payment\BackendTransaction::TRAN_TYPE_SALE
            . '" type="xsd:boolean" default="0"/>
       <xsd:element name="'
            . \XLite\Model\Payment\BackendTransaction::TRAN_TYPE_AUTH
            . '" type="xsd:boolean" default="0"/>
       <xsd:element name="'
            . \XLite\Model\Payment\BackendTransaction::TRAN_TYPE_CAPTURE
            . '" type="xsd:boolean" default="0"/>
       <xsd:element name="'
            . \XLite\Model\Payment\BackendTransaction::TRAN_TYPE_CAPTURE_PART
            . '" type="xsd:boolean" default="0"/>
       <xsd:element name="'
            . \XLite\Model\Payment\BackendTransaction::TRAN_TYPE_CAPTURE_MULTI
            . '" type="xsd:boolean" default="0"/>
       <xsd:element name="'
            . \XLite\Model\Payment\BackendTransaction::TRAN_TYPE_VOID
            . '" type="xsd:boolean" default="0"/>
       <xsd:element name="'
            . \XLite\Model\Payment\BackendTransaction::TRAN_TYPE_VOID_PART
            . '" type="xsd:boolean" default="0"/>
       <xsd:element name="'
            . \XLite\Model\Payment\BackendTransaction::TRAN_TYPE_VOID_MULTI
            . '" type="xsd:boolean" default="0"/>
       <xsd:element name="'
            . \XLite\Model\Payment\BackendTransaction::TRAN_TYPE_REFUND
            . '" type="xsd:boolean" default="0"/>
       <xsd:element name="'
            . \XLite\Model\Payment\BackendTransaction::TRAN_TYPE_REFUND_PART
            . '" type="xsd:boolean" default="0"/>
       <xsd:element name="'
            . \XLite\Model\Payment\BackendTransaction::TRAN_TYPE_REFUND_MULTI
            . '" type="xsd:boolean" default="0"/>
       <xsd:element name="'
            . \XLite\Model\Payment\BackendTransaction::TRAN_TYPE_GET_INFO
            . '" type="xsd:boolean" default="0"/>
       <xsd:element name="'
            . \XLite\Model\Payment\BackendTransaction::TRAN_TYPE_ACCEPT
            . '" type="xsd:boolean" default="0"/>
       <xsd:element name="'
            . \XLite\Model\Payment\BackendTransaction::TRAN_TYPE_DECLINE
            . '" type="xsd:boolean" default="0"/>
       <xsd:element name="'
            . \XLite\Model\Payment\BackendTransaction::TRAN_TYPE_TEST
            . '" type="xsd:boolean" default="0"/>
     </xsd:sequence>
    </xsd:complexType>
   </xsd:element>

   <xsd:element name="authCaptureInfo">
    <xsd:complexType>
     <xsd:sequence>
       <xsd:element name="authExp" type="xsd:nonNegativeInteger"/>
       <xsd:element name="captMinLimit" type="xsd:string"/>
       <xsd:element name="captMaxLimit" type="xsd:string"/>
     </xsd:sequence>
    </xsd:complexType>
   </xsd:element>

   <xsd:element name="moduleName" type="xsd:string"/>

   <xsd:element name="settingsHash" type="xsd:string"/>

  </xsd:sequence>

  <xsd:attribute name="type" type="xsd:string"/>

 </xsd:complexType>
</xsd:element>';
    }

    /**
     * Round currency 
     * 
     * @param float $data Data
     *  
     * @return float
     */
    protected function roundCurrency($data)
    {
        return sprintf('%01.2f', round($data, 2));
    }
}
