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

namespace XLite\View\RequestHandler;

/**
 * Abstract base which can populate its params from request and session
 */
abstract class ARequestHandler extends \XLite\View\AView
{
    /**
     * The "session cell" param name
     */
    const PARAM_SESSION_CELL = 'sessionCell';

    /**
     * Keys of JS array to send
     */
    const W_CLASS                   = 'widget_class';
    const W_TARGET                  = 'widget_target';
    const W_PARAMS                  = 'widget_params';
    const W_LISTEN_TO_HASH_PREFIX   = 'listenToHashPrefix';
    const W_LISTEN_TO_HASH          = 'listenToHash';


    /**
     * List of so called "request" params - which take values from request (if passed)
     *
     * @var array
     */
    protected $requestParams;

    /**
     * Request param values saved in session
     *
     * @var array
     */
    protected $savedRequestParams;


    /**
     * Return target to retrive this widget from AJAX
     *
     * @return string
     */
    protected static function getWidgetTarget()
    {
        return '';
    }


    /**
     * Return list of the "request" parameter names
     *
     * @return array
     */
    public function getRequestParams()
    {
        if (!isset($this->requestParams)) {
            $this->defineRequestParams();
        }

        return $this->requestParams;
    }

    /**
     * Return the associative array mapped by the "request" parameter names/values
     *
     * @return array
     */
    public function getRequestParamsHash()
    {
        return $this->getParamsHash($this->getRequestParams());
    }

    /**
     * Set widget params
     *
     * @param array $params Handler params
     *
     * @return void
     */
    public function setWidgetParams(array $params)
    {
        if ($this->checkRequestParams() && !$this->isCloned) {
            $this->setWidgetRequestParamValues($params);
        }

        parent::setWidgetParams($params);
    }


    /**
     * Return name of the session cell identifier
     *
     * @return string
     */
    protected function getSessionCell()
    {
        return \XLite\Core\Converter::getPlainClassName($this);
    }

    /**
     * Return name of this class
     *
     * @return string
     */
    protected function getWidgetClass()
    {
        return get_class($this);
    }

    /**
     * Get widget parameters
     *
     * @return string
     */
    protected function getWidgetParameters()
    {
        return array();
    }

    /**
     * Return data to send to JS
     *
     * @return array
     */
    protected function getJSData()
    {
        return array(
            static::W_CLASS                     => $this->getWidgetClass(),
            static::W_TARGET                    => $this->getWidgetTarget(),
            static::W_PARAMS                    => $this->getWidgetParameters(),
            static::W_LISTEN_TO_HASH            => $this->getListenToHash(),
            static::W_LISTEN_TO_HASH_PREFIX     => $this->getListenToHashPrefix(),
        );
    }

    /**
     * Defines if the widget is listening to #hash changes
     * 
     * @return boolean
     */
    protected function getListenToHash()
    {
        return false;
    }

    /**
     * Defines the #hash prefix of the data for the widget
     * @TODO implement!
     * 
     * @return string
     */    
    protected function getListenToHashPrefix()
    {
        return '';
    }
        
    /**
     * Check if passed request data are correspond to the current widget
     *
     * There are two cases:
     *
     * 1. Name of the session cell is not presented in request.
     * In this case the target widget is undefined, and the request data are used for ALL widgets
     *
     * 2. Name of the session cell is passed in the request.
     * Then only the corresponded widget will use it
     *
     * @return boolean
     */
    protected function checkSessionCell()
    {
        $cell = \XLite\Core\Request::getInstance()->{self::PARAM_SESSION_CELL};

        return empty($cell) || $this->getSessionCell() === $cell;
    }

    /**
     * Check if we need to manage request params
     *
     * @return boolean
     */
    protected function checkRequestParams()
    {
        return $this->getRequestParams() && $this->checkSessionCell();
    }

    /**
     * Called before the includeCompiledFile()
     *
     * Here we save all passed request params into the session.
     * It allows us to refresh pages without restore their default view
     *
     * @return void
     */
    protected function initView()
    {
        parent::initView();

        if ($this->checkRequestParams()) {
            \XLite\Core\Session::getInstance()->set($this->getSessionCell(), $this->getRequestParamsHash());
        }
    }

    /**
     * Define the "request" parameters
     *
     * @return void
     */
    protected function defineRequestParams()
    {
        $this->requestParams = array();
    }

    /**
     * Fetch param value from current session
     *
     * @param string $param Parameter name
     *
     * @return mixed
     */
    protected function getSavedRequestParam($param)
    {
        if (!isset($this->savedRequestParams)) {

            // Cache the session cell (variable) associatd with the current widget
            $this->savedRequestParams = \XLite\Core\Session::getInstance()->get(
                $this->getSessionCell()
            );

            // ... To avoid repeated initializations
            if (!isset($this->savedRequestParams)) {
                $this->savedRequestParams = array();
            }
        }

        return isset($this->savedRequestParams[$param]) ? $this->savedRequestParams[$param] : null;
    }

    /**
     * Set param values using the request or session
     *
     * @param array &$params Param values to modify
     *
     * @return void
     */
    protected function setWidgetRequestParamValues(array &$params)
    {
        foreach ($this->getRequestParams() as $name) {

            // First, check the request
            $value = \XLite\Core\Request::getInstance()->$name;

            if (isset($value)) {
                // If the param is passed in the request - use it
                $params[$name] = $value;

            } else {
                // Else trying to fetch the param from session
                $value = $this->getSavedRequestParam($name);

                // If the value is found - use it
                if (isset($value)) {
                    $params[$name] = $value;
                }
            }
        }
    }
}
