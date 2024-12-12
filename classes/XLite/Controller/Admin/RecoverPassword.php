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

namespace XLite\Controller\Admin;

/**
 * Password recovery controller
 * TODO: full refactoring is needed
 */
class RecoverPassword extends \XLite\Controller\Admin\AAdmin
{
    /**
     * params
     *
     * @var string
     */
    protected $params = array('target', 'mode', 'email', 'link_mailed');

    /**
     * getAccessLevel
     *
     * @return void
     */
    public function getAccessLevel()
    {
        return \XLite\Core\Auth::getInstance()->getCustomerAccessLevel();
    }

    /**
     * Check - is current place public or not
     *
     * @return boolean
     */
    protected function isPublicZone()
    {
        return 'recover_password' == \XLite\Core\Request::getInstance()->target;
    }

    /**
     * Common method to determine current location
     *
     * @return array
     */
    protected function getLocation()
    {
        return 'Recover password';
    }

    /**
     * doActionRecoverPassword
     *
     * @return void
     */
    protected function doActionRecoverPassword()
    {
        // show recover message if email is valid
        if ($this->requestRecoverPassword($this->get('email'))) {
            $this->setReturnURL(
                $this->buildURL(
                    'recover_password',
                    '',
                    array(
                        'mode'        => 'recoverMessage',
                        'email'       => $this->get('email'),
                    )
                )
            );
        } else {
            $this->setReturnURL($this->buildURL('recover_password', '', array('valid' => 0)));
            \XLite\Core\TopMessage::addError('There is no user with specified email address');
        }
    }

    /**
     * doActionConfirm
     *
     * @return void
     */
    protected function doActionConfirm()
    {
        if (!is_null($this->get('email')) && \XLite\Core\Request::getInstance()->request_id) {

            if ($this->doPasswordRecovery($this->get('email'), \XLite\Core\Request::getInstance()->request_id)) {
                
                \XLite\Core\TopMessage::addInfo(
                    'The email with your account information was mailed to email', 
                    array(
                        'email' => $this->get('email'),
                    )
                );
                
                $this->setReturnURL(
                    $this->buildURL('login')
                );
            }
        }
    }

    /**
     * requestRecoverPassword
     *
     * @param mixed $email ____param_comment____
     *
     * @return void
     */
    protected function requestRecoverPassword($email)
    {
        $profile = \XLite\Core\Database::getRepo('XLite\Model\Profile')->findByLogin($email);
        if (isset($profile)) {
            \XLite\Core\Mailer::sendRecoverPasswordRequest($profile->getLogin(), $profile->getPassword());
        }

        return isset($profile);
    }

    /**
     * recoverPassword
     *
     * @param mixed $email     ____param_comment____
     * @param mixed $requestID ____param_comment____
     *
     * @return void
     */
    protected function doPasswordRecovery($email, $requestID)
    {
        $result = false;
        $profile = \XLite\Core\Database::getRepo('XLite\Model\Profile')->findByLogin($email);

        if (isset($profile) && $profile->getPassword() == $requestID) {
            $pass = generate_code();
            $profile->setPassword(md5($pass));
            $result = $profile->update();
            if ($result) {
                // Send notification to the user
                \XLite\Core\Mailer::sendRecoverPasswordConfirmation($email, $pass);
            }
        }

        return $result;
    }

    /**
     * Set if the form id is needed to make an actions
     * Form class uses this method to check if the form id should be added
     * 
     * @return boolean
     */
    public static function needFormId()
    {
        return false;
    }
}
