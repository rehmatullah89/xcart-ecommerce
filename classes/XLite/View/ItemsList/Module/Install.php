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

namespace XLite\View\ItemsList\Module;

/**
 * Addons search and installation widget
 */
class Install extends \XLite\View\ItemsList\Module\AModule
{
    /**
     * Sort option name definitions
     */
    const SORT_OPT_POPULAR    = 'm.downloads';
    const SORT_OPT_NEWEST     = 'm.revisionDate';

    /**
     * Price filter options
     */
    const PRICE_FILTER_OPT_ALL  = 'all';
    const PRICE_FILTER_OPT_FREE = \XLite\Model\Repo\Module::PRICE_FREE;
    const TAG_FILTER_OPT_ALL    = 'All';

    /**
     * Widget param names
     */
    const PARAM_TAG          = 'tag';
    const PARAM_PRICE_FILTER = 'priceFilter';

    /**
     * Return list of targets allowed for this widget
     *
     * @return array
     */
    public static function getAllowedTargets()
    {
        $result = parent::getAllowedTargets();
        $result[] = 'addons_list_marketplace';

        return $result;
    }

    /**
     * Register files from common repository
     *
     * @return array
     */
    public function getCommonFiles()
    {
        $list = parent::getCommonFiles();
        $list['js'][] = 'js/ui.selectmenu.js';
        // popup button is using several specific popup JS
        $list['js'][] = 'js/core.popup.js';
        $list['js'][] = 'js/core.popup_button.js';

        $list['css'][] = 'css/ui.selectmenu.css';

        return $list;
    }

    /**
     * Register CSS files
     *
     * @return array
     */
    public function getCSSFiles()
    {
        $list = parent::getCSSFiles();
        $list[] = 'modules_manager/css/common.css';

        // TODO fix with enter-key license widget. It should be taken dynamically from AJAX
        $list[] = 'modules_manager/enter_key/css/style.css';

        // TODO must be taken from LICENSE module widget
        $list[] = 'modules_manager/license/css/style.css';
        $list[] = 'modules_manager/installation_type/css/style.css';

        // TODO must be taken from SwitchButton widget
        $list[] = \XLite\View\Button\SwitchButton::SWITCH_CSS_FILE;

        return $list;
    }

    /**
     * Register JS files. TODO REWORK with Popup button widget
     *
     * @return array
     */
    public function getJSFiles()
    {
        $list = parent::getJSFiles();
        // TODO must be taken from Button/InstallAddon widget
        $list[] = 'button/js/install_addon.js';
        $list[] = 'button/js/select_installation_type.js';
        // TODO must be taken from SwitchButton widget
        $list[] = \XLite\View\Button\SwitchButton::JS_SCRIPT;
        // TODO must be taken from LICENSE module widget
        $list[] = 'modules_manager/license/js/switch-button.js';
        $list[] = $this->getDir() . '/' . $this->getPageBodyDir() . '/js/controller.js';

        return $list;
    }

    /**
     * Return widget default template
     *
     * @return string
     */
    protected function getDefaultTemplate()
    {
        return $this->getDir() . '/' . $this->getPageBodyDir() . '/'
            . ($this->isMarketplaceAccessible() ? 'items_list' : 'marketplace_not_accessible') . '.tpl';
    }

    /**
     * Check if marketplace is accessible
     *
     * The admin is able to access the marketplate if:
     * 1) PHAR is installed on the server (the module packages can be installed to the shop)
     * and
     * 2) The marketplace is online and the cache is up-to-dated
     *
     * @return boolean
     */
    protected function isMarketplaceAccessible()
    {
        return $this->isPHARAvailable()
            && !is_null(\XLite\Core\Marketplace::getInstance()->checkForUpdates());
    }

    /**
     * Check if curl extension is loaded
     *
     * @return boolean
     */
    protected function isCurlAvailable()
    {
        return function_exists('curl_init');
    }

