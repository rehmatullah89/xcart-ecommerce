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

/**
 * Return LC controller title
 *
 * @param string $staticTitle Static title OPTIONAL
 *
 * @return string
 */
function lcConnectorGetControllerTitle($staticTitle = null)
{
    return $staticTitle
        ? \XLite\Core\Translation::lbl($staticTitle)
        : \XLite\Module\CDev\DrupalConnector\Drupal\Controller::getInstance()->getTitle();
}

/**
 * Return LC controller page content
 *
 * @return string
 */
function lcConnectorGetControllerContent()
{
    return \XLite\Module\CDev\DrupalConnector\Drupal\Controller::getInstance()->getContent();
}

/**
 * Validate widget details form
 *
 * @param array &$form      Form description
 * @param array &$formState Form state
 *
 * @return void
 */
function lcConnectorValidateWidgetModifyForm(array &$form, array &$formState)
{
    return \XLite\Module\CDev\DrupalConnector\Drupal\Admin::getInstance()->validateWidgetModifyForm(
        $form,
        $formState
    );
}

/**
 * Submit widget details form
 *
 * @param array &$form       Form description
 * @param array &$form_state Form state
 *
 * @return void
 */
function lcConnectorSubmitWidgetModifyForm(array &$form, array &$formState)
{
    return \XLite\Module\CDev\DrupalConnector\Drupal\Admin::getInstance()->submitWidgetModifyForm(
        $form,
        $formState
    );
}

/**
 * Submit widget delete confirmation form
 *
 * @param array &$form       Form description
 * @param array &$form_state Form state
 *
 * @return void
 */
function lcConnectorSubmitWidgetDeleteForm(array &$form, array &$formState)
{
    return \XLite\Module\CDev\DrupalConnector\Drupal\Admin::getInstance()->submitWidgetDeleteForm(
        $form,
        $formState
    );
}

/**
 * Submit user profile/register form
 *
 * @param array &$form       Form description
 * @param array &$form_state Form state
 *
 * @return void
 */
function lcConnectorUserProfileFormSubmit(array &$form, array &$formState)
{
    return \XLite\Module\CDev\DrupalConnector\Drupal\Admin::getInstance()->submitUserProfileForm(
        $form,
        $formState
    );
}

/**
 * Submit admin permissions form
 *
 * @param array &$form       Form description
 * @param array &$form_state Form state
 *
 * @return void
 */
function lcConnectorUserPermissionsSubmit(array &$form, array &$formState)
{
    return \XLite\Module\CDev\DrupalConnector\Drupal\Admin::getInstance()->submitUserPermissionsForm(
        $form,
        $formState
    );
}

/**
 * Do user accounts synchronization in batch mode
 *
 * @param array &$context Batch process context data
 *
 * @return void
 */
function lcConnectorUserSync(array &$context)
{
    return \XLite\Module\CDev\DrupalConnector\Drupal\UserSync::getInstance()->doUserSynchronization(
        $context
    );
}

/**
 * Finalize user accounts synchronization batch process
 *
 * @param boolean $success    Batch process status
 * @param array   $results    Batch process results array
 * @param array   $operations Batch process operations array
 *
 * @return void
 */
function lcConnectorUserSyncFinishedCallback($success, array $results, array $operations)
{
    return \XLite\Module\CDev\DrupalConnector\Drupal\UserSync::getInstance()->doUserSyncFinished(
        $success,
        $results,
        $operations
    );
}
