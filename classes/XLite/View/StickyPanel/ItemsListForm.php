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

namespace XLite\View\StickyPanel;

/**
 * Panel form items list-based form
 */
class ItemsListForm extends \XLite\View\Base\FormStickyPanel
{
    /**
     * Buttons list (cache)
     *
     * @var array
     */
    protected $buttonsList;

    /**
     * Additional buttons (cache)
     *
     * @var array
     */
    protected $additionalButtons;

    /**
     * Register JS files
     *
     * @return array
     */
    public function getJSFiles()
    {
        $list = parent::getJSFiles();

        $list[] = 'js/stickyPanelModelList.js';

        return $list;
    }

    /**
     * Get buttons widgets
     *
     * @return array
     */
    protected function getButtons()
    {
        if (!isset($this->buttonsList)) {
            $this->buttonsList = $this->defineButtons();
        }

        return $this->buttonsList;
    }

    /**
     * Define buttons widgets
     *
     * @return array
     */
    protected function defineButtons()
    {
        $list = array();
        $list['save'] = $this->getSaveWidget();

        if ($this->getAdditionalButtons()) {
            $list['additional'] = $this->getWidget(
                array(
                    'template' => 'items_list/model/additional_buttons.tpl',
                )
            );
        }

        return $list;
    }

    /**
     * Get "save" widget
     *
     * @return \XLite\View\Button\Submit
     */
    protected function getSaveWidget()
    {
        return $this->getWidget(
            array(
                'style'    => 'action submit',
                'label'    => $this->getSaveWidgetLabel(),
                'disabled' => true,
            ),
            'XLite\View\Button\Submit'
        );
    }

    /**
     * Defines the label for the save button
     *
     * @return string
     */
    protected function getSaveWidgetLabel()
    {
        return static::t('Save changes');
    }

    /**
     * Flag to display OR label
     *
     * @return boolean
     */
    protected function isDisplayORLabel()
    {
        return true;
    }

    /**
     * Returns "more actions" specific label
     *
     * @return string
     */
    protected function getMoreActionsText()
    {
        return static::t('More actions');
    }

    /**
     * Returns "more actions" specific label for bubble context window
     *
     * @return string
     */
    protected function getMoreActionsPopupText()
    {
        return static::t('More actions');
    }

    /**
     * Get additional buttons
     *
     * @return array
     */
    protected function getAdditionalButtons()
    {
        if (!isset($this->additionalButtons)) {
            $this->additionalButtons = $this->defineAdditionalButtons();
        }

        return $this->additionalButtons;
    }

    /**
     * Define additional buttons
     *
     * @return array
     */
    protected function defineAdditionalButtons()
    {
        return array();
    }

    /**
     * Get class
     *
     * @return string
     */
    protected function getClass()
    {
        $class = parent::getClass();

        $class = trim($class . ' model-list another-sticky');

        if ($this->getAdditionalButtons()) {
            $class = trim($class . ' has-add-buttons');
        }

        return $class;
    }
}

