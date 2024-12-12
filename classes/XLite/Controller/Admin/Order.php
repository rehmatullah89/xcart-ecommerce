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

namespace XLite\Controller\Admin;

/**
 * Order page controller
 */
class Order extends \XLite\Controller\Admin\AAdmin
{
    /**
     * Controller parameters
     *
     * @var array
     */
    protected $params = array('target', 'order_id', 'order_number', 'page');

    /**
     * Order (local cache)
     *
     * @var   \XLite\Model\Order
     */
    protected $order;

    /**
     * Check ACL permissions
     *
     * @return boolean
     */
    public function checkACL()
    {
        return parent::checkACL() || \XLite\Core\Auth::getInstance()->isPermissionAllowed('manage orders');
    }

    /**
     * handleRequest
     *
     * @return void
     */
    public function handleRequest()
    {
        if (
            !empty(\XLite\Core\Request::getInstance()->action)
            && 'update' != \XLite\Core\Request::getInstance()->action
        ) {
            $order = $this->getOrder();

            if (isset($order)) {

                $allowedTransactions = $order->getAllowedPaymentActions();

                if (isset($allowedTransactions[\XLite\Core\Request::getInstance()->action])) {
                    \XLite\Core\Request::getInstance()->transactionType = \XLite\Core\Request::getInstance()->action;
                    \XLite\Core\Request::getInstance()->action = 'PaymentTransaction';
                    \XLite\Core\Request::getInstance()->setRequestMethod('POST');
                }
            }
        }

        return parent::handleRequest();
    }

    /**
     * Check if current page is accessible
     *
     * @return boolean
     */
    public function checkAccess()
    {
        return parent::checkAccess()
            && $this->getOrder()
            && $this->getOrder()->getProfile();
    }

    /**
     * Get order
     *
     * @return \XLite\Model\Order
     */
    public function getOrder()
    {
        if (!isset($this->order)) {
            if (\XLite\Core\Request::getInstance()->order_id) {
                $this->order = \XLite\Core\Database::getRepo('XLite\Model\Order')
                    ->find(intval(\XLite\Core\Request::getInstance()->order_id));

            } elseif (\XLite\Core\Request::getInstance()->order_number) {
                $this->order = \XLite\Core\Database::getRepo('XLite\Model\Order')
                    ->findOneByOrderNumber(\XLite\Core\Request::getInstance()->order_number);
            }
        }

        return $this->order;
    }

    /**
     * getRequestData
     * TODO: to remove
     *
     * @return void
     */
    protected function getRequestData()
    {
        return \Includes\Utils\ArrayManager::filterByKeys(
            \XLite\Core\Request::getInstance()->getData(),
            array('status', 'adminNotes')
        );
    }

    /**
     * doActionUpdate
     *
     * @return void
     */
    protected function doActionUpdate()
    {
        $data = $this->getRequestData();
        $order = $this->getOrder();

        $changes = $this->getOrderChanges($order, $data);

        \XLite\Core\Database::getRepo('\XLite\Model\Order')->updateById(
            $order->getOrderId(),
            $data
        );

        \XLite\Core\OrderHistory::getInstance()->registerOrderChanges($order->getOrderId(), $changes);
    }

    /**
     * Return requested changes for the order
     *
     * @param \XLite\Model\Order $order Order
     * @param array              $data  Data to change
     *
     * @return array
     */
    protected function getOrderChanges(\XLite\Model\Order $order, array $data)
    {
        $changes = array();

        foreach ($data as $name => $value) {
            if ('status' === $name) {
                continue;
            }
            $orderValue = $order->{'get' . ucfirst($name)}();

            if ($orderValue !== $value) {
                $changes[$name] = array(
                    'old' => $orderValue,
                    'new' => $value,
                );
            }
        }

        return $changes;
    }

    /**
     * doActionUpdate
     *
     * @return void
     */
    protected function doActionPaymentTransaction()
    {
        $order = $this->getOrder();

        if ($order) {
            $transactions = $order->getPaymentTransactions();
            if (!empty($transactions)) {
                $transactions[0]->getPaymentMethod()->getProcessor()->doTransaction(
                    $transactions[0],
                    \XLite\Core\Request::getInstance()->transactionType
                );
            }
        }

    }

    /**
     * getViewerTemplate
     *
     * @return void
     */
    protected function getViewerTemplate()
    {
        $result = parent::getViewerTemplate();

        if ('invoice' === \XLite\Core\Request::getInstance()->mode) {
            $result = 'common/print_invoice.tpl';
        }

        return $result;
    }

    // {{{ Pages

    /**
     * Get pages sections
     *
     * @return array
     */
    public function getPages()
    {
        $list = parent::getPages();

        $list['default'] = 'General info';
        $list['invoice'] = 'Invoice';
        $list['history'] = 'History';

        return $list;
    }

    /**
     * Get pages templates
     *
     * @return array
     */
    protected function getPageTemplates()
    {
        $list = parent::getPageTemplates();

        $list['default'] = 'order/page/info.tab.tpl';
        $list['invoice'] = 'order/page/invoice.tpl';
        $list['history'] = 'order/history.tpl';

        return $list;
    }

    // }}}
}