    /**
     * Check if OpenSSL extension is loaded
     *
     * @return boolean
     */
    protected function isOpenSSLAvailable()
    {
        return extension_loaded('openssl');
    }

    /**
     * Check if phar extension is loaded
     *
     * @return boolean
     */
    protected function isPHARAvailable()
    {
        return extension_loaded('phar');
    }

    /**
     * Auxiliary method to check visibility
     *
     * @return boolean
     */
    protected function isDisplayWithEmptyList()
    {
        return true;
    }

    /**
     * Return class name for the list pager
     *
     * @return string
     */
    protected function getPagerClass()
    {
        return $this->isLandingPage()
            ? '\XLite\View\Pager\Admin\Module\InstallLandingPage'
            : '\XLite\View\Pager\Admin\Module\Install';
    }

    /**
     * Return name of the base widgets list
     *
     * @return string
     */
    protected function getListName()
    {
        return parent::getListName() . '.install';
    }

    /**
     * Return dir which contains the page body template
     *
     * @return string
     */
    protected function getPageBodyDir()
    {
        return 'install';
    }

    /**
     * isHeaderVisible
     *
     * @return boolean
     */
    protected function isHeaderVisible()
    {
        return true;
    }

    /**
     * Define widget parameters
     *
     * @return void
     */
    protected function defineWidgetParams()
    {
        parent::defineWidgetParams();

        $this->widgetParams += array(
            static::PARAM_SUBSTRING => new \XLite\Model\WidgetParam\String(
                'Substring', ''
            ),
            static::PARAM_TAG => new \XLite\Model\WidgetParam\String(
                'Tag', ''
            ),
            static::PARAM_PRICE_FILTER => new \XLite\Model\WidgetParam\Set(
                'Price filter', static::PRICE_FILTER_OPT_ALL, false, $this->getPriceFilterOptions()
            ),
        );
    }

    /**
     * Define so called "request" parameters
     *
     * @return void
     */
    protected function defineRequestParams()
    {
        parent::defineRequestParams();

        $this->requestParams[] = static::PARAM_PRICE_FILTER;
        $this->requestParams[] = static::PARAM_SUBSTRING;
        $this->requestParams[] = static::PARAM_TAG;
    }

    /**
     * Return list of sort options
     *
     * @return array
     */
    protected function getSortOptions()
    {
        return array_merge(
            array(
                static::SORT_OPT_POPULAR => 'Most Popular',
                static::SORT_OPT_NEWEST  => 'Newest',
            ),
            parent::getSortOptions()
        );
    }

    /**
     * Return list of sort options for selector
     *
     * @return array
     */
    protected function getSortOptionsForSelector()
    {
        $result = array();
        $substring = $this->getParam(static::PARAM_SUBSTRING);

        foreach ($this->getSortOptions() as $value => $name) {
            $url = $this->buildURL(
                'addons_list_marketplace',
                '',
                array(
                    \XLite\View\Pager\Admin\Module\AModule::PARAM_CLEAR_PAGER => 1,
                    static::PARAM_SORT_BY   => $value,
                    static::PARAM_SUBSTRING => $substring,
                )
            );
            $result[$url] = $name;
        }

        return $result;
    }

    /**
     * Get current sort option value for selector
     *
     * @return string
     */
    protected function getSortOptionsValueForSelector()
    {
        return $this->buildURL(
            'addons_list_marketplace',
            '',
            array(
                \XLite\View\Pager\Admin\Module\AModule::PARAM_CLEAR_PAGER => 1,
                static::PARAM_SORT_BY => $this->getSortBy(),
                static::PARAM_SUBSTRING => $this->getParam(static::PARAM_SUBSTRING),
            )
        );
    }

    /**
     * Return list of price filter options
     *
     * @return array
     */
    protected function getPriceFilterOptions()
    {
        return array(
            self::PRICE_FILTER_OPT_ALL  => 'All add-ons',
            self::PRICE_FILTER_OPT_FREE => 'Free add-ons',
        );
    }

