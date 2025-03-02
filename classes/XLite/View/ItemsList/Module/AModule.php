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
 * Abstract product list
 */
abstract class AModule extends \XLite\View\ItemsList\AItemsList
{
    /**
     * Widget param names
     */
    const PARAM_SUBSTRING    = 'substring';

    /**
     * Sort option name definitions
     */
    const SORT_OPT_ALPHA = 'm.moduleName';

    /**
     * High popularity level
     */
    const MAX_POPULAR_LEVEL = 0.4;

    /**
     * Cache value for maximum popularity level
     *
     * @var float
     */
    protected $maximumPopularity;

    /**
     * List of core versions to update
     *
     * @var array
     */
    protected $coreVersions;

    /**
     * Check if the module is installed
     *
     * @param \XLite\Model\Module $module Module to check
     *
     * @return boolean
     */
    abstract protected function isInstalled(\XLite\Model\Module $module);

    /**
     * Define and set widget attributes; initialize widget
     *
     * @param array $params Widget params OPTIONAL
     *
     * @return void
     */
    public function __construct(array $params = array())
    {
        $this->sortByModes += $this->getSortOptions();

        parent::__construct($params);
    }

    /**
     * getSortByModeDefault
     *
     * @return string
     */
    protected function getSortByModeDefault()
    {
        return self::SORT_OPT_ALPHA;
    }

    /**
     * getSortOrder
     *
     * @return string
     */
    protected function getSortOrder()
    {
        return self::SORT_OPT_ALPHA === $this->getSortBy() ? self::SORT_ORDER_ASC : self::SORT_ORDER_DESC;
    }

    /**
     * Return list of sort options
     *
     * @return array
     */
    protected function getSortOptions()
    {
        return array(
            static::SORT_OPT_ALPHA => 'Alphabetically',
        );
    }

    /**
     * Return params list to use for search
     *
     * @return \XLite\Core\CommonCell
     */
    protected function getSearchCondition()
    {
        $cnd = parent::getSearchCondition();
        $cnd->{\XLite\Model\Repo\Module::P_ORDER_BY} = array($this->getSortBy(), $this->getSortOrder());
        return $cnd;
    }

    /**
     * Return name of the base widgets list
     *
     * @return string
     */
    protected function getListName()
    {
        return parent::getListName() . '.module';
    }

    /**
     * Get widget templates directory
     *
     * @return string
     */
    protected function getDir()
    {
        return parent::getDir() . '/module';
    }

    /**
     * Return "empty list" catalog
     *
     * @return string
     */
    protected function getEmptyListDir()
    {
        return $this->getDir() . '/' . $this->getPageBodyDir();
    }

    /**
     * Return dir which contains the page body template
     *
     * @return string
     */
    protected function getPageBodyDir()
    {
        return null;
    }

    /**
     * getJSHandlerClassName
     *
     * @return string
     */
    protected function getJSHandlerClassName()
    {
        return 'ModulesList';
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
        return !$this->canEnable($module);
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
        $result = $this->isModuleCompatible($module);

        if ($result) {
            $dependencies = $module->getDependencies();

            if ($dependencies) {
                $modules = array_keys(\Includes\Utils\ModulesManager::getActiveModules());
                $result  = ! (bool) array_diff($dependencies, $modules);
            }
        }

        if ($result) {
            $result = !$this->hasWrongDependencies($module);
        }

        return $result;
    }

    /**
     * Check if the module can be disabled
     *
     * @param \XLite\Model\Module $module Module
     *
     * @return boolean
     */
    protected function canDisable(\XLite\Model\Module $module)
    {
        return ! (bool) $module->getDependentModules();
    }

    /**
     * Check if the module is enabled
     *
     * @param \XLite\Model\Module $module Module
     *
     * @return boolean
     */
    protected function isEnabled(\XLite\Model\Module $module)
    {
        $installed = $this->getModuleInstalled($module);

        return isset($installed) && $installed->getEnabled();
    }

    /**
     * Return modules list
     *
     * @param \XLite\Core\CommonCell $cnd       Search condition
     * @param boolean                $countOnly Return items list or only its size OPTIONAL
     *
     * @return array|integer
     */
    protected function getData(\XLite\Core\CommonCell $cnd, $countOnly = false)
    {
        $result = \XLite\Core\Database::getRepo('\XLite\Model\Module')->search($cnd, $countOnly);

        if (is_array($result)) {
            foreach ($result as $k => $module) {
                if ($module->callModuleMethod('isSystem')) {
                    unset($result[$k]);
                }
            }
        }

        return $result;
    }

