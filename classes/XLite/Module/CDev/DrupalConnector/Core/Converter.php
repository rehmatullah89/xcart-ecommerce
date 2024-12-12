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

namespace XLite\Module\CDev\DrupalConnector\Core;

/**
 * Miscelaneous convertion routines
 */
class Converter extends \XLite\Core\Converter implements \XLite\Base\IDecorator
{
    /**
     * It's the the root part of Drupal nodes which are the imported X-Cart widgets
     */
    const DRUPAL_ROOT_NODE = 'store';

    /**
     * Special symbol for empty action
     */
    const EMPTY_ACTION = '0';

    /**
     * Compose URL from target, action and additional params
     *
     * @param string $target    Page identifier OPTIONAL
     * @param string $action    Action to perform OPTIONAL
     * @param array  $params    Additional params OPTIONAL
     * @param string $interface Interface script OPTIONAL
     *
     * @return string
     */
    public static function buildURL($target = '', $action = '', array $params = array(), $interface = null, $forceCleanURL = false, $forceCuFlag = null)
    {
        if ('' === $target) {
            $target = \XLite::TARGET_DEFAULT;
        }

        if (
            \XLite\Module\CDev\DrupalConnector\Handler::getInstance()->checkCurrentCMS()
            || (\XLite::CART_SELF == $interface && \XLite\Module\CDev\DrupalConnector\Core\Caller::getInstance()->isInitialized())
        ) {

            $portal = \XLite\Module\CDev\DrupalConnector\Handler::getInstance()->getPortalByTarget($target);

            if ($portal) {

                // Drupal URL (portal)
                list($path, $args) = $portal->getDrupalArgs($target, $action, $params);
                $result = static::normalizeDrupalURL($path, $args);
            } else {

                // Drupal URL
                $result = static::buildDrupalURL($target, $action, $params);
            }

        } else {

            // Standalone URL
            $result = parent::buildURL($target, $action, $params, $interface, $forceCleanURL, $forceCuFlag);

        }

        return $result;
    }

    /**
     * Build Drupal path string
     *
     * @param string $target Target OPTIONAL
     * @param string $action Action OPTIONAL
     * @param array  $params Parameters list OPTIONAL
     * @param string $node   Node OPTIONAL
     *
     * @return string
     */
    public static function buildDrupalPath($target = '', $action = '', array $params = array(), $node = self::DRUPAL_ROOT_NODE)
    {
        if (empty($action) && $params) {
            $action = static::EMPTY_ACTION;
        }

        $url = implode('/', array($node, $target, $action));

        if ($params) {
            $url .= '/' . \Includes\Utils\Converter::buildQuery($params, '-', '/');
        }

        return $url;
    }

    /**
     * Compose URL from target, action and additional params
     *
     * @param string $target Page identifier OPTIONAL
     * @param string $action Action to perform OPTIONAL
     * @param array  $params Additional params OPTIONAL
     * @param string $node   Node OPTIONAL
     *
     * @return string
     */
    public static function buildDrupalURL($target = '', $action = '', array $params = array(), $node = self::DRUPAL_ROOT_NODE)
    {
        return static::normalizeDrupalURL(static::buildDrupalPath($target, $action, $params, $node));
    }

    /**
     * Normalize Drupal URL to full path
     *
     * @param string $url  Short URL
     * @param array  $args Additional arguments OIPTIONAL
     *
     * @return string
     */
    protected static function normalizeDrupalURL($url, array $args = array())
    {
        return preg_replace(
            '/(\/)\%252F([^\/])/iSs',
            '\1/\2',
            \XLite\Module\CDev\DrupalConnector\Core\Caller::getInstance()->url($url, array('query' => $args))
        );
    }
}