    /**
     * Return list of price filter options for selector
     *
     * @return array
     */
    protected function getPriceFilterOptionsForSelector()
    {
        $result = array();
        foreach ($this->getPriceFilterOptions() as $value => $name) {
            $result[$this->getActionURL(array(
                static::PARAM_PRICE_FILTER => $value,
                \XLite\View\Pager\Admin\Module\AModule::PARAM_CLEAR_PAGER => 1,
            ))] = $name;
        }

        return $result;
    }

    /**
     * Get price filter option value for selector
     *
     * @return string
     */
    protected function getPriceFilterOptionsValueForSelector()
    {
        return $this->getActionURL(array(
            static::PARAM_PRICE_FILTER => $this->getParam(self::PARAM_PRICE_FILTER),
            \XLite\View\Pager\Admin\Module\AModule::PARAM_CLEAR_PAGER => 1,
        ));
    }

    /**
     * Return list of tag options
     *
     * @return array
     */
    protected function getTagOptions()
    {
        return array_merge(
            array(static::TAG_FILTER_OPT_ALL => ''),
            $this->getTags()
        );
    }

    /**
     * Return list of tag options for selector
     *
     * @return array
     */
    protected function getTagOptionsForSelector()
    {
        $result = array();
        foreach ($this->getTagOptions() as $name => $value) {
            $result[$this->getActionURL(array(
                static::PARAM_TAG => $value,
                \XLite\View\Pager\Admin\Module\AModule::PARAM_CLEAR_PAGER => 1,
            ))] = $name;
        }

        return $result;
    }

    /**
     * Get tag option value for selector
     *
     * @return string
     */
    protected function getTagOptionsValueForSelector()
    {
        return $this->getActionURL(array(
            static::PARAM_TAG => $this->getParam(static::PARAM_TAG),
            \XLite\View\Pager\Admin\Module\AModule::PARAM_CLEAR_PAGER => 1,
        ));
    }

    /**
     * Return params list to use for search
     *
     * @return \XLite\Core\CommonCell
     */
    protected function getSearchCondition()
    {
        if ($this->isLandingPage()) {
            $cnd = new \XLite\Core\CommonCell();
            $cnd->{\XLite\Model\Repo\Module::P_IS_LANDING}   = true;
        } else {
            $cnd = parent::getSearchCondition();
            $cnd->{\XLite\Model\Repo\Module::P_FROM_MARKETPLACE} = true;
            $cnd->{\XLite\Model\Repo\Module::P_ISSYSTEM}         = false;

            if (!isset(\XLite\Core\Request::getInstance()->clearCnd)) {
                $cnd->{\XLite\Model\Repo\Module::P_PRICE_FILTER}     = $this->getParam(static::PARAM_PRICE_FILTER);
                $cnd->{\XLite\Model\Repo\Module::P_SUBSTRING}        = $this->getParam(static::PARAM_SUBSTRING);
                $tag = $this->getParam(static::PARAM_TAG);
                if ($tag) {
                    $cnd->{\XLite\Model\Repo\Module::P_TAG}          = $tag;
                }
            }
        }
        return $cnd;
    }

    /**
     * Flag if the addon filters box is visible
     *
     * @return boolean
     */
    protected function isVisibleAddonFilters()
    {
        return !$this->isLandingPage();
    }

