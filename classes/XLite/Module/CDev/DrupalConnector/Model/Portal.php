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

namespace XLite\Module\CDev\DrupalConnector\Model;

/**
 * So called "portal": custom Drupal node for LC controller
 *
 * TODO: if there will be more properties,
 * derive this class from the \Includes\DataStructure\Cell one
 */
class Portal extends \XLite\Base\SuperClass
{
    /**
     * Drupal URL where the controller will be displayed
     *
     * @var string
     */
    protected $url;

    /**
     * Controller class name
     *
     * @var string
     */
    protected $controller;

    /**
     * Portal title
     *
     * @var string
     */
    protected $title = '';

    /**
     * Portal type for Drupal
     *
     * @var integer
     */
    protected $type;


    /**
     * Constructor
     *
     * @param string  $url        Drupal URL
     * @param string  $controller Controller class name
     * @param string  $title      Portal title OPTIONAL
     * @param integer $type       Node type OPTIONAL
     *
     * @return void
     */
    public function __construct($url, $controller, $title = '', $type = null)
    {
        // Check if we can replace second argument to the "\XLite\Controller\Customer\ACustomer"
        if (!is_subclass_of($controller, '\XLite\Controller\AController')) {
            \Includes\ErrorHandler::fireError('Portal class is not a controller one');
        }

        $this->url        = $url;
        $this->controller = $controller;
        $this->title      = $title;
        $this->type       = isset($type) ? $type : $this->getDefaultType();
    }

    /**
     * Getter
     *
     * @return string
     */
    public function getURL()
    {
        return $this->url;
    }

    /**
     * Getter
     *
     * @return string
     */
    public function getController()
    {
        return $this->controller;
    }

    /**
     * Return portal default title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Getter
     *
     * @return integer
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Return menu node description in Drupal-specific form
     *
     * @return array
     */
    public function getDrupalMenuDescription()
    {
        return array(
            'title'           => $this->getTitle(),
            'title callback'  => $this->getTitleCallback(),
            'title arguments' => array($this->getTitle()),
            'page callback'   => $this->getContentCallback(),
            'access callback' => $this->getAccessCallback(),
            'type'            => $this->getType(),
        );
    }

    /**
     * Argument convertion: <DRUPAL> --> <LC>
     *
     * @param string $path     Portal path
     * @param array  $args     Druapl URL arguments OPTIONAL
     * @param array  $pageArgs LC-specific URL arguments OPTIONAL
     *
     * @return array
     */
    public function getLCArgs($path, array $args = array(), array $pageArgs = array())
    {
        return call_user_func_array(
            array($this->getController(), 'getPortalLCArgs'),
            array($path, $args, $pageArgs)
        );
    }

    /**
     * Argument convertion: <LC> --> <DRUPAL>
     *
     * @param string $target Current target
     * @param string $action Current action
     * @param array  $args   LC URL arguments OPTIONAL
     *
     * @return array
     */
    public function getDrupalArgs($target, $action, array $args = array())
    {
        return call_user_func_array(
            array($this->getController(), 'getPortalDrupalArgs'),
            array($this->getURL(), $args + (empty($action) ? array() : array('action' => $action)))
        );
    }


    /**
     * Return portal default page content callback
     *
     * @return string
     */
    protected function getTitleCallback()
    {
        return 'lcConnectorGetControllerTitle';
    }

    /**
     * Return portal default page content callback
     *
     * @return string
     */
    protected function getContentCallback()
    {
        return 'lcConnectorGetControllerContent';
    }

    /**
     * Return portal default page access callback
     *
     * @return string
     */
    protected function getAccessCallback()
    {
        return 'lc_connector_check_controller_access';
    }

    /**
     * Get default portal type
     *
     * @return integer
     */
    protected function getDefaultType()
    {
        return defined('MENU_LOCAL_TASK') ? MENU_LOCAL_TASK : 132;
    }
}
