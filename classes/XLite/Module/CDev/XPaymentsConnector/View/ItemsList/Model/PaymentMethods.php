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

namespace XLite\Module\CDev\XPaymentsConnector\View\ItemsList\Model;

/**
 * Saved credit cards items list
 */
class PaymentMethods extends \XLite\View\ItemsList\Model\Table
{

    // {{{ Definers

    /**
     * Define columns structure
     *
     * @return array
     */
    protected function defineColumns()
    {
        return array(
            'name' => array(
                static::COLUMN_NAME     => \XLite\Core\Translation::lbl('Payment method'),
                static::COLUMN_NO_WRAP  => true,
                static::COLUMN_MAIN     => true,
                static::COLUMN_ORDERBY  => 100,
            ),
            'conf_id' => array(
                static::COLUMN_NAME     => \XLite\Core\Translation::lbl('X-Payments configuration ID'),
                static::COLUMN_NO_WRAP  => true,
                static::COLUMN_ORDERBY  => 200,
            ),
            'sale' => array(
                static::COLUMN_NAME     => \XLite\Core\Translation::lbl('Sale'),
                static::COLUMN_NO_WRAP  => true,
                static::COLUMN_ORDERBY  => 300,
            ),
            'auth' => array(
                static::COLUMN_NAME     => \XLite\Core\Translation::lbl('Auth'),
                static::COLUMN_NO_WRAP  => true,
                static::COLUMN_ORDERBY  => 400,
            ),
            'capture' => array(
                static::COLUMN_NAME     => \XLite\Core\Translation::lbl('Capture'),
                static::COLUMN_NO_WRAP  => true,
                static::COLUMN_ORDERBY  => 500,
            ),
            'void' => array(
                static::COLUMN_NAME     => \XLite\Core\Translation::lbl('Void'),
                static::COLUMN_NO_WRAP  => true,
                static::COLUMN_ORDERBY  => 600,
            ),
            'refund' => array(
                static::COLUMN_NAME     => \XLite\Core\Translation::lbl('Refund'),
                static::COLUMN_NO_WRAP  => true,
                static::COLUMN_ORDERBY  => 700,
            ),
            'save_cards' => array(
                static::COLUMN_NAME     => \XLite\Core\Translation::lbl('Save cards'),
                static::COLUMN_NO_WRAP  => true,
                static::COLUMN_TEMPLATE => 'modules/CDev/XPaymentsConnector/settings/payment_methods/list.check.tpl',
                static::COLUMN_ORDERBY  => 800,
            ),
        );
    }

    /**
     * Define repository name
     *
     * @return string
     */
    protected function defineRepositoryName()
    {
        return 'XLite\Model\Payment\Method';
    }

    // }}}

    // {{{ Behaviors

    /**
     * Mark list as removable
     *
     * @return boolean
     */
    protected function isRemoved()
    {
        return false;
    }

    /**
     * Mark list as switchable (enable / disable)
     *
     * @return boolean
     */
    protected function isSwitchable()
    {
        return false;
    }

    /**
     * Creation button position
     *
     * @return integer
     */
    protected function isCreation()
    {
        return static::CREATE_INLINE_NONE;
    }

    // }}}

    // {{{ Search

    /**
     * Return search parameters.
     *
     * @return array
     */
    static public function getSearchParams()
    {
        return array();
    }

    /**
     * Return params list to use for search
     *
     * @return \XLite\Core\CommonCell
     */
    protected function getSearchCondition()
    {
        $cnd = parent::getSearchCondition();

        $cnd->{\XLite\Model\Repo\Payment\Method::P_CLASS}
            = 'Module\CDev\XPaymentsConnector\Model\Payment\Processor\XPayments';

        return $cnd;
    }

    // }}}

    /**
     * Get column cell class
     *
     * @param array                $column Column
     * @param \XLite\Model\AEntity $entity Model OPTIONAL
     *
     * @return string
     */
    protected function getColumnClass(array $column, \XLite\Model\AEntity $entity = null)
    {
        return parent::getColumnClass($column, $entity);
    }

    /**
     * Get column value
     *
     * @param array                $column Column
     * @param \XLite\Model\AEntity $entity Model
     *
     * @return mixed
     */
    protected function getColumnValue(array $column, \XLite\Model\AEntity $entity)
    {
        if ('name' == $column[static::COLUMN_CODE]) {
            $result = parent::getColumnValue($column, $entity);

        } elseif ('conf_id' == $column[static::COLUMN_CODE]) {
            $result = $entity->getSetting('id');

        } else {
            $result = $this->getTransactionTypeStatus($entity, $column[static::COLUMN_CODE]);
        }

        return $result;
    }

    /**
     * Build entity page URL
     *
     * @param \XLite\Model\AEntity $entity Entity
     * @param array                $column Column data
     *
     * @return string
     */
    protected function buildEntityURL(\XLite\Model\AEntity $entity, array $column)
    {
        return 'order' == $column[static::COLUMN_CODE]
            ? null
            : parent::buildEntityURL($column, $entity);
    }

    /**
     * Check - 'save cards' options is enabled or not
     * 
     * @param \XLite\Model\AEntity $entity Entity
     *  
     * @return boolean
     */
    protected function isSaveCards(\XLite\Model\AEntity $entity)
    {
        return $entity->getSetting('saveCards') == 'Y';
    }
}