    // {{{ Version-related checks

    /**
     * Check if the module major version is the same as the core one.
     * Alias
     *
     * @param \XLite\Model\Module $module Module to check
     *
     * @return void
     */
    protected function isModuleCompatible(\XLite\Model\Module $module)
    {
        return $this->checkModuleMajorVersion($module, '=')
            && $this->checkModuleMinorVersion($module, '>=');
    }

    /**
     * Check if module requires new core version.
     * Alias
     *
     * @param \XLite\Model\Module $module Module to check
     *
     * @return boolean
     */
    protected function isCoreUpgradeNeeded(\XLite\Model\Module $module)
    {
        return $this->checkModuleMajorVersion($module, '<')
            || (
                $module->getMinorRequiredCoreVersion() !== 0
                && $this->checkModuleMinorVersion($module, '<')
            );
    }

    /**
     * Get core version needed for the module
     *
     * @param \XLite\Model\Module $module Module to check
     *
     * @return string
     */
    protected function getNeededCoreVersion(\XLite\Model\Module $module)
    {
        $majorVer = $this->checkModuleMajorVersion($module, '<')
            ? $module->getMajorVersion()
            : \XLite::getInstance()->getMajorVersion();

        $minorVer = $module->getMinorRequiredCoreVersion() !== 0 && $this->checkModuleMinorVersion($module, '<')
            ? $module->getMinorRequiredCoreVersion()
            : \XLite::getInstance()->getMinorVersion();

        return $majorVer . '.' . $minorVer;
    }

    /**
     * Check if core requires new module version.
     * Alias
     *
     * @param \XLite\Model\Module $module Module to check
     *
     * @return boolean
     */
    protected function isModuleUpgradeNeeded(\XLite\Model\Module $module)
    {
        return $this->checkModuleMajorVersion($module, '>');
    }

    /**
     * Compare module version with the core one
     *
     * @param \XLite\Model\Module $module   Module to check
     * @param string              $operator Comparison operator
     *
     * @return boolean
     */
    protected function checkModuleMajorVersion(\XLite\Model\Module $module, $operator)
    {
        return \XLite::getInstance()->checkVersion($module->getMajorVersion(), $operator);
    }

    /**
     * Compare module version with the core one
     *
     * @param \XLite\Model\Module $module   Module to check
     * @param string              $operator Comparison operator
     *
     * @return boolean
     */
    protected function checkModuleMinorVersion(\XLite\Model\Module $module, $operator)
    {
        return \XLite::getInstance()->checkMinorVersion($module->getMinorRequiredCoreVersion(), $operator);
    }

    /**
     * Return list of modules current module depends on
     *
     * @param \XLite\Model\Module $module Current module
     *
     * @return array
     */
    protected function getDependencyModules(\XLite\Model\Module $module)
    {
        return $module->getDependencyModules(true);
    }

    /**
     * Return list of modules current module requires to be disabled
     *
     * @param \XLite\Model\Module $module Current module
     *
     * @return array
     */
    protected function getEnabledMutualModules(\XLite\Model\Module $module)
    {
        $list = array();

        $modules = \Includes\Utils\ModulesManager::getActiveModules();

        foreach ($modules as $m => $data) {

            $mutualModules = \Includes\Utils\ModulesManager::callModuleMethod($m, 'getMutualModulesList');

            if (in_array($module->getActualName(), $mutualModules) && !isset($list[$m])) {
                $list[$m] = \XLite\Core\Database::getRepo('XLite\Model\Module')
                    ->findOneBy(array_combine(array('author', 'name'), explode('\\', $m)));
            }
        }

        return $list;
    }

