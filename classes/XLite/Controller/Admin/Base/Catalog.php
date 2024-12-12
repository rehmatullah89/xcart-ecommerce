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

namespace XLite\Controller\Admin\Base;

/**
 * Catalog
 */
abstract class Catalog extends \XLite\Controller\Admin\AAdmin
{
    // {{{ Abstract methods

    /**
     * Check if we need to create new product or modify an existsing one
     *
     * NOTE: this function is public since it's neede for widgets
     *
     * @return boolean
     */
    abstract public function isNew();

    /**
     * Return class name for the controller main form
     *
     * @return string
     */
    abstract protected function getFormClass();

    /**
     * Return entity object
     *
     * @return \XLite\Model\AEntity
     */
    abstract protected function getEntity();

    /**
     * Add new entity
     *
     * @return void
     */
    abstract protected function doActionAdd();

    /**
     * Modify existing entity
     *
     * @return void
     */
    abstract protected function doActionUpdate();

    // }}}

    // {{{ Data management

    /**
     * Check ACL permissions
     *
     * @return boolean
     */
    public function checkACL()
    {
        return parent::checkACL() || \XLite\Core\Auth::getInstance()->isPermissionAllowed('manage catalog');
    }

    /**
     * Return current (or default) category object
     *
     * @return \XLite\Model\Category
     */
    public function getCategory()
    {
        return \XLite\Core\Database::getRepo('XLite\Model\Category')->getCategory($this->getCategoryId());
    }

    // }}}

    // {{{ Clean URL routines

    /**
     * Return maximum length of the "cleanURL" model field.
     * Function is public since it's used in templates
     *
     * @return void
     */
    public function getCleanURLMaxLength()
    {
        return \XLite\Core\Database::getRepo(get_class($this->getEntity()))->getFieldInfo('cleanURL', 'length');
    }

    /**
     * Generate clean URL
     *
     * @param string $name Product name
     *
     * @return string
     */
    protected function generateCleanURL($name)
    {
        $result = '';

        // Prepare the result and check if it could be generated
        if (!empty($name)) {
            $separator = \XLite\Core\Converter::getCleanURLSeparator();
            $result = strtolower(preg_replace('/\W+/S', $separator, $name));

            if (!preg_replace('/' . preg_quote($separator) . '/', '', $result)) {
                $result = $this->getEntity()->getCleanURL();
                $this->setCleanURLAutoGenerateWarning($name);
                $name = null;
            }
        }

        if (!empty($name)) {
            $entity = $this->getEntity();
            $result = \XLite\Core\Database::getRepo(get_class($entity))->generateCleanURL(
                $entity,
                $name
            );
        }

        return $result;
    }

    /**
     * Set warning
     *
     * @param string $name Product name
     *
     * @return boolean
     */
    protected function setCleanURLAutoGenerateWarning($name)
    {
        \XLite\Core\TopMessage::addWarning(
            'Cannot autogenerate clean URL for the product name "{{name}}". Please specify it manually.',
            array('name' => $name)
        );
    }


    // }}}

    // {{{ Action handlers

    /**
     * doActionModify
     *
     * @return void
     */
    protected function doActionModify()
    {
        $form = \Includes\Pattern\Factory::create($this->getFormClass());
        $data = $form->getRequestData();
        $util = '\Includes\Utils\ArrayManager';
        $pref = $this->getPrefixPostedData();

        \XLite\Core\Request::getInstance()->mapRequest(
            array(
                $pref => array(
                    'cleanURL' => $util::getIndex($util::getIndex($data, $pref), 'cleanURL'),
                )
            )
        );

        if ($form->getValidationMessage()) {
            \XLite\Core\TopMessage::addError($form->getValidationMessage());

        } elseif ($this->isNew()) {
            $this->doActionAdd();

        } else {
            $this->doActionUpdate();
        }
    }

    // }}}
}
