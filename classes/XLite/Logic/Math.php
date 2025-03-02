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

namespace XLite\Logic;

/**
 * Mathematic
 */
class Math extends \XLite\Logic\ALogic
{
    /**
     * Storage precision
     */
    const STORE_PRECISION = 4;

    // {{{ Round

    /**
     * Round
     *
     * @param float   $value     Value
     * @param integer $precision Precision OPTIONAL
     *
     * @return float|integer
     */
    public function round($value, $precision = 0)
    {
        return $this->roundMath($value, $precision);
    }

    /**
     * Round by currency
     *
     * @param float                 $value    Value
     * @param \XLite\Model\Currency $currency Currency
     *
     * @return float
     */
    public function roundByCurrency($value, \XLite\Model\Currency $currency)
    {
        return $this->round($value, $currency->getE());
    }

    /**
     * Round and format by currency
     *
     * @param float                 $value    Value
     * @param \XLite\Model\Currency $currency Currency
     *
     * @return string
     */
    public function formatValue($value, \XLite\Model\Currency $currency)
    {
        return number_format(
            $this->roundByCurrency($value, $currency),
            $currency->getE(),
            $currency->getDecimalDelimiter(),
            $currency->getThousandDelimiter()
        );
    }

    /**
     * Format currency as parts
     *
     * @param float                 $value    Value
     * @param \XLite\Model\Currency $currency Currency
     *
     * @return array
     */
    public function formatParts($value, \XLite\Model\Currency $currency)
    {
        $value = $currency->roundValue($value);

        $parts = array();

        if (0 > $value) {
            $parts['sign'] = '-';
        }

        if (!$currency->getPrefix() && !$currency->getSuffix()) {
            $parts['prefix'] = $currency->getCode();

        } elseif ($currency->getPrefix()) {
            $parts['prefix'] = $currency->getPrefix();
        }

        $parts['integer'] = number_format(floor(abs($value)), 0, '', $currency->getThousandDelimiter());

        if (0 < $currency->getE()) {
            $parts['decimalDelimiter'] = $currency->getDecimalDelimiter();
            $parts['decimal'] = str_pad(
                substr(
                    strval(abs($value != 0 ? $value : 1) * pow(10, $currency->getE())),
                    -1 * $currency->getE()
                ),
                $currency->getE(),
                '0',
                STR_PAD_LEFT
            );
        }

        if ($currency->getSuffix()) {
            $parts['suffix'] = $currency->getSuffix();
        }

        return $parts;
    }

    /**
     * Round up
     *
     * @param float   $value     Value
     * @param integer $precision Precision OPTIONAL
     *
     * @return float|integer
     */
    public function roundUp($value, $precision = 0)
    {
        $multi = pow(10, $precision);

        return ceil($value * $multi) / $multi;
    }

    /**
     * Round down
     *
     * @param float   $value     Value
     * @param integer $precision Precision OPTIONAL
     *
     * @return float|integer
     */
    public function roundDown($value, $precision = 0)
    {
        $multi = pow(10, $precision);

        return floor($value * $multi) / $multi;
    }

    /**
     * Round up (ceiling)
     *
     * @param float   $value     Value
     * @param integer $precision Precision OPTIONAL
     *
     * @return float|integer
     */
    public function roundCeil($value, $precision = 0)
    {
        return 0 > $value
            ? $this->roundDown($value, $precision)
            : $this->roundUp($value, $precision);
    }

    /**
     * Round down (floor)
     *
     * @param float   $value     Value
     * @param integer $precision Precision OPTIONAL
     *
     * @return float|integer
     */
    public function roundFloor($value, $precision = 0)
    {
        return 0 > $value
            ? $this->roundUp($value, $precision)
            : $this->roundDown($value, $precision);
    }

    /**
     * Round (half up)
     *
     * @param float   $value     Value
     * @param integer $precision Precision OPTIONAL
     *
     * @return float|integer
     */
    public function roundHalfUp($value, $precision = 0)
    {
        return $this->isRoundHalf($value, $precision)
            ? $this->roundCeil($value, $precision)
            : $this->roundMath($value, $precision);
    }

    /**
     * Round (half down)
     *
     * @param float   $value     Value
     * @param integer $precision Precision OPTIONAL
     *
     * @return float|integer
     */
    public function roundHalfDown($value, $precision = 0)
    {
        return $this->isRoundHalf($value, $precision)
            ? $this->roundFloor($value, $precision)
            : $this->roundMath($value, $precision);
    }

    /**
     * Round (half even)
     *
     * @param float   $value     Value
     * @param integer $precision Precision OPTIONAL
     *
     * @return float|integer
     */
    public function roundHalfEven($value, $precision = 0)
    {
        if ($this->isRoundHalf($value, $precision)) {
            $result = $this->isRoundEven($value, $precision)
                ? $this->roundFloor($value, $precision)
                : $this->roundCeil($value, $precision);

        } else {
            $result = $this->roundMath($value, $precision);
        }

        return $result;
    }

    /**
     * Round (standard)
     *
     * @param float   $value     Value
     * @param integer $precision Precision OPTIONAL
     *
     * @return float|integer
     */
    public function roundMath($value, $precision = 0)
    {
        return round($value, $precision);
    }

    /**
     * Check - value is half-based or not
     *
     * @param float   $value     Value
     * @param integer $precision Precision
     *
     * @return boolean
     */
    protected function isRoundHalf($value, $precision)
    {
        $result = false;

        $value -= floor($value);
        if (0 != $value) {
            $result = (bool)preg_match('/^50*$/Ss', substr($value, $precision + 2));
        }

        return $result;
    }

    /**
     * Check - value is even or not
     *
     * @param float   $value     Value
     * @param integer $precision Precision
     *
     * @return boolean
     */
    protected function isRoundEven($value, $precision)
    {
        return 0 == floor($value * pow(10, $precision)) % 2;
    }

    // }}}
}
