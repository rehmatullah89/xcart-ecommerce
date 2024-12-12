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
 * Block
 */
class Block extends \XLite\Module\CDev\DrupalConnector\Drupal\ADrupal
{
    /**
     * Get block content from LC (if needed)
     *
     * @param array     &$data An array of data, as returned from the hook_block_view()
     * @param \stdClass $block The block object, as loaded from the database
     *
     * @return boolean
     */
    public function setBlockContent(array &$data, \stdClass $block)
    {
        // Check if current block is an LC one
        $blockInfo = \XLite\Module\CDev\DrupalConnector\Drupal\Model::getInstance()->getBlock($block->delta);
        if (
            'block' == $block->module
            && $blockInfo
        ) {

            // Trying to get widget from LC
            $widget = $this->getHandler()->getWidget($blockInfo['lc_class'], $blockInfo['options']);
            if ($widget) {

                // Check if widget is visible and its content is not empty
                $data['content'] = ($widget->checkVisibility() && ($content = $widget->getContent())) ? $content : null;
            }
        }

        return true;
    }

    /**
     * Preprocess theme variables for a specific theme block
     *
     * @param array  &$data Data to modify
     * @param string $class LC widget class
     *
     * @return void
     */
    public function addCSSClass(array &$data, $class)
    {
        $data['classes_array'][] = strtolower(preg_replace('/\\\\([A-Z0-9]+)/Ss', '-\\1', ltrim($class, '\\')));
    }
}
