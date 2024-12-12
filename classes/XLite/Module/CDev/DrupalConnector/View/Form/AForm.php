<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * X-Cart
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the GNU General Pubic License (GPL 2.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.gnu.org/licenses/gpl-2.0.html
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
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU General Pubic License (GPL 2.0)
 * @link      http://www.x-cart.com/
 */

namespace XLite\Module\CDev\DrupalConnector\View\Form;

/**
 * Abstract form widget
 */
abstract class AForm extends \XLite\View\Form\AForm implements \XLite\Base\IDecorator
{
    /**
     * Chech if widget is exported into Drupal and current form has its method = "GET"
     *
     * @return boolean
     */
    protected function isDrupalGetForm()
    {
        return \XLite\Module\CDev\DrupalConnector\Handler::getInstance()->checkCurrentCMS()
            && 'get' == strtolower($this->getParam(self::PARAM_FORM_METHOD));
    }

    /**
     * This JavaScript code will be performed when form submits
     *
     * @return string
     */
    protected function getJSOnSubmitCode()
    {
        return ($this->isDrupalGetForm() ? 'drupalOnSubmitGetForm(this); ' : '') . parent::getJSOnSubmitCode();
    }

    /**
     * JavaScript: compose the "{'a':<a>,'b':<b>,...}" string (JS array) by the params array
     *
     * @return string
     */
    protected function getFormParamsAsJSArray()
    {
        return '[\'' . implode('\',\'', array_keys($this->getFormParams())) . '\']';
    }

    /**
     * Define widget parameters
     *
     * @return void
     */
    protected function defineWidgetParams()
    {
        parent::defineWidgetParams();

        $this->widgetParams[self::PARAM_FORM_PARAMS]->appendValue(array('q' => ''));
    }
}
