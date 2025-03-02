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
 * Delete user button widget. Customer area.
 */
class DeleteUser extends \XLite\View\Button\APopupButton
{
    /**
     * getJSFiles
     *
     * @return array
     */
    public function getJSFiles()
    {
        $list = parent::getJSFiles();
        $list[] = 'button/js/delete_user.js';

        return $list;
    }

    /**
     * getJSFiles
     *
     * @return array
     */
    public function getCSSFiles()
    {
        $list = parent::getCSSFiles();
        $list[] = 'button/css/delete_user.css';

        return $list;
    }

    /**
     * Return URL parameters to use in AJAX popup
     *
     * @return array
     */
    protected function prepareURLParams()
    {
        return array(
            'target' => 'profile',
            'mode'   => 'delete',
            'widget' => '\XLite\View\Account\Delete',
        );
    }

    /**
     * Return default button label
     *
     * @return string
     */
    protected function getDefaultLabel()
    {
        return 'Delete profile';
    }

    /**
     * Return widget default template
     *
     * @return string
     */
    protected function getDefaultTemplate()
    {
        return 'button/delete_user.tpl';
    }

    /**
     * Return CSS classes
     *
     * @return string
     */
    protected function getClass()
    {
        return 'delete-user-button ' . ($this->getParam(self::PARAM_STYLE) ?: '');
    }

}