    /**
     * Return warning message. Description of Marketplace unavailability
     *
     * @return string
     */
    protected function getWarningMessage()
    {
        $message = 'No Phar extension for PHP error';
        $params = array();

        if ($this->isPHARAvailable()) {
            $message = 'No Curl extension for PHP error';
            if ($this->isCurlAvailable()) {
                $message = 'No OpenSSL extension for PHP error';
                if ($this->isOpenSSLAvailable()) {
                    switch (\XLite\Core\Session::getInstance()->getCURLError()) {
                        case CURLE_SSL_CONNECT_ERROR:
                        case CURLE_SSL_ENGINE_NOTFOUND:
                        case CURLE_SSL_ENGINE_SETFAILED:
                        case CURLE_SSL_CERTPROBLEM:
                        case CURLE_SSL_CIPHER:
                        case CURLE_SSL_CACERT:
                        case CURLE_SSL_ENGINE_INITFAILED:
                        case CURLE_SSL_CACERT_BADFILE:
                        case CURLE_SSL_SHUTDOWN_FAILED:
                        case CURLE_SSL_ISSUER_ERROR:
                            $message = 'SSL Error';
                            break;

                        case '':
                            $message = 'Timeout error';
                            break;

                        default:
                            $message = 'cURL error';
                            $params['error code']    = \XLite\Core\Session::getInstance()->getCURLError();
                            $params['error message'] = \XLite\Core\Session::getInstance()->getCURLErrorMessage();
                    }
                }
            }
        }

        return static::t($message, $params);
    }

    // {{{ Helpers to use in templates

    /**
     * Check if the module is installed
     *
     * @param \XLite\Model\Module $module Module
     *
     * @return boolean
     */
    protected function isInstalled(\XLite\Model\Module $module)
    {
        return $module->isInstalled();
    }

    /**
     * Module page URL getter
     *
     * @param \XLite\Model\Module $module Module
     *
     * @return string
     */
    protected function getModulePageURL(\XLite\Model\Module $module)
    {
        $params = array('clearCnd' => 1);
        $limit = \XLite\View\Pager\Admin\Module\Manage::getInstance()->getItemsPerPage();
        $pageId = \XLite\Core\Database::getRepo('XLite\Model\Module')->getModulePageId($module->getAuthor(), $module->getName(), $limit);
        if (0 < $pageId) {
            $params['page'] = $pageId;
        }
        return $this->buildURL('addons_list_installed', '', $params) . '#' . $module->getName();
    }

    /**
     * Check if the module is free
     *
     * @param \XLite\Model\Module $module Module
     *
     * @return boolean
     */
    protected function isFree(\XLite\Model\Module $module)
    {
        return !$this->isInstalled($module) && $module->isFree();
    }

    /**
     * Check if the module is purchased
     *
     * @param \XLite\Model\Module $module Module
     *
     * @return boolean
     */
    protected function isPurchased(\XLite\Model\Module $module)
    {
        return !$this->isInstalled($module) && !$this->isFree($module) && $module->isPurchased();
    }

    /**
     * Check if there are some errors for the current module
     *
     * @param \XLite\Model\Module $module Module to check
     *
     * @return boolean
     */
    protected function hasErrors(\XLite\Model\Module $module)
    {
        return !$this->isInstalled($module) && parent::hasErrors($module);
    }

    /**
     * Check if the XC module notice must be displayed.
     * The notice is displayed when the module is a part of X-Cart 5 license
     * and current X-Cart 5 license type of core differs from X-Cart 5 license type of module.
     *
     * @param \XLite\Model\Module $module Module entity
     *
     * @return boolean
     */
    protected function showXCNModuleNotice(\XLite\Model\Module $module)
    {
        return $this->isXCN($module) && !$this->isInstalled($module) && 1 < $module->getEditionState();
    }

    protected function getEditions(\XLite\Model\Module $module)
    {
        return $module->getEditions() ? implode(', ', $module->getEditions()) : '';
    }

    /**
     * Check if the price should be visible for module.
     * No price for X-Cart 5 module or already installed from marketplace
     *
     * @param \XLite\Model\Module $module
     *
     * @return boolean
     */
    protected function showPrice(\XLite\Model\Module $module)
    {
        return !($this->isInstalled($module) || $this->isXCN($module));
    }

    /**
     * Check if the module is part of X-Cart 5 license
     *
     * @param \XLite\View\ItemsList\Module\XLite\Model\Module $module Module entity
     *
     * @return boolean
     */
    protected function isXCN(\XLite\Model\Module $module)
    {
        return $module->isAvailable() && \XLite\Model\Module::NOT_XCN_MODULE < intval($module->getXcnPlan());
    }

