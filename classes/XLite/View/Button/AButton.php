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

namespace XLite\View\Button;

/**
 * Abstract button
 */
abstract class AButton extends \XLite\View\AView
{
    /**
     * Widget parameter names
     */
    const PARAM_NAME     = 'buttonName';
    const PARAM_VALUE    = 'value';
    const PARAM_LABEL    = 'label';
    const PARAM_STYLE    = 'style';
    const PARAM_DISABLED = 'disabled';
    const PARAM_ID       = 'id';
    const PARAM_ATTRIBUTES = 'attributes';

    /**
     * Get a list of CSS files required to display the widget properly
     *
     * @return array
     */
    public function getCSSFiles()
    {
        $list = parent::getCSSFiles();
        $list[] = 'button/css/button.css';

        return $list;
    }

    /**
     * Get a list of JavaScript files required to display the widget properly
     *
     * @return array
     */
    public function getJSFiles()
    {
        $list = parent::getJSFiles();
        $list[] = 'button/js/button.js';

        return $list;
    }

    /**
     * Return widget default template
     *
     * @return string
     */
    protected function getDefaultTemplate()
    {
        return 'button/regular.tpl';
    }

    /**
     * getDefaultLabel
     *
     * @return string
     */
    protected function getDefaultLabel()
    {
        return '--- Button title is not defined ---';
    }

    /**
     * getDefaultStyle
     *
     * @return string
     */
    protected function getDefaultStyle()
    {
        return '';
    }

    /**
     * getDefaultDisableState
     *
     * @return boolean
     */
    protected function getDefaultDisableState()
    {
        return false;
    }

    /**
     * Get default attributes 
     * 
     * @return array
     */
    protected function getDefaultAttributes()
    {
        return array();
    }

    /**
     * Get attributes 
     * 
     * @return array
     */
    protected function getAttributes()
    {
        $list = $this->getParam(static::PARAM_ATTRIBUTES);

        $list['type'] = 'button';
        $list['class'] = $this->getClass();
        if ($this->getId()) {
            $list['id'] = $this->getId();
        }

        if ($this->isDisabled()) {
            $list['disabled'] = 'disabled';
        }

        return $list;
    }

    /**
     * Return button text
     *
     * @return string
     */
    protected function getButtonLabel()
    {
        return $this->getParam(self::PARAM_LABEL);
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
            self::PARAM_NAME     => new \XLite\Model\WidgetParam\String('Name', '', true),
            self::PARAM_VALUE    => new \XLite\Model\WidgetParam\String('Value', '', true),
            self::PARAM_LABEL    => new \XLite\Model\WidgetParam\String('Label', $this->getDefaultLabel(), true),
            self::PARAM_STYLE    => new \XLite\Model\WidgetParam\String('Button style', $this->getDefaultStyle()),
            self::PARAM_DISABLED => new \XLite\Model\WidgetParam\Bool('Disabled', $this->getDefaultDisableState()),
            self::PARAM_ID       => new \XLite\Model\WidgetParam\String('Button ID', ''),
            self::PARAM_ATTRIBUTES => new \XLite\Model\WidgetParam\Collection('Attributes', $this->getDefaultAttributes()),
        );
    }

    /**
     * getClass
     *
     * @return string
     */
    protected function getClass()
    {
        return $this->getParam(self::PARAM_STYLE) . ($this->isDisabled() ? ' disabled' : '');
    }

    /**
     * getId
     *
     * @return string
     */
    protected function getId()
    {
        return $this->getParam(self::PARAM_ID);
    }

    /**
     * Return button name
     *
     * @return string
     */
    protected function getName()
    {
        return $this->getParam(self::PARAM_NAME);
    }

    /**
     * Return button value
     *
     * @return string
     */
    protected function getValue()
    {
        return $this->getParam(self::PARAM_VALUE);
    }

    /**
     * hasName
     *
     * @return void
     */
    protected function hasName()
    {
        return '' !== $this->getParam(self::PARAM_NAME);
    }

    /**
     * hasValue
     *
     * @return void
     */
    protected function hasValue()
    {
        return '' !== $this->getParam(self::PARAM_VALUE);
    }

    /**
     * hasClass
     *
     * @return string
     */
    protected function hasClass()
    {
        return '' !== $this->getParam(self::PARAM_STYLE);
    }

    /**
     * isDisabled
     *
     * @return boolean
     */
    protected function isDisabled()
    {
        return $this->getParam(self::PARAM_DISABLED);
    }
}
