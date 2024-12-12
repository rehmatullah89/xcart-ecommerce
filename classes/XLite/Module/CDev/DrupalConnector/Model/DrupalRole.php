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
 * Class represents a relation between user profile and drupal roles
 *
 * @Entity
 * @Table  (name="drupal_roles",
 *      indexes={
 *          @Index (name="drupal_role_id", columns={"drupal_role_id"})
 *      }
 * )
 */
class DrupalRole extends \XLite\Model\AEntity
{
    /**
     * Role unique id
     *
     * @var mixed
     *
     * @Id
     * @GeneratedValue (strategy="AUTO")
     * @Column         (type="uinteger", nullable=false)
     */
    protected $role_id;

    /**
     * Profile id
     *
     * @var integer
     *
     * @Column (type="integer")
     */
    protected $profile_id;

    /**
     * Drupal role id
     *
     * @var integer
     *
     * @Column (type="integer")
     */
    protected $drupal_role_id = 0;

    /**
     * Related profile
     *
     * @var \XLite\Model\Profile
     *
     * @ManyToOne  (targetEntity="XLite\Model\Profile", inversedBy="drupalRoles")
     * @JoinColumn (name="profile_id", referencedColumnName="profile_id")
     */
    protected $profile;
}
