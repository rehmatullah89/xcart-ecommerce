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

namespace XLite\View\FormField\Select\RadioButtonsList;

/**
 * Select based on radio buttons list
 */
abstract class ARadioButtonsList extends \XLite\View\FormField\Select\ASelect
{
    /**
     * Return field template
     *
     * @return string
     */
    protected function getFieldTemplate()
    {
        return 'radio_buttons_list.tpl';
    }

    /**
     * getAttributes
     *
     * @return array
     */
    protected function getAttributes()
    {
        $result = parent::getAttributes();

        if (isset($result['name'])) {
            unset($result['name']);
        }

        return $result;
    }

    /**
     * Get option attributes
     *
     * @param mixed $value Value
     *
     * @return array
     */
    protected function getOptionAttributes($value)
    {
        $attributes = parent::getOptionAttributes($value);
        if ($this->isOptionSelected($value)) {
            $attributes['checked'] = 'checked';
        }

        if (isset($attributes['selected'])) {
            unset($attributes['selected']);
        }

        $attributes['type'] = 'radio';
        $attributes['name'] = $this->getName();

        return $attributes;
    }

    /**
     * Return field value
     *
     * @return mixed
     */
    public function getValue()
    {
        $result = $value = parent::getValue();
        $options = $this->getOptions();
        if (!(isset($value) && isset($options[$value]))) {
            $value = array_keys($options);
            $result = array_shift($value);
        }        
        return $result;
    }
}