    /**
     * Check if notice 'Module is available for X-Cart hosted stores only' should be displayed
     *
     * @param \XLite\View\ItemsList\Module\XLite\Model\Module $module Module entity
     *
     * @return boolean
     */
    protected function showNotAvailModuleNotice(\XLite\Model\Module $module)
    {
        return \XLite\Model\Module::NOT_AVAILABLE_MODULE == intval($module->getXcnPlan());
    }

    /**
     * Check if the module can be enabled
     *
     * @param \XLite\Model\Module $module Module
     *
     * @return boolean
     */
    protected function canEnable(\XLite\Model\Module $module)
    {
        return parent::canEnable($module) && !$this->isInstalled($module);
    }

    /**
     * Check if the module can be installed
     *
     * @param \XLite\Model\Module $module Module
     *
     * @return boolean
     */
    protected function canInstall(\XLite\Model\Module $module)
    {
        return $this->canEnable($module)
            && $this->canAccess($module)
            && $module->getFromMarketplace()
            && $this->isLicenseAllowed($module);
    }

    /**
     * Check if module license is available and allowed
     *
     * @param \XLite\Model\Module $module Module
     *
     * @return boolean
     */
    protected function isLicenseAllowed(\XLite\Model\Module $module)
    {
        return \XLite\Model\Module::NOT_XCN_MODULE == $module->getXcnPlan()
            || (\XLite\Model\Module::NOT_XCN_MODULE < $module->getXcnPlan() && 1 == $module->getEditionState());
    }

    /**
     * Check if the module can be purchased.
     * X-Cart 5 modules could not be purchased. Just X-Cart 5 license.
     *
     * @param \XLite\Model\Module $module Module
     *
     * @return boolean
     */
    protected function canPurchase(\XLite\Model\Module $module)
    {
        return !$this->isInstalled($module)
            && !$this->canAccess($module)
            && !$this->isXCN($module)
            && !$this->isModuleUpgradeNeeded($module);
    }

    /**
     * Check if module is accessible for installation
     * It must be already purchased or be free
     *
     * @param \XLite\Model\Module $module Module
     *
     * @return boolean
     */
    protected function canAccess(\XLite\Model\Module $module)
    {
        return $this->isPurchased($module) || $this->isFree($module);
    }

    /**
     * Get CSS classes for module cell
     *
     * @param \XLite\Model\Module $module Module
     *
     * @return string
     */
    protected function getModuleClassesCSS(\XLite\Model\Module $module)
    {
        $classes = sprintf('module-%d', $module->getModuleId());

        if ($this->showNotAvailModuleNotice($module)) {
            $classes .= ' not-available';
        }

        if (!$this->isEnabled($module)) {
            $classes .= ' disabled';
        }

        return $classes;
    }

    /**
     * Check if module is accessible for purchase and installation
     *
     * @return string
     */
    protected function getMoreInfoURL()
    {
        return 'https://my.x-cart.com';
    }

    /**
     * Check module license and return true if it's non-empty
     *
     * @param \XLite\Model\Module $module Module
     *
     * @return boolean
     */
    protected function hasNonEmptyLicense(\XLite\Model\Module $module)
    {
        return $module->getHasLicense();
    }

    // }}}

    // {{{ Methods to search modules of certain types

    /**
     * Check if core requires new (but the same as core major) version of module
     *
     * @param \XLite\Model\Module $module Module to check
     *
     * @return boolean
     */
    protected function isModuleUpdateAvailable(\XLite\Model\Module $module)
    {
        $installed = $this->getModuleInstalled($module);

        return $installed
            && version_compare($installed->getMajorVersion(), $module->getMajorVersion(), '=')
            && version_compare($installed->getMinorVersion(), $module->getMinorVersion(), '<');
    }

    /**
     * URL of the page where license can be purchased
     *
     * @return string
     */
    protected function getPurchaseURL()
    {
        return \XLite\Core\Marketplace::getPurchaseURL();
    }

    // }}}
}
