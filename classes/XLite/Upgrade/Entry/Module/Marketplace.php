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

namespace XLite\Upgrade\Entry\Module;

/**
 * Marketplace
 */
class Marketplace extends \XLite\Upgrade\Entry\Module\AModule
{
    /**
     * Identifier for installed module
     *
     * @var array
     */
    protected $moduleInfoInstalled;

    /**
     * Identifier for upgrade module
     *
     * @var array
     */
    protected $moduleInfoForUpgrade;

    /**
     * Old major version (cache)
     *
     * :WARNING: do not remove this variable:
     * it's required for the proper upgrade process
     *
     * @var string
     */
    protected $majorVersionOld;

    /**
     * Old minor version (cache)
     *
     * :WARNING: do not remove this variable:
     * it's required for the proper upgrade process
     *
     * @var string
     */
    protected $minorVersionOld;

    /**
     * Return module actual name
     *
     * @return string
     */
    public function getActualName()
    {
        return $this->getModuleInstalled()->getActualName();
    }

    /**
     * Return entry readable name
     *
     * @return string
     */
    public function getName()
    {
        return $this->getModuleForUpgrade()->getModuleName();
    }

    /**
     * Return icon URL
     *
     * @return string
     */
    public function getIconURL()
    {
        return $this->getModuleForUpgrade()->getIconURL();
    }

    /**
     * Return entry old major version
     *
     * @return string
     */
    public function getMajorVersionOld()
    {
        if (!isset($this->majorVersionOld)) {
            $this->majorVersionOld = $this->getModuleInstalled()->getMajorVersion();
        }

        return $this->majorVersionOld;
    }

    /**
     * Return entry old minor version
     *
     * @return string
     */
    public function getMinorVersionOld()
    {
        if (!isset($this->minorVersionOld)) {
            $this->minorVersionOld = $this->getModuleInstalled()->getMinorVersion();
        }

        return $this->minorVersionOld;
    }

    /**
     * Return entry new major version
     *
     * @return string
     */
    public function getMajorVersionNew()
    {
        return $this->getModuleForUpgrade()->getMajorVersion();
    }

    /**
     * Return entry new minor version
     *
     * @return string
     */
    public function getMinorVersionNew()
    {
        return $this->getModuleForUpgrade()->getMinorVersion();
    }

    /**
     * Return entry revision date
     *
     * @return integer
     */
    public function getRevisionDate()
    {
        $this->getModuleForUpgrade()->getRevisionDate();
    }

    /**
     * Return module author readable name
     *
     * @return string
     */
    public function getAuthor()
    {
        return $this->getModuleForUpgrade()->getAuthorName();
    }

    /**
     * Check if module is enabled
     *
     * @return boolean
     */
    public function isEnabled()
    {
        return (bool) $this->getModuleInstalled()->getEnabled();
    }

    /**
     * Check if module is installed
     *
     * @return boolean
     */
    public function isInstalled()
    {
        return (bool) $this->getModuleInstalled()->getInstalled();
    }

    /**
     * Return entry pack size
     *
     * @return integer
     */
    public function getPackSize()
    {
        return $this->getModuleForUpgrade()->getPackSize();
    }

    /**
     * Do specific directory preparations after unpacking
     * Actually we add the disabled module with the active upgrade helpers (post_rebuild, pre_upgrade, post_upgrade)
     * into a special module list which will be either enabled or uninstall before the upgrade process
     *
     * @param string $dir
     *
     * @return void
     */
    protected function prepareUnpackDir($dir)
    {
        if (
            !$this->isEnabled()
            && $this->hasUpgradeHelpers()
        ) {
            \XLite\Upgrade\Cell::getInstance()->addDisabledModulesHook($this->getModuleForUpgrade()->getMarketplaceID());
        }
    }

    /**
     * Defines the helpers types to check
     *
     * @return array
     */
    protected function getHelpersToCheck()
    {
        return array(
            'post_rebuild',
            'pre_upgrade',
            'post_upgrade',
        );
    }

    /**
     * Checks if the module has any defined upgrade helpers
     *
     * @return boolean
     */
    protected function hasUpgradeHelpers()
    {
        $result = false;
        foreach ($this->getHelpersToCheck() as $type) {
            $helpers = $this->getHelpers($type);

            $result = $result || !empty($helpers);
        }

        return $result;
    }

    /**
     * Download hashes for current version
     *
     * @return array
     */
    protected function loadHashesForInstalledFiles()
    {
        $licenseKey = $this->getModuleForUpgrade()->getLicenseKey();

        return \XLite\Core\Marketplace::getInstance()->getAddonHash(
            $this->getModuleInstalled()->getMarketplaceID(),
            $licenseKey ? $licenseKey->getKeyValue() : null
        );
    }

