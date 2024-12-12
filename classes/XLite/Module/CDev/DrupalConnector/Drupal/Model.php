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
 * Model
 */
class Model extends \XLite\Module\CDev\DrupalConnector\Drupal\ADrupal
{
    /**
     * Blocks cache
     *
     * @var array
     */
    protected $blocks;


    /**
     * Get LC-related block(s)
     *
     * @param integer $blockId Block ID OPTIONAL
     *
     * @return array
     */
    public function getBlocks($blockId = null)
    {
        if (!isset($this->blocks)) {

            // Fetch all LC blocks ("isNotNull('lc_class')")
            $this->blocks = db_select('block_custom')
                ->fields('block_custom', array('bid', 'lc_class'))
                ->isNotNull('lc_class')
                ->execute()
                ->fetchAllAssoc('bid', \PDO::FETCH_ASSOC | \PDO::FETCH_GROUP);

            // Fetch all settings for LC blocks
            $settings = db_select('block_lc_widget_settings')
                ->fields('block_lc_widget_settings')
                ->execute()
                ->fetchAll(\PDO::FETCH_ASSOC | \PDO::FETCH_GROUP);

            // Merge results
            foreach ($this->blocks as $id => &$block) {

                $block['options'] = array();

                foreach ((array) @$settings[$id] as $data) {
                    $block['options'][$data['name']] = $data['value'];
                }
            }
        }

        return isset($blockId) ? @$this->blocks[$blockId] : $this->blocks;
    }

    /**
     * Alias
     *
     * @param integer $blockId Block ID OPTIONAL
     *
     * @return array
     */
    public function getBlock($blockId)
    {
        return $this->getBlocks($blockId);
    }
}
