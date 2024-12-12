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

namespace XLite\Module\XC\Mobile\View;

/**
 * AView
 */
abstract class AView extends \XLite\View\AView implements \XLite\Base\IDecorator
{
    /**
     * Register JS files
     *
     * @return array
     */
    protected function getThemeFiles($adminZone = null)
    {
        $list = parent::getThemeFiles($adminZone);

        if (is_null($adminZone) ? \XLite::isAdminZone() : $adminZone) {
            // Admin side includings
            $list[static::RESOURCE_CSS][] = 'module_page.css';
        }

        return $list;
    }

    /**
     * Register CSS files
     *
     * @return void
     */
    protected function registerCSSResources($files, $index, $interface)
    {
        if (!\XLite::isAdminZone() && \XLite\Core\Request::isMobileDevice()) {
            $interface = \XLite::CUSTOMER_INTERFACE;
            $index     = 100;

            $files = array(
                // jQuery Mobile CSS includings
                'lib/jquery.mobile.core.css',
                'lib/jquery.mobile.theme.css',
                'lib/jquery.mobile.theme_f.css',
                // Mobile Core CSS
                'css/main.css',
            );

            // Opera fix
            if (\XLite\Module\XC\Mobile\Core\MobileDetect::getInstance()->detect->isOpera()) {
                $files[] = 'css/main.Opera.css';
            }
        }

        parent::registerCSSResources($files, $index, $interface);
    }

    /**
     * Register JS resources
     *
     * @return void
     */
    protected function registerJSResources($files, $index, $interface)
    {
        if (!\XLite::isAdminZone() && \XLite\Core\Request::isMobileDevice()) {
            $interface = \XLite::CUSTOMER_INTERFACE;
            $index     = 100;

            $files = array(
                // jQuery including
                'lib/jquery.min.js',
                // Mobile library initialization
                'js/core.mobileinit.js',
                // Mobile library including
                'lib/jquery.mobile.js',
                // Mobile Module Core JS
                'js/core.js',
            );

            // Opera fix
            if (\XLite\Module\XC\Mobile\Core\MobileDetect::getInstance()->detect->isOpera()) {
                $files[] = 'js/core.Opera.js';
            }
        }

        parent::registerJSResources($files, $index, $interface);
    }

    /**
     * Via this method the widget registers the meta tags which it uses.
     * During the viewers initialization the meta tags are collecting into the static storage.
     *
     * @return array
     */
    public function getMetaTags()
    {
        return (!\XLite::isAdminZone() && \XLite\Core\Request::isMobileDevice())
            ? array_merge(
                array(
                '<meta name="viewport" content="height=device-height, width=device-width, initial-scale='
                    . \XLite\Core\Request::getInitialScale()
                    . ', minimum-scale=0.25, maximum-scale=2, user-scalable=yes" />' . PHP_EOL,
                '<meta name="apple-mobile-web-app-capable" content="yes" />' . PHP_EOL,
                ),
                parent::getMetaTags()
            )
            : parent::getMetaTags();
    }

    /**
     * Determines if some module is enabled
     *
     * @return boolean
     */
    public function isModuleEnabled($moduleName, $moduleAuthor = 'CDev')
    {
        $module = \XLite\Core\Database::getRepo('XLite\Model\Module')
            ->findOneBy(array('author' => $moduleAuthor, 'name' => $moduleName));
        return $module && $module->getEnabled();
    }

    /**
     * Determines if Catalog "checkout disabled" mode is set
     *
     * @return boolean
     */
    public function isCatalogModeEnabled()
    {
        return $this->isModuleEnabled('Catalog');
    }

    /**
     * Returns Product Comparison data
     *
     * @return string
     */
    public function getComparisonData()
    {
        $data = array(
            'count' => $this->isModuleEnabled('ProductComparison', 'XC')
                ? \XLite\Module\XC\ProductComparison\Core\Data::getInstance()->getProductsCount()
                : 0,
        );
        return json_encode($data);
    }

    /**
     * Obtain pages transition
     *
     * @return string
     */
    public function getMobilePagesTransition()
    {
        return \XLite\Core\Request::getDefaultPagesTransition();
    }

    /**
     * Get cache parameters
     *
     * @return array
     */
    protected function getCacheParameters()
    {
        return array_merge(
            array(
                'is_mobile' => $this->isMobileDevice() ? 'mobile' : 'not-mobile',
            ),
            parent::getCacheParameters()
        );
    }

    /**
     * Detect if the mobile device is used for page view
     *
     * @return boolean
     */
    protected function isMobileDevice()
    {
        return \XLite\Core\Request::isMobileDevice();
    }

    /**
     * Check if the module SocialLogin is avaiable in the store
     *
     * @return boolean
     */
    protected function isSocialLogin()
    {
        return $this->isModuleEnabled('SocialLogin');
    }

    /**
     * Check if the module SocialLogin is avaiable in the store
     *
     * @return boolean
     */
    protected function isContactUs()
    {
        return $this->isModuleEnabled('ContactUs');
    }

    /**
     * Check - current profile is anonymous or not
     * It must be true anonymous customer - with existing profile and anonymous flag
     *
     * @return boolean
     */
    public function isAnonymous()
    {
        $result = parent::isAnonymous();
        return \XLite\Core\Request::isMobileDevice()
            ? ($this->getCart()->getProfile() && $this->getCart()->getProfile()->getAnonymous())
            : $result;
    }

    /**
     * Check - current profile is a new buyer (not registered as any customer type)
     *
     * @return boolean
     */
    public function isNewCustomer()
    {
        return parent::isAnonymous() && !$this->isAnonymous();
    }
}
