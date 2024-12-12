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

namespace XLite\Controller\Customer;

/**
 * Password recovery controller
 */
class RecoverPassword extends \XLite\Controller\Customer\ACustomer
{
    /**
     * params
     *
     * @var string
     */
    protected $params = array('target', 'email');

    /**
     * Add the base part of the location path
     *
     * @return void
     */
    protected function addBaseLocation()
    {
        parent::addBaseLocation();

        $this->addLocationNode('Help zone');
    }

    /**
     * Common method to determine current location
     *
     * @return array
     */
    protected function getLocation()
    {
        return $this->getTitle();
    }

    /**
     * Get page title
     *
     * @return string
     */
    public function getTitle()
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
        if ($this->requestRecoverPassword($this->get('email'))) {
            \XLite\Core\TopMessage::addInfo(
                'The confirmation URL link was mailed to email',
                array('email' => $this->get('email'))
            );

            $this->setReturnURL($this->buildURL());
            \XLite\Core\Event::recoverPasswordSent(array('email' => $this->get('email')));

        } else {

            $this->setReturnURL($this->buildURL('recover_password'));

            \XLite\Core\TopMessage::addError('There is no user with specified email address');
            \XLite\Core\Event::invalidElement('email', static::t('There is no user with specified email address'));
        }
    }

    /**
     * doActionConfirm
     *
     * @return void
     */
    protected function doActionConfirm()
    {
        if (
            $this->get('email')
            && \XLite\Core\Request::getInstance()->request_id
            && $this->doPasswordRecovery($this->get('email'), \XLite\Core\Request::getInstance()->request_id)
        ) {
            \XLite\Core\TopMessage::addInfo(
                'The email with your account information was mailed to email',
                array('email' => $this->get('email'))
            );
            $this->setReturnURL($this->buildURL());
            \XLite\Core\Event::recoverPasswordDone(array('email' => $this->get('email')));
        }
    }

    /**
     * Sent Recover password mail
     *
     * @param string $email Email
     *
     * @return boolean
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
     * Recover password
     *
     * @param string $email     Profile email
     * @param string $requestID Request ID
     *
     * @return boolean
     */
    protected function doPasswordRecovery($email, $requestID)
    {
        $profile = \XLite\Core\Database::getRepo('XLite\Model\Profile')->findByLogin($email);

        if (!isset($profile) || $profile->getPassword() != $requestID) {
            $result = false;

        } else {

            $pass = \XLite\Core\Database::getRepo('XLite\Model\Profile')->generatePassword();
            $profile->setPassword(\XLite\Core\Auth::encryptPassword($pass));

            $result = $profile->update();

            if ($result) {
                // Send notification to the user
                \XLite\Core\Mailer::sendRecoverPasswordConfirmation($email, $pass);
            }
        }

        return $result;
    }
    
}
