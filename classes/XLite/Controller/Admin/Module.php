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
 * Module settings
 */
class Module extends \XLite\Controller\Admin\AAdmin
{
    /**
     * Module object
     *
     * @var mixed
     */
    protected $module;

    /**
     * handleRequest
     *
     * @return void
     */
    public function handleRequest()
    {
        if (!$this->getModuleID()) {
            $this->setReturnURL($this->buildURL('addons_list_installed'));
        }

        parent::handleRequest();
    }

    /**
     * Return current module options
     *
     * @return array
     */
    public function getOptions()
    {
        return \XLite\Core\Database::getRepo('\XLite\Model\Config')
            ->getByCategory($this->getModule()->getActualName(), true, true);
    }

    /**
     * Return the current page title (for the content area)
     *
     * @return string
     */
    public function getTitle()
    {
        return static::t(
            'X module settings',
            array(
                'name'   => $this->getModule()->getModuleName(),
            )
        );
    }

    /**
     * Return current module object
     *
     * @return \XLite\Model\Module
     * @throws \Exception
     */
    public function getModule()
    {
        if (!isset($this->module)) {
            $this->module = \XLite\Core\Database::getRepo('\XLite\Model\Module')->find($this->getModuleID());

            if (!$this->module) {
                throw new \Exception('Add-on does not exist (ID#' . $this->getModuleID() . ')');
            }
        }

        return $this->module;
    }

    /**
     * Get current module ID
     *
     * @return integer
     */
    protected function getModuleID()
    {
        return \XLite\Core\Request::getInstance()->moduleId;
    }

    /**
     * Update module settings
     *
     * @return void
     */
    protected function doActionUpdate()
    {
        if ($this->getModelForm()->performAction('update')) {
            $this->setReturnURL(
                \XLite\Core\Request::getInstance()->return ?: $this->getModulePageURL()
            );
        }
    }

    /**
     * Module page URL getter
     *
     * @return string
     */
    protected function getModulePageURL()
    {
        $module = $this->getModule();
        $params = array(
            'clearCnd' => 1,
            'pageId' => \XLite\Core\Database::getRepo('XLite\Model\Module')->getModulePageId(
                $module->getAuthor(),
                $module->getName(),
                \XLite\View\Pager\Admin\Module\Manage::getInstance()->getItemsPerPage()
            ),
        );

        return $this->buildURL('addons_list_installed', '', $params) . '#' . $module->getName();
    }

    /**
     * getModelFormClass
     *
     * @return string
     */
    protected function getModelFormClass()
    {
        return '\XLite\View\Model\ModuleSettings';
    }
}
