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

namespace XLite\View\ModulesManager\Action;

/**
 * Abstract action link for Module list (Modules manage)
 */
abstract class AAction extends \XLite\View\AView
{
    /**
     * Widget parameters' names
     */
    const PARAM_MODULE      = 'module';
    const PARAM_MODULE_ID   = 'moduleID';

    /**
     * Module object cache
     * 
     * @var \XLite\Model\Module|null
     */
    protected $module = null;

    /**
     * Define widget parameters
     *
     * @return void
     */
    protected function defineWidgetParams()
    {
        parent::defineWidgetParams();

        $this->widgetParams += array(
            self::PARAM_MODULE => new \XLite\Model\WidgetParam\Object('Module', null, false, '\XLite\Model\Module'),
            self::PARAM_MODULE_ID => new \XLite\Model\WidgetParam\Int('Module ID', 0, false),
        );
    }

    /**
     * Get module
     *
     * @return \XLite\Model\Module
     */
    protected function getModuleObject()
    {
        return $this->getParam(self::PARAM_MODULE_ID)
            ? \XLite\Core\Database::getRepo('XLite\Model\Module')->find($this->getParam(self::PARAM_MODULE_ID))
            : $this->getParam(self::PARAM_MODULE);
    }

    /**
     * Get module
     *
     * @return \XLite\Model\Module
     */
    protected function getModule()
    {
        if (!$this->module) {
            $this->module = $this->getModuleObject();
        }
        return $this->module;
    }

    /**
     * Check if widget is visible
     *
     * @return boolean
     */
    protected function isVisible()
    {
        return parent::isVisible()
            && $this->getModule();
    }
}
