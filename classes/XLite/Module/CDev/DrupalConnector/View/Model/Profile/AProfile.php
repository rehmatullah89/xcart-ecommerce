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

namespace XLite\Module\CDev\DrupalConnector\View\Model\Profile;

/**
 * \XLite\Module\CDev\DrupalConnector\View\Model\Profile\AProfile
 */
abstract class AProfile extends \XLite\View\Model\Profile\AProfile implements \XLite\Base\IDecorator
{
    /**
     * Save current form reference and sections list, and initialize the cache
     *
     * @param array $params   Widget params OPTIONAL
     * @param array $sections Sections list OPTIONAL
     *
     * @return void
     */
    public function __construct(array $params = array(), array $sections = array())
    {
        parent::__construct($params, $sections);

        if (\XLite\Module\CDev\DrupalConnector\Handler::getInstance()->checkCurrentCMS()) {
            $this->formFieldNames[] = $this->composeFieldName('cms_profile_id');
            $this->formFieldNames[] = $this->composeFieldName('drupal_roles');
        }
    }

    /**
     * Return current profile ID
     *
     * @return void
     */
    public function getProfileId()
    {
        $result = parent::getProfileId();

        // If current user is admin and 'createNewUser' parameter passed in request...
        if (\XLite\Core\Request::getInstance()->createNewUser && \XLite\Core\Auth::getInstance()->isAdmin()) {

            // ...then profileId for form model object should be null
            $result = null;
        }

        return $result;
    }


    /**
     * Error message - Drupal and LC profiles are not synchronized
     *
     * @return string
     */
    protected function getIncompleteProfileErrorMessage()
    {
        return 'Some of the data on this page cannot be displayed, because your profile'
            . ' is not complete. Please contact admin to report this problem.';
    }

    /**
     * Use the specific message in Drupal
     *
     * @return string
     */
    protected function getAccessDeniedMessage()
    {
        return \XLite\Module\CDev\DrupalConnector\Handler::getInstance()->checkCurrentCMS()
            ? $this->getIncompleteProfileErrorMessage()
            : parent::getAccessDeniedMessage();
    }

    /**
     * getDefaultModelObject
     *
     * @return void
     */
    protected function getDefaultModelObject()
    {
        $cmsProfileId = \XLite\Core\Request::getInstance()->cms_profile_id;

        if (!is_null($cmsProfileId) && \XLite\Module\CDev\DrupalConnector\Handler::getInstance()->checkCurrentCMS()) {

            $obj = \XLite\Core\Database::getRepo('XLite\Model\Profile')
                ->findOneBy(
                    array(
                        'cms_profile_id' => $cmsProfileId,
                        'cms_name' => \XLite\Module\CDev\DrupalConnector\Handler::getInstance()->getCMSName()
                    )
                );
        }

        if (!isset($obj)) {
            $obj = parent::getDefaultModelObject();
        }

        return $obj;
    }

    /**
     * Access denied if user is logged into Drupal but not logged into LC
     *
     * @return boolean
     */
    protected function checkAccess()
    {
        return \XLite\Module\CDev\DrupalConnector\Handler::getInstance()->checkCurrentCMS()
            ? !(user_is_logged_in() && !\XLite\Core\Auth::getInstance()->isLogged())
            : parent::checkAccess();
    }

    /**
     * Do not add additional message when update profile via Drupal interface
     *
     * @return void
     */
    protected function addDataSavedTopMessage()
    {
        if (!\XLite\Module\CDev\DrupalConnector\Handler::getInstance()->checkCurrentCMS()) {
            parent::addDataSavedTopMessage();
        }
    }

    /**
     * Do not add additional message when delete profile via Drupal interface
     *
     * @return void
     */
    protected function addDataDeletedTopMessage()
    {
        if (!\XLite\Module\CDev\DrupalConnector\Handler::getInstance()->checkCurrentCMS()) {
            parent::addDataDeletedTopMessage();
        }
    }
}
