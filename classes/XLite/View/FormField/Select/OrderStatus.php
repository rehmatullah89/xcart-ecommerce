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

namespace XLite\View\FormField\Select;

/**
 * Order status selector
 */
class OrderStatus extends \XLite\View\FormField\Select\Regular
{
    /**
     * Common params
     */
    const PARAM_ORDER_ID    = 'orderId';
    const PARAM_ALL_OPTION  = 'allOption';
    const PARAM_DISPLAY_ALL = 'allOption';

    /**
     * Current order
     *
     * @var \XLite\Model\Order
     */
    protected $order = null;

    /**
     * Inventory warning
     *
     * @var boolean
     */
    protected $inventoryWarning = null;


    /**
     * Get a list of CSS files required to display the widget properly
     *
     * @return array
     */
    public function getCSSFiles()
    {
        $list = parent::getCSSFiles();
        $list[] = $this->getDir() . '/select_order_status.css';

        return $list;
    }

    /**
     * Register JS files
     *
     * @return array
     */
    public function getJSFiles()
    {
        $list = parent::getJSFiles();
        $list[] = $this->getDir() . '/select_order_status.js';

        return $list;
    }

    /**
     * Define widget params
     *
     * @return void
     */
    protected function getOrder()
    {
        if ($this->getParam(self::PARAM_ORDER_ID) && is_null($this->order)) {
            $this->order = \XLite\Core\Database::getRepo('\XLite\Model\Order')
                ->find($this->getParam(self::PARAM_ORDER_ID));
        }

        return $this->order;
    }

    /**
     * Return field template
     *
     * @return string
     */
    protected function getFieldTemplate()
    {
        return 'select_order_status.tpl';
    }

    /**
     * Return default options list
     *
     * @return array
     */
    protected function getDefaultOptions()
    {
        $list = \XLite\Model\Order::getAllowedStatuses();
        unset($list[\XLite\Model\Order::STATUS_TEMPORARY]);
        unset($list[\XLite\Model\Order::STATUS_INPROGRESS]);

        foreach ($list as $k => $v) {
            $list[$k] = static::t($v);
        }

        return $list;
    }

    /**
     * Define the options list
     * 
     * @return array
     */
    protected function getOptions()
    {
        $options = parent::getOptions();
        if (
            !$this->getParam(static::PARAM_DISPLAY_ALL)
            && (!$this->getOrder() || \XLite\Model\Order::STATUS_AUTHORIZED != $this->getOrder()->getStatus())
        ) {
            unset($options[\XLite\Model\Order::STATUS_AUTHORIZED]);
        }

        return $options;
    }

    /**
     * Define widget params
     *
     * @return void
     */
    protected function defineWidgetParams()
    {
        parent::defineWidgetParams();

        $this->widgetParams += array(
            self::PARAM_ORDER_ID    => new \XLite\Model\WidgetParam\Int(
                'Order ID', null, false
            ),
            self::PARAM_ALL_OPTION  => new \XLite\Model\WidgetParam\Bool(
                'Show "All" option', false, false
            ),
            self::PARAM_DISPLAY_ALL => new \XLite\Model\WidgetParam\Bool(
                'Display all options', false, false
            ),
        );
    }

    /**
     * Flag to show status change warning
     *
     * @return boolean
     */
    protected function isStatusWarning()
    {
        return $this->isInventoryWarning();
    }

    /**
     * Flag to show status change warning
     *
     * @param string $option Option value
     *
     * @return boolean
     */
    protected function isOptionDisabled($option)
    {
        return in_array($option, $this->getOrderActiveStatuses())
            && $this->isInventoryWarning();
    }

    /**
     * Get list of order statuses which state that product are withdrawn from stock
     * 
     * @return array
     */
    protected function getOrderActiveStatuses()
    {
        return array(
            \XLite\Model\Order::STATUS_QUEUED,
            \XLite\Model\Order::STATUS_SHIPPED,
            \XLite\Model\Order::STATUS_AUTHORIZED,
            \XLite\Model\Order::STATUS_PROCESSED,
            \XLite\Model\Order::STATUS_COMPLETED,
            \XLite\Model\Order::STATUS_REFUNDED,
            \XLite\Model\Order::STATUS_PART_REFUNDED,
        );
    }

    /**
     * Inventory warning
     *
     * @return boolean
     */
    protected function isInventoryWarning()
    {
        if ($this->getOrder() && !isset($this->inventoryWarning)) {
            foreach ($this->getOrder()->getItems() as $item) {
                if (
                    !isset($this->inventoryWarning)
                    && !in_array($this->getOrder()->getStatus(), $this->getOrderActiveStatuses())
                    && $item->getProduct()->getInventory()->getEnabled()
                    && $item->getAmount() > $item->getProduct()->getInventory()->getAmount()
                ) {
                    $this->inventoryWarning = true;
                }
            }
        }

        return $this->inventoryWarning;
    }

    /**
     * Get status warning content
     *
     * @return string
     */
    protected function getStatusWarningContent()
    {
        $content = '';
        if ($this->isInventoryWarning()) {
            $content .= 'Warning! There is not enough product items in stock to process the order';
        }

        return $content;
    }
}