    /**
     * Constructor
     *
     * @param \XLite\Model\Module $moduleInstalled  Module model object
     * @param \XLite\Model\Module $moduleForUpgrade Module model object
     *
     * @return void
     */
    public function __construct(\XLite\Model\Module $moduleInstalled, \XLite\Model\Module $moduleForUpgrade)
    {
        $this->moduleInfoInstalled  = $this->getPreparedModuleInfo($moduleInstalled, false);
        $this->moduleInfoForUpgrade = $this->getPreparedModuleInfo($moduleForUpgrade, true);

        if (is_null($this->getModuleInstalled())) {
            \Includes\ErrorHandler::fireError(
                'Module ["' . implode('", "', $this->moduleInfoInstalled) . '"] is not found in DB'
            );
        }

        if (is_null($this->getModuleForUpgrade())) {
            \Includes\ErrorHandler::fireError(
                'Module ["' . implode('", "', $this->moduleInfoForUpgrade) . '"] is not found in DB'
                . ' or is not a marketplace module'
            );
        }

        parent::__construct();
    }

    /**
     * Names of variables to serialize
     *
     * @return array
     */
    public function __sleep()
    {
        $list = parent::__sleep();
        $list[] = 'moduleInfoInstalled';
        $list[] = 'moduleInfoForUpgrade';

        return $list;
    }

    /**
     * Download package
     *
     * @return boolean
     */
    public function download()
    {
        $result = false;
        $licenseKey = $this->getModuleForUpgrade()->getLicenseKey();

        $path = \XLite\Core\Marketplace::getInstance()->getAddonPack(
            $this->getModuleForUpgrade()->getMarketplaceID(),
            $licenseKey ? $licenseKey->getKeyValue() : null
        );

        $params = array('name' => $this->getActualName());

        if (isset($path)) {
            $this->addFileInfoMessage('Module pack ("{{name}}") is received', $path, true, $params);

            $this->setRepositoryPath($path);
            $this->saveHashesForInstalledFiles();

            $result = parent::download();

        } else {
            $this->addFileErrorMessage(
                'Module pack ("{{name}}") is not received',
                \XLite\Core\Marketplace::getInstance()->getError(),
                true,
                $params
            );
        }

        return $result;
    }

    /**
     * Prepare and return module identity data
     *
     * @param \XLite\Model\Module $module          Module to get info
     * @param boolean             $fromMarketplace Flag
     *
     * @return array
     */
    protected function getPreparedModuleInfo(\XLite\Model\Module $module, $fromMarketplace)
    {
        // :WARNING: do not change the summands order:
        // it's important for the "updateDBRecords()" method
        return array('fromMarketplace' => $fromMarketplace) + $module->getIdentityData();
    }

    /**
     * Search for module in DB
     *
     * @param array $moduleInfo Info to search by
     *
     * @return \XLite\Model\Module
     */
    protected function getModule(array $moduleInfo)
    {
        return \XLite\Core\Database::getRepo('\XLite\Model\Module')->findOneBy($moduleInfo);
    }

    /**
     * Alias
     *
     * :WARNING: do not cache this object: identity info may be changed
     *
     * @return \XLite\Model\Module
     */
    protected function getModuleInstalled()
    {
        return $this->getModule($this->moduleInfoInstalled) ?: $this->getModuleForUpgrade();
    }

    /**
     * Alias
     *
     * :WARNING: do not cache this object: identity info may be changed
     *
     * @return \XLite\Model\Module
     */
    protected function getModuleForUpgrade()
    {
        return $this->getModule($this->moduleInfoForUpgrade);
    }

    /**
     * Update database records
     *
     * @return array
     */
    protected function updateDBRecords()
    {
        $forUpgrade = $this->getModuleForUpgrade();
        $installed  = $this->getModuleInstalled();

        if ($forUpgrade->getIdentityData() !== $installed->getIdentityData()) {

            $forUpgrade->setEnabled($installed->getEnabled());
            $forUpgrade->setYamlLoaded($installed->getYamlLoaded());

            \XLite\Core\Database::getRepo('\XLite\Model\Module')->delete($installed);

            $this->moduleInfoInstalled = $this->getPreparedModuleInfo($forUpgrade, false);

        } else {
            $forUpgrade->setEnabled(true);
        }

        $forUpgrade->setInstalled(true);
        $forUpgrade->setFromMarketplace(false);
        $this->moduleInfoForUpgrade['fromMarketplace'] = false;

        \XLite\Core\Database::getRepo('\XLite\Model\Module')->update($forUpgrade);
    }
}
