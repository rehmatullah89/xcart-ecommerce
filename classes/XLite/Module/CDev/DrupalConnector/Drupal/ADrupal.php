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

namespace XLite\Module\CDev\DrupalConnector\Drupal;

/**
 * ADrupal
 */
abstract class ADrupal extends \XLite\Base\Singleton
{
    /**
     * Initialized handler instance
     *
     * @var \XLite\Module\CDev\DrupalConnector\Handler
     */
    protected $handler;

    // {{{ Application layer

    /**
     * Return instance of current CMS connector
     *
     * @return \XLite\Module\CDev\DrupalConnector\Handler
     */
    protected function getHandler()
    {
        if (!isset($this->handler)) {
            $this->handler = \XLite\Module\CDev\DrupalConnector\Handler::getInstance();
            $this->handler->init();
        }

        return $this->handler;
    }

    /**
     * Execute a controller action
     *
     * @param string $target Controller target
     * @param string $action Action to perform OPTIONAL
     * @param array  $data   Request data OPTIONAL
     *
     * @return void
     */
    protected function runController($target, $action = null, array $data = array())
    {
        $data = array('target' => $target, 'action' => $action) + $data;

        $this->getHandler()->mapRequest(array(\XLite\Core\CMSConnector::NO_REDIRECT => true) + $data);
        $this->getHandler()->runController(md5(serialize($data)));
    }

    // }}}
}
