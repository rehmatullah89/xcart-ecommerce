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

namespace XLite\Module\CDev\XMLSitemapDrupal\Drupal;

/**
 * Controller
 *
 * @LC_Dependencies ("CDev\DrupalConnector")
 */
abstract class Controller extends \XLite\Module\CDev\DrupalConnector\Drupal\Controller implements \XLite\Base\IDecorator
{
    /**
     * Get XML sitemap link info
     *
     * @return array
     */
    public function getXMLSitemapLinkInfo()
    {
        return array(
            'lc_connector' => array(
                'label' => 'LC connector',
                'xmlsitemap' => array(
                    'rebuild callback' => 'lc_connector_xmlsitemap_rebuild_callback',
                ),
            ),
        );
    }

    /**
     * Generate XML sitemap links
     *
     * @return void
     */
    public function generateXMLSitemapLinks()
    {
        $iterator = new \XLite\Module\CDev\XMLSitemap\Logic\SitemapIterator;

        $i = 0;

        $options = xmlsitemap_get_changefreq_options();
        $hash = array_flip($options);

        foreach ($iterator as $record) {
            $target = $record['loc']['target'];
            unset($record['loc']['target']);
            $record['loc'] = \XLite\Core\Converter::buildDrupalPath($target, '', $record['loc']);

            $i++;
            $record['type'] = 'lc_connector';
            $record['subtype'] = '';
            $record['id'] = $i;
            if (isset($hash[$record['changefreq']])) {
                $record['changefreq'] = $hash[$record['changefreq']];

            } else {
                unset($record['changefreq']);
            }

            xmlsitemap_link_save($record);
        }
    }
}

