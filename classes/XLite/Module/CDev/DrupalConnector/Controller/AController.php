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

namespace XLite\Module\CDev\DrupalConnector\Controller;

/**
 * Abstract controller
 */
abstract class AController extends \XLite\Controller\AController implements \XLite\Base\IDecorator
{
    /**
     * Argument convertion: <DRUPAL> --> <LC>
     *
     * @param string $path     Portal path
     * @param array  $args     Druapl URL arguments OPTIONAL
     * @param array  $pageArgs LC-specific URL arguments OPTIONAL
     *
     * @return array
     */
    public static function getPortalLCArgs($path, array $args = array(), array $pageArgs = array())
    {
        return array('target' => static::getTargetByClassName()) + $pageArgs;
    }

    /**
     * Argument convertion: <LC> --> <DRUPAL>
     *
     * @param string $path Drupal path
     * @param array  $args LC URL arguments OPTIONAL
     *
     * @return array
     */
    public static function getPortalDrupalArgs($path, array $args = array())
    {
        return array(
            $path,
            $args
        );
    }


    /**
     * Return Viewer object
     *
     * @return \XLite\View\Controller
     */
    public function getViewer()
    {
        $viewer = parent::getViewer();

        if (
            $this->isAJAXViewer()
            && \XLite\Core\Request::getInstance()->widgetConfId
            && \XLite\Module\CDev\DrupalConnector\Handler::isCMSStarted()
        ) {
            $data = \XLite\Module\CDev\DrupalConnector\Drupal\Model::getInstance()
                ->getBlock(\XLite\Core\Request::getInstance()->widgetConfId);

            if ($data && isset($data['options']) && is_array($data['options'])) {
                $viewer->setWidgetParams($data['options']);
            }
        }

        return $viewer;
    }
}
