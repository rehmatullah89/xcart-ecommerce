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

namespace XLite\Module\XC\ProductVariants\View\Product;

/**
 * Variants are based
 *
 * @ListChild (list="admin.product.variants", zone="admin", weight="20")
 */
class VariantsAreBased extends \XLite\Module\XC\ProductVariants\View\Product\AProduct
{
    /**
     * Return templates directory name
     *
     * @return string
     */
    protected function getDir()
    {
        return parent::getDir() . '/variants_are_based';
    }

    /**
     * Check widget visibility
     *
     * @return boolean
     */
    protected function isVisible()
    {
        return parent::isVisible()
            && $this->getVariantsAttributes();
    }

    /**
     * Return title
     *
     * @return string
     */
    protected function getTitle()
    {
        $variants = array();

        foreach ($this->getVariantsAttributes() as $v) {
            $variants[] = $v->getName();
        }

        return str_replace(
            '{{variants}}',
            '<span>' . implode('</span>, <span>', $variants) . '</span>',
            static::t('Product variants are based on {{variants}}')
        );
    }

    /**
     * Return block style
     *
     * @return string
     */
    protected function getBlockStyle()
    {
        return parent::getBlockStyle() . ' variants-are-based';
    }
}