    /**
     * Check if there are modules current module depends on
     *
     * @param \XLite\Model\Module $module Current module
     *
     * @return array
     */
    protected function hasWrongDependencies(\XLite\Model\Module $module)
    {
        return ((bool) $this->getDependencyModules($module)) || ((bool) $this->getEnabledMutualModules($module));
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
    abstract protected function isModuleUpdateAvailable(\XLite\Model\Module $module);

    /**
     * Return list of core versions for update
     *
     * @return array
     */
    protected function getCoreVersions()
    {
        if (!isset($this->coreVersions)) {
            $this->coreVersions = (array) \XLite\Core\Marketplace::getInstance()->getCores();
        }

        return $this->coreVersions;
    }

    /**
     * Is core upgrade available
     *
     * @param string $majorVersion core version to check
     *
     * @return void
     */
    protected function isCoreUpgradeAvailable($majorVersion)
    {
        return (bool) \Includes\Utils\ArrayManager::getIndex($this->getCoreVersions(), $majorVersion, true);
    }

    /**
     * Search for module for update. Alias
     *
     * @param \XLite\Model\Module $module Current module
     *
     * @return \XLite\Model\Module
     */
    protected function getModuleForUpdate(\XLite\Model\Module $module)
    {
        return $module->getRepository()->getModuleForUpdate($module);
    }

    /**
     * Search for module from marketplace. Alias
     *
     * @param \XLite\Model\Module $module Current module
     *
     * @return \XLite\Model\Module
     */
    protected function getModuleFromMarketplace(\XLite\Model\Module $module)
    {
        return $module->getRepository()->getModuleFromMarketplace($module);
    }

    /**
     * Search for installed module
     *
     * @param \XLite\Model\Module $module Current module
     *
     * @return \XLite\Model\Module
     */
    protected function getModuleInstalled(\XLite\Model\Module $module)
    {
        return $module->getRepository()->getModuleInstalled($module);
    }

    /**
     * Get module version. Alias
     *
     * @param \XLite\Model\Module $module Current module
     *
     * @return string
     */
    protected function getModuleVersion(\XLite\Model\Module $module)
    {
        return $module->getVersion();
    }

    /**
     * Get current tag
     *
     * @return string
     */
    protected function getTag()
    {
        $tag = \XLite\Core\Request::getInstance()->tag;

        if (empty($tag) || !in_array($tag, array_keys($this->getTags()))) {
            $tag = '';
        }

        return $tag;
    }

    /**
     * Return tags array
     *
     * @return array
     */
    protected function getTags()
    {
        return \XLite\Core\Marketplace::getInstance()->getAllTags();
    }

    // }}}

    // {{{ Dependency statuses

    /**
     * Get all data to dependency item in list
     *
     * @param \XLite\Model\Module $module Current module
     *
     * @return array
     */
    protected function getDependencyData(\XLite\Model\Module $module)
    {
        if ($module->isPersistent()) {
            if ($module->getInstalled()) {
                if ($module->getEnabled()) {
                    $result = array('status' => 'enabled', 'class' => 'good');

                } else {
                    $result = array('status' => 'disabled', 'class' => 'none');
                }

                $result['href'] = $this->buildURL('addons_list_installed') . '#' . $module->getName();

            } else {
                $url  = $this->buildURL('addons_list_marketplace', '', array('substring' => $module->getModuleName()));
                $url .= '#' . $module->getName();

                $result = array('href' => $url, 'status' => 'not installed', 'class' => 'none');
            }

        } else {
            $result = array('status' => 'unknown', 'class' => 'poor');
        }

        return $result;
    }

    /**
     * Get some data for depenendecy in list
     *
     * @param \XLite\Model\Module $module Current module
     *
     * @return string
     */
    protected function getDependencyHRef(\XLite\Model\Module $module)
    {
        return \Includes\Utils\ArrayManager::getIndex($this->getDependencyData($module), 'href', true);
    }

    /**
     * Get some data for depenendecy in list
     *
     * @param \XLite\Model\Module $module Current module
     *
     * @return string
     */
    protected function getDependencyStatus(\XLite\Model\Module $module)
    {
        return \Includes\Utils\ArrayManager::getIndex($this->getDependencyData($module), 'status', true);
    }

    /**
     * Get some data for depenendecy in list
     *
     * @param \XLite\Model\Module $module Current module
     *
     * @return string
     */
    protected function getDependencyCSSClass(\XLite\Model\Module $module)
    {
        return \Includes\Utils\ArrayManager::getIndex($this->getDependencyData($module), 'class', true);
    }

    // }}}

    /**
     * Get search substring value
     *
     * @return string
     */
    protected function getSearchSubstring()
    {
        return \XLite\Core\Request::getInstance()->substring;
    }

    /**
     * Returns the maximum popularity counter (uses the cache class variable)
     *
     * @return integer
     */
    protected function getMaximumPopularity()
    {
        if (!isset($this->maximumPopularity)) {
            $this->maximumPopularity = \XLite\Core\Database::getRepo('XLite\Model\Module')->getMaximumDownloads();
        }

        return $this->maximumPopularity;
    }

    /**
     * Defines specific downloads CSS class if necessary
     *
     * @param \XLite\Model\Module $module
     *
     * @return string
     */
    protected function getDownloadsCSSClass(\XLite\Model\Module $module)
    {
        return (($module->getDownloads() / $this->getMaximumPopularity()) >= static::MAX_POPULAR_LEVEL)
            ? ' high-popular'
            : '';
    }
}
