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
 * Session
 */
abstract class Session extends \XLite\Core\Session implements \XLite\Base\IDecorator
{
    /**
     * Get session TTL (seconds)
     *
     * @return integer
     */
    public static function getTTL()
    {
        $ttl = intval(ini_get('session.cookie_lifetime'));

        return 0 < $ttl ? \XLite\Core\Converter::time() + $ttl : 0;
    }

    /**
     * Get URL path for Set-Cookie
     *
     * @param boolean $secure Secure protocol or not OPTIONAL
     *
     * @return string
     */
    protected function getCookiePath($secure = false)
    {
        return \XLite\Module\CDev\DrupalConnector\Handler::getInstance()->checkCurrentCMS()
            ? base_path()
            : parent::getCookiePath();
    }

    /**
     * Get parsed URL for Set-Cookie
     *
     * @param boolean $secure Secure protocol or not OPTIONAL
     *
     * @return array
     */
    protected function getCookieURL($secure = false)
    {
        // FIXME
        if (defined('LC_CONNECTOR_INITIALIZED')) {
            $url = ($secure ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
            $url = parse_url($url);

        } else {
            $url = parent::getCookieURL($secure);
        }

        return $url;
    }

    /**
     * Get current language
     *
     * @return string Language code
     */
    protected function getCurrentLanguage()
    {
        // DO NOT change call order here
        if (!\XLite::isAdminZone() && function_exists('drupal_multilingual') && drupal_multilingual()) {
            global $language;

            if ($language instanceof \stdClass) {
                $object = \XLite\Core\Database::getRepo('XLite\Model\Language')->findOneByCode($language->language);

                // DO NOT use "===" here
                if (isset($object) && \XLite\Model\Language::ENABLED == $object->getStatus()) {
                    $result = $object->getCode();
                }
            }
        }

        return isset($result) ? $result : parent::getCurrentLanguage();
    }
}
