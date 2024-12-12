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


namespace XLite\Module\XC\Mobile\View\Button;

/**
 * Abstract button
 *
 */
abstract class AButton extends \XLite\View\Button\AButton implements \XLite\Base\IDecorator
{

    /**
     * Widget parameter names
     */

    const PARAM_DATATHEME   = 'dataTheme';
    const PARAM_DATAICON    = 'dataIcon';
    const PARAM_DATAICONPOS = 'dataIconPos';
    const PARAM_DATAINLINE  = 'dataInline';
    const PARAM_DATAREL     = 'dataRel';
    const PARAM_DATAMINI    = 'dataMini';
    const PARAM_DATAPOPPOS  = 'dataPopupPosition';
    const PARAM_DATATRANSIT = 'dataTransition';
    const PARAM_ONCLICK     = 'onClick';
    const PARAM_DATAAJAX    = 'dataAjax';

    /**
     * getClass
     *
     * @return string
     */
    protected function getClass()
    {
        return (\XLite\Core\Request::isMobileDevice()) ? $this->getParam(self::PARAM_STYLE) . ($this->isDisabled() ? ' ui-disabled' : '') : parent::getClass();
    }

    /**
     * getDefaultDataTheme
     *
     * @return string
     */
    protected function getDefaultDataTheme()
    {
        return 'c';
    }

    /**
     * Return jQM data-theme
     *
     * @return string
     */
    protected function getDataTheme()
    {
        return $this->getParam(self::PARAM_DATATHEME);
    }

    /**
     * Return jQM data-icon
     *
     * @return string
     */
    protected function getDataIcon()
    {
        return $this->getParam(self::PARAM_DATAICON);
    }

    /**
     * Return jQM data-iconpos
     *
     * @return string
     */
    protected function getDataIconPos()
    {
        return $this->getParam(self::PARAM_DATAICONPOS);
    }

    /**
     * Return jQM data-iconpos
     *
     * @return string
     */
    protected function getDataInline()
    {
        return $this->getParam(self::PARAM_DATAINLINE);
    }

    /**
     * Return jQM data-rel
     *
     * @return string
     */
    protected function getDataRel()
    {
        return $this->getParam(self::PARAM_DATAREL);
    }

    /**
     * Return jQM data-rel
     *
     * @return string
     */
    protected function getDataMini()
    {
        return $this->getParam(self::PARAM_DATAMINI);
    }

    /**
     * Return jQM data-ajax
     *
     * @return string
     */
    protected function getDataAJAX()
    {
        return $this->getParam(self::PARAM_DATAAJAX);
    }

    /**
     * Return jQM data-position-to
     *
     * @return string
     */
    protected function getPositionTo()
    {
        return $this->getParam(self::PARAM_DATAPOPPOS);
    }

    /**
     * Return jQM data-transition
     *
     * @return string
     */
    protected function getTransition()
    {
        return $this->getParam(self::PARAM_DATATRANSIT);
    }

    /**
     * Return onclick
     *
     * @return string
     */
    protected function getOnClick()
    {
        return $this->getParam(self::PARAM_ONCLICK);
    }

    /**
     * Define widget parameters
     *
     * @return void
     */
    protected function defineWidgetParams()
    {
        parent::defineWidgetParams();

        $this->widgetParams += array(
            self::PARAM_DATATHEME   => new \XLite\Model\WidgetParam\String('Data theme', $this->getDefaultDataTheme(), true),
            self::PARAM_DATAICON    => new \XLite\Model\WidgetParam\String('Data icon', '', true),
            self::PARAM_DATAICONPOS => new \XLite\Model\WidgetParam\String('Data icon posision', '', true),
            self::PARAM_DATAINLINE  => new \XLite\Model\WidgetParam\String('Data inline', 'true', true),
            self::PARAM_DATAREL     => new \XLite\Model\WidgetParam\String('Data rel', '', true),
            self::PARAM_DATAAJAX    => new \XLite\Model\WidgetParam\String('Data ajax', 'true', true),
            self::PARAM_DATAMINI    => new \XLite\Model\WidgetParam\String('Data mini', 'false', true),
            self::PARAM_DATAPOPPOS  => new \XLite\Model\WidgetParam\String('Data popup position', '', true),
            self::PARAM_DATATRANSIT => new \XLite\Model\WidgetParam\String('Data popup transition', '', true),
            self::PARAM_ONCLICK     => new \XLite\Model\WidgetParam\String('OnClick event', false, true),
        );
    }

    /**
     * Get attributes
     *
     * @return array
     */
    protected function getAttributes()
    {
        $list = parent::getAttributes();

        if (\XLite\Core\Request::isMobileDevice()) {
            $list = array_merge($list, array(
                'data-role'     => 'button',
                'data-theme'    => $this->getDataTheme(),
                'data-inline'   => $this->getDataInline(),
                'data-mini'     => $this->getDataMini(),
                'data-ajax'     => (string)$this->getDataAJAX(),
            ));

            if ($this->getDataIcon()) {
                $list['data-icon'] = $this->getDataIcon();
            }

            if ($this->getDataIconPos()) {
                $list['data-iconpos'] = $this->getDataIconPos();
            }

            if ($this->getDataRel()) {
                $list['data-rel'] = $this->getDataRel();
            }

            if ($this->getPositionTo()) {
                $list['data-position-to'] = $this->getPositionTo();
            }

            if ($this->getTransition()) {
                $list['data-transition'] = $this->getTransition();
            }

            if ($this->getOnClick()) {
                $list['onclick'] = $this->getOnClick();
            }
        }

        return $list;
    }
}