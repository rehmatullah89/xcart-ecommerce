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


namespace XLite\Module\XC\Mobile\View\ItemsList\Product\Customer;

/**
 * ACustomer
 *
 */
abstract class ACustomer extends \XLite\View\ItemsList\Product\Customer\ACustomer implements \XLite\Base\IDecorator
{
    /**
     * Initialize widget (set attributes)
     *
     * @param array $params Widget params
     *
     * @return void
     */
    public function setWidgetParams(array $params)
    {
        parent::setWidgetParams($params);

        if ((\XLite\Core\Request::isMobileDevice())) {
            $this->widgetParams[self::PARAM_DISPLAY_MODE]->setValue(self::DISPLAY_MODE_LIST);
        }
    }

    /**
     * Wrapper for strlen to support UTF8 strings
     *
     * @param $str      String
     * @param $encoding Encoding OPTIONAL
     *
     * @return string
     */
    protected function funcStrlen($str, $encoding = '')
    {
        return function_exists('mb_strlen')
            ? mb_strlen($str, $encoding ?: $this->getCharset())
            : strlen($str);
    }

    /**
     * Wrapper for substr to support UTF8 strings
     *
     * @return string
     */
    protected function funcSubstr()
    {
        $defaultCharset = $this->getCharset();

        $args = func_get_args();

        if (function_exists('mb_substr')) {
            if (
                !isset($args[3]) && isset($args[2])
            ) {
                $args[3] = $defaultCharset;
            }

            $result = call_user_func_array('mb_substr', $args);
        } else {
            $result = call_user_func_array('substr', $args);
        }

        return $result;
    }

    /**
     * Get truncated text for a list
     *
     * @param string    $text   Product name
     * @param integer   $len    Name length OPTIONAL
     * @param string    $etc    Text ending OPTIONAL
     *
     * @return string
     */
    public function getTruncatedName($text, $len = 60, $etc = '...')
    {
        $string = $text;

        if ($this->funcStrlen($text) > $len) {
            $string = $this->funcSubstr($text, 0, $len) . $etc;
        }

        return $string;
    }

    /**
     * Disable 'Add to cart' button for mobile devices
     *
     * @return boolean
     */
    protected function isDisplayAdd2CartButton()
    {
        return parent::isDisplayAdd2CartButton() && !\XLite\Core\Request::isMobileDevice();
    }
}
