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
 * @copyright Copyright (c) 2011-2014 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 */

namespace XLite\Model;

/**
 * Class represents an order
 *
 * @Entity (repositoryClass="\XLite\Model\Repo\Order")
 * @Table  (name="orders",
 *      indexes={
 *          @Index (name="date", columns={"date"}),
 *          @Index (name="total", columns={"total"}),
 *          @Index (name="subtotal", columns={"subtotal"}),
 *          @Index (name="tracking", columns={"tracking"}),
 *          @Index (name="status", columns={"status"}),
 *          @Index (name="shipping_id", columns={"shipping_id"})
 *      }
 * )
 *
 * @HasLifecycleCallbacks
 * @InheritanceType       ("SINGLE_TABLE")
 * @DiscriminatorColumn   (name="is_order", type="integer", length=1)
 * @DiscriminatorMap      ({1 = "XLite\Model\Order", 0 = "XLite\Model\Cart"})
 */
class Order extends \XLite\Model\Base\SurchargeOwner
{
    /**
     * Order statuses
     */
    const STATUS_TEMPORARY  = 'T';
    const STATUS_INPROGRESS = 'I';
    const STATUS_QUEUED     = 'Q';
    const STATUS_AUTHORIZED = 'A';
    const STATUS_PROCESSED  = 'P';
    const STATUS_SHIPPED    = 'S';
    const STATUS_COMPLETED  = 'C';
    const STATUS_FAILED     = 'F';
    const STATUS_DECLINED   = 'D';
    const STATUS_EXPIRED    = 'E';
    const STATUS_CANCELED   = 'CA';
    const STATUS_REFUND_REQUESTED = 'X';
    const STATUS_REFUNDED         = 'Y';
    const STATUS_PART_REFUNDED    = 'Z';

    /**
     * Order total that is financially declared as zero (null)
     */
    const ORDER_ZERO = 0.00001;

    /**
     * Add item error codes
     */
    const NOT_VALID_ERROR = 'notValid';


    /**
     * Order unique id
     *
     * @var mixed
     *
     * @Id
     * @GeneratedValue (strategy="AUTO")
     * @Column         (type="integer")
     */
    protected $order_id;

    /**
     * Order profile
     *
     * @var \XLite\Model\Profile
     *
     * @OneToOne   (targetEntity="XLite\Model\Profile", cascade={"all"})
     * @JoinColumn (name="profile_id", referencedColumnName="profile_id")
     */
    protected $profile;

    /**
     * Original profile
     *
     * @var \XLite\Model\Profile
     *
     * @ManyToOne  (targetEntity="XLite\Model\Profile")
     * @JoinColumn (name="orig_profile_id", referencedColumnName="profile_id")
     */
    protected $orig_profile;

    /**
     * Shipping method unique id
     *
     * @var integer
     *
     * @Column (type="integer")
     */
    protected $shipping_id = 0;

    /**
     * Shipping method name
     *
     * @var integer
     *
     * @Column (type="string", nullable=true)
     */
    protected $shipping_method_name = '';

    /**
     * Shipping tracking code
     *
     * @var string
     *
     * @Column (type="string", length=32)
     */
    protected $tracking = '';

    /**
     * Order creation timestamp
     *
     * @var integer
     *
     * @Column (type="integer")
     */
    protected $date;

    /**
     * Last order renew date
     *
     * @var integer
     *
     * @Column (type="integer")
     */
    protected $lastRenewDate = 0;

    /**
     * Status code
     *
     * @var string
     *
     * @Column (type="fixedstring", length=2)
     */
    protected $status = self::STATUS_INPROGRESS;

    /**
     * Customer notes
     *
     * @var string
     *
     * @Column (type="text")
     */
    protected $notes = '';

    /**
     * Admin notes
     *
     * @var string
     *
     * @Column (type="text")
     */
    protected $adminNotes = '';

    /**
     * Order details
     *
     * @var \Doctrine\Common\Collections\Collection
     *
     * @OneToMany (targetEntity="XLite\Model\OrderDetail", mappedBy="order", cascade={"all"})
     * @OrderBy   ({"name" = "ASC"})
     */
    protected $details;

    /**
     * Order events queue
     *
     * @var \Doctrine\Common\Collections\Collection
     *
     * @OneToMany (targetEntity="XLite\Model\OrderHistoryEvents", mappedBy="order", cascade={"all"})
     */
    protected $events;

    /**
     * Order items
     *
     * @var \Doctrine\Common\Collections\Collection
     *
     * @OneToMany (targetEntity="XLite\Model\OrderItem", mappedBy="order", cascade={"all"})
     */
    protected $items;

    /**
     * Order surcharges
     *
     * @var \Doctrine\Common\Collections\Collection
     *
     * @OneToMany (targetEntity="XLite\Model\Order\Surcharge", mappedBy="owner", cascade={"all"})
     * @OrderBy   ({"id" = "ASC"})
     */
    protected $surcharges;

    /**
     * Payment transactions
     *
     * @var \Doctrine\Common\Collections\Collection
     *
     * @OneToMany (targetEntity="XLite\Model\Payment\Transaction", mappedBy="order", cascade={"all"})
     */
    protected $payment_transactions;

    /**
     * Currency
     *
     * @var \XLite\Model\Currency
     *
     * @ManyToOne  (targetEntity="XLite\Model\Currency", inversedBy="orders", cascade={"merge","detach"})
     * @JoinColumn (name="currency_id", referencedColumnName="currency_id")
     */
    protected $currency;

    /**
     * Unique order identificator (it is working for orders only, not for cart entities)
     *
     * @var integer
     *
     * @Column (type="text", nullable=true)
     */
    protected $orderNumber;

    /**
     * 'Add item' error code
     *
     * @var string
     */
    protected $addItemError;

    /**
     * List of change status handlers;
     * top index - old status, second index - new one
     * (<old_status> ----> <new_status>: $statusHandlers[$old][$new])
     *
     * @var array
     */
    protected static $statusHandlers = array(

        self::STATUS_TEMPORARY => array(
            self::STATUS_INPROGRESS => array('decrease'),
            self::STATUS_AUTHORIZED => array('checkout', 'decrease', 'queue', 'authorize'),
            self::STATUS_PROCESSED  => array('checkout', 'decrease', 'queue', 'process'),
            self::STATUS_COMPLETED  => array('checkout', 'decrease', 'queue', 'process'),
            self::STATUS_QUEUED     => array('checkout', 'decrease', 'queue'),
            self::STATUS_SHIPPED    => array('checkout', 'decrease', 'queue', 'ship'),
            self::STATUS_DECLINED   => array('fail'),
            self::STATUS_FAILED     => array('fail'),
            self::STATUS_CANCELED   => array('cancel'),
            self::STATUS_EXPIRED    => array('fail'),
        ),

        self::STATUS_INPROGRESS => array(
            self::STATUS_TEMPORARY  => array('increase'),
            self::STATUS_AUTHORIZED => array('checkout', 'queue', 'authorize'),
            self::STATUS_PROCESSED  => array('checkout', 'queue', 'process'),
            self::STATUS_COMPLETED  => array('checkout', 'queue', 'process'),
            self::STATUS_QUEUED     => array('checkout', 'queue'),
            self::STATUS_SHIPPED    => array('checkout', 'queue', 'ship'),
            self::STATUS_DECLINED   => array('increase', 'fail'),
            self::STATUS_FAILED     => array('increase', 'fail'),
            self::STATUS_CANCELED   => array('cancel'),
            self::STATUS_EXPIRED    => array('increase', 'fail'),
        ),

        self::STATUS_QUEUED => array(
            self::STATUS_TEMPORARY  => array('uncheckout', 'increase'),
            self::STATUS_INPROGRESS => array('uncheckout'),
            self::STATUS_AUTHORIZED => array('authorize'),
            self::STATUS_PROCESSED  => array('process'),
            self::STATUS_SHIPPED    => array('ship'),
            self::STATUS_COMPLETED  => array('process'),
            self::STATUS_DECLINED   => array('decline', 'uncheckout', 'increase', 'fail'),
            self::STATUS_FAILED     => array('decline', 'uncheckout', 'increase', 'fail'),
            self::STATUS_CANCELED   => array('decline', 'uncheckout', 'increase', 'cancel'),
            self::STATUS_EXPIRED    => array('decline', 'uncheckout', 'increase', 'fail'),
        ),

        self::STATUS_SHIPPED => array(
            self::STATUS_TEMPORARY  => array('uncheckout', 'increase'),
            self::STATUS_INPROGRESS => array('uncheckout'),
            self::STATUS_AUTHORIZED => array('authorize'),
            self::STATUS_PROCESSED  => array('process'),
            self::STATUS_COMPLETED  => array('process'),
            self::STATUS_DECLINED   => array('decline', 'uncheckout', 'increase', 'fail'),
            self::STATUS_FAILED     => array('decline', 'uncheckout', 'increase', 'fail'),
            self::STATUS_CANCELED   => array('decline', 'uncheckout', 'increase', 'cancel'),
            self::STATUS_EXPIRED    => array('decline', 'uncheckout', 'increase', 'fail'),
        ),

        self::STATUS_AUTHORIZED => array(
            self::STATUS_TEMPORARY  => array('uncheckout', 'increase'),
            self::STATUS_INPROGRESS => array('uncheckout'),
            self::STATUS_SHIPPED    => array('ship'),
            self::STATUS_PROCESSED  => array('process'),
            self::STATUS_COMPLETED  => array('process'),
            self::STATUS_DECLINED   => array('decline', 'uncheckout', 'increase', 'fail'),
            self::STATUS_FAILED     => array('decline', 'uncheckout', 'increase', 'fail'),
            self::STATUS_CANCELED   => array('decline', 'uncheckout', 'increase', 'cancel'),
            self::STATUS_EXPIRED    => array('decline', 'uncheckout', 'increase', 'fail'),
        ),

        self::STATUS_PROCESSED => array(
            self::STATUS_TEMPORARY  => array('uncheckout', 'increase'),
            self::STATUS_INPROGRESS => array('uncheckout'),
            self::STATUS_SHIPPED    => array('ship'),
            self::STATUS_DECLINED   => array('decline', 'uncheckout', 'increase', 'fail'),
            self::STATUS_FAILED     => array('decline', 'uncheckout', 'increase', 'fail'),
            self::STATUS_CANCELED   => array('decline', 'uncheckout', 'increase', 'fail'),
            self::STATUS_EXPIRED    => array('decline', 'uncheckout', 'increase', 'fail'),
        ),

        self::STATUS_COMPLETED => array(
            self::STATUS_TEMPORARY  => array('uncheckout', 'increase'),
            self::STATUS_INPROGRESS => array('uncheckout'),
            self::STATUS_SHIPPED    => array('ship'),
            self::STATUS_DECLINED   => array('decline', 'uncheckout', 'increase', 'fail'),
            self::STATUS_FAILED     => array('decline', 'uncheckout', 'increase', 'fail'),
            self::STATUS_CANCELED   => array('decline', 'uncheckout', 'increase', 'cancel'),
            self::STATUS_EXPIRED    => array('decline', 'uncheckout', 'increase', 'fail'),
        ),

        self::STATUS_DECLINED => array(
            self::STATUS_INPROGRESS => array('uncheckout', 'decrease'),
            self::STATUS_AUTHORIZED => array('checkout', 'decrease', 'queue', 'authorize'),
            self::STATUS_PROCESSED  => array('checkout', 'decrease', 'queue', 'process'),
            self::STATUS_SHIPPED    => array('checkout', 'decrease', 'queue', 'ship'),
            self::STATUS_COMPLETED  => array('checkout', 'decrease', 'queue', 'process'),
            self::STATUS_QUEUED     => array('checkout', 'decrease', 'queue'),
        ),

        self::STATUS_FAILED => array(
            self::STATUS_INPROGRESS => array('uncheckout', 'decrease'),
            self::STATUS_AUTHORIZED => array('checkout', 'decrease', 'queue', 'authorize'),
            self::STATUS_PROCESSED  => array('checkout', 'decrease', 'queue', 'process'),
            self::STATUS_SHIPPED    => array('checkout', 'decrease', 'queue', 'ship'),
            self::STATUS_COMPLETED  => array('checkout', 'decrease', 'queue', 'process'),
            self::STATUS_QUEUED     => array('checkout', 'decrease', 'queue'),
        ),

        self::STATUS_CANCELED => array(
            self::STATUS_INPROGRESS => array('uncheckout', 'decrease'),
            self::STATUS_AUTHORIZED => array('checkout', 'decrease', 'queue', 'authorize'),
            self::STATUS_PROCESSED  => array('checkout', 'decrease', 'queue', 'process'),
            self::STATUS_SHIPPED    => array('checkout', 'decrease', 'queue', 'ship'),
            self::STATUS_COMPLETED  => array('checkout', 'decrease', 'queue', 'process'),
            self::STATUS_QUEUED     => array('checkout', 'decrease', 'queue'),
        ),

        self::STATUS_EXPIRED => array(
            self::STATUS_INPROGRESS => array('uncheckout', 'decrease'),
            self::STATUS_AUTHORIZED => array('checkout', 'decrease', 'queue', 'authorize'),
            self::STATUS_PROCESSED  => array('checkout', 'decrease', 'queue', 'process'),
            self::STATUS_SHIPPED    => array('checkout', 'decrease', 'queue', 'ship'),
            self::STATUS_COMPLETED  => array('checkout', 'decrease', 'queue', 'process'),
            self::STATUS_QUEUED     => array('checkout', 'decrease', 'queue'),
        ),
    );

    /**
     * Order previous status
     *
     * @var string
     */
    protected $oldStatus = self::STATUS_INPROGRESS;

    /**
     * Modifiers (cache)
     *
     * @var \XLite\DataSet\Collection\OrderModifier
     */
    protected $modifiers;


    /**
     * Return list of all alowed order statuses
     *
     * @param string $status Status to get OPTIONAL
     *
     * @return array | string
     */
    public static function getAllowedStatuses($status = null)
    {
        $list = array(
            static::STATUS_TEMPORARY            => 'Cart',
            static::STATUS_INPROGRESS           => 'Incompleted',
            static::STATUS_QUEUED               => 'Queued',
            static::STATUS_AUTHORIZED           => 'Authorized',
            static::STATUS_PROCESSED            => 'Processed',
            static::STATUS_SHIPPED              => 'Shipped',
            static::STATUS_COMPLETED            => 'Completed',
            static::STATUS_CANCELED             => 'Canceled',
            static::STATUS_FAILED               => 'Failed',
            static::STATUS_DECLINED             => 'Declined',
            static::STATUS_EXPIRED              => 'Expired',
            static::STATUS_REFUND_REQUESTED     => 'Refund requested',
            static::STATUS_REFUNDED             => 'Refunded',
            static::STATUS_PART_REFUNDED        => 'Partially refunded',
        );

        return isset($status)
            ? (isset($list[$status]) ? $list[$status] : null)
            : $list;
    }

    /**
     * Get open order statuses
     *
     * @return array
     */
    public static function getOpenStatuses()
    {
        return array(
            \XLite\Model\Order::STATUS_QUEUED,
            \XLite\Model\Order::STATUS_SHIPPED,
            \XLite\Model\Order::STATUS_AUTHORIZED,
            \XLite\Model\Order::STATUS_PROCESSED,
            \XLite\Model\Order::STATUS_FAILED,
            \XLite\Model\Order::STATUS_REFUNDED,
            \XLite\Model\Order::STATUS_PART_REFUNDED,
            \XLite\Model\Order::STATUS_EXPIRED,
        );
    }


    /**
     * Add item to order
     *
     * @param \XLite\Model\OrderItem $newItem Item to add
     *
     * @return boolean
     */
    public function addItem(\XLite\Model\OrderItem $newItem)
    {
        $result = false;

        if ($newItem->isValid()) {
            $this->addItemError = null;
            $newItem->setOrder($this);

            $item = $this->getItemByItem($newItem);

            if ($item) {
                $item->setAmount($item->getAmount() + $newItem->getAmount());

            } else {
                $this->addItems($newItem);
            }

            $result = true;

        } else {
            $this->addItemError = self::NOT_VALID_ERROR;
        }

        return $result;
    }

    /**
     * Get 'Add item' error code
     *
     * @return string|void
     */
    public function getAddItemError()
    {
        return $this->addItemError;
    }

    /**
     * Get item from order by another item
     *
     * @param \XLite\Model\OrderItem $item Another item
     *
     * @return \XLite\Model\OrderItem|void
     */
    public function getItemByItem(\XLite\Model\OrderItem $item)
    {
        $items = $this->getItems();

        return $this->getItemByItemKey($item->getKey());
    }

    /**
     * Get item from order by item key
     *
     * @param string $key Item key
     *
     * @return \XLite\Model\OrderItem|void
     */
    public function getItemByItemKey($key)
    {
        $items = $this->getItems();

        return \Includes\Utils\ArrayManager::findValue(
            $items,
            array($this, 'checkItemKeyEqual'),
            $key
        );
    }

    /**
     * Get item from order by item  id
     *
     * @param integer $itemId Item id
     *
     * @return \XLite\Model\OrderItem|void
     */
    public function getItemByItemId($itemId)
    {
        $items = $this->getItems();

        return \Includes\Utils\ArrayManager::findValue(
            $items,
            array($this, 'checkItemIdEqual'),
            $itemId
        );
    }

    /**
     * Find items by product ID
     *
     * @param integer $productId Product ID to use
     *
     * @return array
     */
    public function getItemsByProductId($productId)
    {
        $items = $this->getItems();

        return \Includes\Utils\ArrayManager::filter(
            $items,
            array($this, 'isItemProductIdEqual'),
            $productId
        );
    }

    /**
     * Normalize items
     *
     * @return void
     */
    public function normalizeItems()
    {
        // Normalize by key
        $keys = array();

        foreach ($this->getItems() as $item) {
            $key = $item->getKey();
            if (isset($keys[$key])) {
                $keys[$key]->setAmount($keys[$key]->getAmount() + $item->getAmount());
                $this->getItems()->removeElement($item);

                if (\XLite\Core\Database::getEM()->contains($item)) {
                    \XLite\Core\Database::getEM()->remove($item);
                }

            } else {
                $keys[$key] = $item;
            }
        }

        unset($keys);

        // Remove invalid items
        foreach ($this->getItems() as $item) {
            if (!$item->isValid()) {
                $this->getItems()->removeElement($item);
                if (\XLite\Core\Database::getEM()->contains($item)) {
                    \XLite\Core\Database::getEM()->remove($item);
                }
            }
        }
    }

    /**
     * Return items number
     *
     * @return integer
     */
    public function countItems()
    {
        return count($this->getItems());
    }

    /**
     * Return order items total quantity
     *
     * @return integer
     */
    public function countQuantity()
    {
        $quantity = 0;

        foreach ($this->getItems() as $item) {
            $quantity += $item->getAmount();
        }

        return $quantity;
    }

    /**
     * Checks whether the shopping cart/order is empty
     *
     * @return boolean
     */
    public function isEmpty()
    {
        return 0 >= $this->countItems();
    }

    /**
     * Check order subtotal
     *
     * @return boolean
     */
    public function isMinOrderAmountError()
    {
        return $this->getSubtotal() < \XLite\Core\Config::getInstance()->General->minimal_order_amount;
    }

    /**
     * Check order subtotal
     *
     * @return boolean
     */
    public function isMaxOrderAmountError()
    {
        return $this->getSubtotal() > \XLite\Core\Config::getInstance()->General->maximal_order_amount;
    }

    /**
     * Check - is order processed or not
     *
     * @return boolean
     */
    public function isProcessed()
    {
        return in_array($this->getStatus(), array(self::STATUS_PROCESSED, self::STATUS_COMPLETED));
    }

    /**
     * Check - os order queued or not
     *
     * @return boolean
     */
    public function isQueued()
    {
        return self::STATUS_QUEUED == $this->getStatus();
    }

    /**
     * Check item amounts
     *
     * @return array
     */
    public function getItemsWithWrongAmounts()
    {
        $items = array();
        foreach ($this->getItems() as $item) {
            if ($item->hasWrongAmount()) {
                $items[] = $item;
            }
        }

        return $items;
    }

    /**
     * Get original profile
     *
     * @return \XLite\Model\Profile
     */
    public function getOrigProfile()
    {
        return $this->orig_profile ?: $this->getProfile();
    }

    /**
     * Set profile
     *
     * @param \XLite\Model\Profile $profile Profile OPTIONAL
     *
     * @return void
     */
    public function setProfile(\XLite\Model\Profile $profile = null)
    {
        if (
            $this->getProfile()
            && $this->getProfile()->getOrder()
            && (!$profile || $this->getProfile()->getProfileId() != $profile->getProfileId())
        ) {
            $this->getProfile()->setOrder(null);
            if ($this->getProfile()->getAnonymous()) {
                \XLite\Core\Database::getEM()->remove($this->getProfile());
            }
        }

        $this->profile = $profile;
    }

    /**
     * Set original profile
     * FIXME: is it really needed?
     *
     * @param \XLite\Model\Profile $profile Profile OPTIONAL
     *
     * @return void
     */
    public function setOrigProfile(\XLite\Model\Profile $profile = null)
    {
        if (
            $this->getOrigProfile()
            && $this->getOrigProfile()->getOrder()
            && (!$this->getProfile() || $this->getOrigProfile()->getProfileId() != $this->getProfile()->getProfileId())
            && (!$profile || $this->getOrigProfile()->getProfileId() != $profile->getProfileId())
        ) {
            $this->getOrigProfile()->setOrder(null);
        }

        $this->orig_profile = $profile;
    }

    /**
     * Set profile copy
     *
     * @param \XLite\Model\Profile $profile Profile
     *
     * @return void
     */
    public function setProfileCopy(\XLite\Model\Profile $profile)
    {
        // Set profile as original profile
        $this->setOrigProfile($profile);

        // Clone profile and set as order profile
        $clonedProfile = $profile->cloneEntity();
        $this->setProfile($clonedProfile);
        $clonedProfile->setOrder($this);
    }

    /**
     * Set old status of the order (not stored in the DB)
     *
     * @param string $status Status
     *
     * @return void
     */
    public function setOldStatus($status)
    {
        $this->oldStatus = $status;
    }

    /**
     * Get items list fingerprint
     *
     * @return string
     */
    public function getItemsFingerprint()
    {
        $result = false;

        if (!$this->isEmpty()) {

            $result = array();
            foreach ($this->getItems() as $item) {
                $result[] = array(
                    $item->getItemId(),
                    $item->getKey(),
                    $item->getAmount()
                );
            }

            $result = md5(serialize($result));
        }

        return $result;
    }

    /**
     * Generate a string representation of the order
     * to send to a payment service
     *
     * @return string
     */
    public function getDescription()
    {
        $result = array();

        foreach ($this->getItems() as $item) {
            $result[] = $item->getDescription();
        }

        return implode("\n", $result);
    }

    /**
     * Get order fingerprint for event subsystem
     *
     * @param array $exclude Exclude kes OPTONAL
     *
     * @return array
     */
    public function getEventFingerprint(array $exclude = array())
    {
        $keys = array_diff($this->defineFingerprintKeys(), $exclude);

        $hash = array();
        foreach ($keys as $key) {
            $method = 'getFingerprintBy' . ucfirst($key);
            $hash[$key] = $this->$method();
        }

        return $hash;
    }

    /**
     * Define fingerprint keys
     *
     * @return array
     */
    protected function defineFingerprintKeys()
    {
        return array(
            'items',
            'itemsCount',
            'shippingTotal',
            'total',
            'shippingMethodId',
            'paymentMethodId',
            'shippingMethodsHash',
            'paymentMethodsHash',
            'shippingAddressId',
            'billingAddressId',
            'sameAddress',
        );
    }

    /**
     * Get fingerprint by 'items' key
     *
     * @return array
     */
    protected function getFingerprintByItems()
    {
        $list = array();

        foreach ($this->getItems() as $item) {
            $event = $item->getEventCell();
            $event['quantity'] = $item->getAmount();

            // Inventory tracking
            $object = $item->getObject();

            if ($object) {
                $inventory = $object->getInventory();

                if ($inventory->getEnabled() && $inventory->getAmount() <= $item->getAmount()) {
                    $event['is_limit'] = 1;
                }
            }

            $list[] = $event;
        }

        return $list;
    }

    /**
     * Get fingerprint by 'itemsCount' key
     *
     * @return array
     */
    protected function getFingerprintByItemsCount()
    {
        return $this->countQuantity();
    }

    /**
     * Get fingerprint by 'shippingTotal' key
     *
     * @return float
     */
    protected function getFingerprintByShippingTotal()
    {
        $shippingModifier = $this->getModifier(\XLite\Model\Base\Surcharge::TYPE_SHIPPING, 'SHIPPING');

        return $shippingModifier && $shippingModifier->getSelectedRate()
            ? $shippingModifier->getSelectedRate()->getTotalRate()
            : 0;
    }

    /**
     * Get fingerprint by 'total' key
     *
     * @return float
     */
    protected function getFingerprintByTotal()
    {
        return $this->getTotal();
    }

    /**
     * Get fingerprint by 'shippingMethodId' key
     *
     * @return integer
     */
    protected function getFingerprintByShippingMethodId()
    {
        $shippingModifier = $this->getModifier(\XLite\Model\Base\Surcharge::TYPE_SHIPPING, 'SHIPPING');

        return $shippingModifier && $shippingModifier->getSelectedRate()
            ? $shippingModifier->getSelectedRate()->getMethod()->getMethodId()
            : 0;
    }

    /**
     * Get fingerprint by 'paymentMethodId' key
     *
     * @return integer
     */
    protected function getFingerprintByPaymentMethodId()
    {
        return $this->getPaymentMethod()
                ? $this->getPaymentMethod()->getMethodId()
                : 0;
    }

    /**
     * Get fingerprint by 'shippingMethodsHash' key
     *
     * @return string
     */
    protected function getFingerprintByShippingMethodsHash()
    {
        $shippingModifier = $this->getModifier(\XLite\Model\Base\Surcharge::TYPE_SHIPPING, 'SHIPPING');
        $shippingMethodsHash = array();
        if ($shippingModifier) {
            foreach ($shippingModifier->getRates() as $rate) {
                $shippingMethodsHash[] = $rate->getMethod()->getMethodId() . ':' . $rate->getTotalRate();
            }
        }

        return implode(';', $shippingMethodsHash);
    }

    /**
     * Get fingerprint by 'paymentMethodsHash' key
     *
     * @return string
     */
    protected function getFingerprintByPaymentMethodsHash()
    {
        $paymentMethodsHash = array();
        foreach ($this->getPaymentMethods() as $method) {
            $paymentMethodsHash[] = $method->getMethodId();
        }

        return implode(';', $paymentMethodsHash);
    }

    /**
     * Get fingerprint by 'shippingAddressId' key
     *
     * @return integer
     */
    protected function getFingerprintByShippingAddressId()
    {
        return $this->getProfile() && $this->getProfile()->getShippingAddress()
            ? $this->getProfile()->getShippingAddress()->getAddressId()
            : 0;
    }

    /**
     * Get fingerprint by 'billingAddressId' key
     *
     * @return integer
     */
    protected function getFingerprintByBillingAddressId()
    {
        return $this->getProfile() && $this->getProfile()->getBillingAddress()
            ? $this->getProfile()->getBillingAddress()->getAddressId()
            : 0;
    }

    /**
     * Get fingerprint by 'sameAddress' key
     *
     * @return boolean
     */
    protected function getFingerprintBySameAddress()
    {
        return $this->getProfile() && $this->getProfile()->isSameAddress();
    }

    /**
     * Get detail
     *
     * @param string $name Details cell name
     *
     * @return mixed
     */
    public function getDetail($name)
    {
        $details = $this->getDetails();
        return \Includes\Utils\ArrayManager::findValue(
            $details,
            array($this, 'checkDetailName'),
            $name
        );
    }

    /**
     * Set detail cell
     *
     * @param string $name  Cell code
     * @param mixed  $value Cell value
     * @param string $label Cell label OPTIONAL
     *
     * @return void
     */
    public function setDetail($name, $value, $label = null)
    {
        $detail = $this->getDetail($name);

        if (!$detail) {
            $detail = new \XLite\Model\OrderDetail();

            $detail->setOrder($this);
            $this->addDetails($detail);

            $detail->setName($name);
        }

        $detail->setValue($value);
        $detail->setLabel($label);
    }

    /**
     * Get meaning order details
     *
     * @return array
     */
    public function getMeaningDetails()
    {
        $result = array();

        foreach ($this->getDetails() as $detail) {
            if ($detail->getLabel()) {
                $result[] = $detail;
            }
        }

        return $result;
    }

    /**
     * Called when an order successfully placed by a client
     *
     * @return void
     */
    public function processSucceed()
    {
        // send email notification about initially placed order
        $status = $this->getStatus();

        $list = array(self::STATUS_AUTHORIZED, self::STATUS_PROCESSED, self::STATUS_COMPLETED, self::STATUS_INPROGRESS);

        if (!in_array($status, $list)) {

            \XLite\Core\Mailer::getInstance()->sendOrderCreated($this);
        }

        $this->markAsOrder();
    }

    /**
     * Mark cart as order
     *
     * @return void
     */
    public function markAsOrder()
    {
    }

    /**
     * Refresh order items
     * TODO - rework after tax subsystem rework
     *
     * @return void
     */
    public function refreshItems()
    {
    }

    /**
     * Constructor
     *
     * @param array $data Entity properties OPTIONAL
     *
     * @return void
     */
    public function __construct(array $data = array())
    {
        $this->details              = new \Doctrine\Common\Collections\ArrayCollection();
        $this->items                = new \Doctrine\Common\Collections\ArrayCollection();
        $this->surcharges           = new \Doctrine\Common\Collections\ArrayCollection();
        $this->payment_transactions = new \Doctrine\Common\Collections\ArrayCollection();
        $this->events               = new \Doctrine\Common\Collections\ArrayCollection();

        parent::__construct($data);
    }

    /**
     * Return list of available payment methods
     *
     * @return array
     */
    public function getPaymentMethods()
    {
        $list = \XLite\Core\Database::getRepo('XLite\Model\Payment\Method')
            ->findAllActive();

        foreach ($list as $i => $method) {
            if (!$method->isEnabled() || !$method->getProcessor()->isApplicable($this, $method)) {
                unset($list[$i]);
            }
        }

        return $list;
    }

    /**
     * Renew payment method
     *
     * @return void
     */
    public function renewPaymentMethod()
    {
        $method = $this->getPaymentMethod();

        if ($method && $method->getProcessor() && $method->getProcessor()->isApplicable($this, $method)) {
            $this->setPaymentMethod($method);

        } else {
            $first = $this->getFirstPaymentMethod();
            if ($first) {
                if ($this->getProfile()) {
                    $this->getProfile()->setLastPaymentId($first->getMethodId());
                }

                $this->setPaymentMethod($first);

            } else {
                $this->unsetPaymentMethod();
            }
        }
    }

    /**
     * Get payment method
     *
     * @return \XLite\Model\Payment\Method|void
     */
    public function getPaymentMethod()
    {
        $transaction = $this->getFirstOpenPaymentTransaction();
        if (!$transaction) {
            $transaction = $this->hasUnpaidTotal() || 0 == count($this->getPaymentTransactions())
                ? $this->assignLastPaymentMethod()
                : $this->getPaymentTransactions()->last();
        }

        return $transaction ? $transaction->getPaymentMethod() : null;
    }

    /**
     * Check item key equal
     *
     * @param \XLite\Model\OrderItem $item Item
     * @param string                 $key  Key
     *
     * @return boolean
     */
    public function checkItemKeyEqual(\XLite\Model\OrderItem $item, $key)
    {
        return $item->getKey() == $key;
    }

    /**
     * Check item id equal
     *
     * @param \XLite\Model\OrderItem $item   Item
     * @param integer                $itemId Item id
     *
     * @return boolean
     */
    public function checkItemIdEqual(\XLite\Model\OrderItem $item, $itemId)
    {
        return $item->getItemId() == $itemId;
    }

    /**
     * Check order detail name
     *
     * @param \XLite\Model\OrderDetail $detail Detail
     * @param string                   $name   Name
     *
     * @return boolean
     */
    public function checkDetailName(\XLite\Model\OrderDetail $detail, $name)
    {
        return $detail->getName() == $name;
    }

    /**
     * Check payment transaction status
     *
     * @param \XLite\Model\Payment\Transaction $transaction Transaction
     * @param mixed                            $status      Status
     *
     * @return void
     */
    public function checkPaymentTransactionStatusEqual(\XLite\Model\Payment\Transaction $transaction, $status)
    {
        return is_array($status)
            ? in_array($transaction->getStatus(), $status)
            : $transaction->getStatus() == $status;
    }

    /**
     * Check payment transaction - open or not
     *
     * @param \XLite\Model\Payment\Transaction $transaction Payment transaction
     *
     * @return boolean
     */
    public function checkPaymentTransactionOpen(\XLite\Model\Payment\Transaction $transaction)
    {
        return $transaction->isOpen();
    }

    /**
     * Check - is item product id equal specified product id
     *
     * @param \XLite\Model\OrderItem $item      Item
     * @param integer                $productId Product id
     *
     * @return boolean
     */
    public function isItemProductIdEqual(\XLite\Model\OrderItem $item, $productId)
    {
        return $item->getProduct()->getProductId() == $productId;
    }

    /**
     * Check last payment method
     *
     * @param \XLite\Model\Payment\Method $pmethod       Payment method
     * @param integer                     $lastPaymentId Last selected payment method id
     *
     * @return boolean
     */
    public function checkLastPaymentMethod(\XLite\Model\Payment\Method $pmethod, $lastPaymentId)
    {
        $result = $pmethod->getMethodId() == $lastPaymentId;
        if ($result) {
            $this->setPaymentMethod($pmethod);
        }

        return $result;
    }

    // {{{ Payment method and transactions

    /**
     * Set payment method
     *
     * @param \XLite\Model\Payment\Method $paymentMethod Payment method
     * @param float                       $value         Payment transaction value OPTIONAL
     *
     * @return void
     */
    public function setPaymentMethod($paymentMethod, $value = null)
    {
        if (isset($paymentMethod) && !($paymentMethod instanceof \XLite\Model\Payment\Method)) {
            $paymentMethod = null;
        }

        if (!isset($paymentMethod) || $this->getFirstOpenPaymentTransaction()) {
            $transaction = $this->getFirstOpenPaymentTransaction();
            if ($transaction) {
                if ($transaction->isSameMethod($paymentMethod)) {
                    $transaction->updateValue($this);
                    unset($paymentMethod);

                } elseif (!isset($paymentMethod)) {
                    $this->unsetPaymentMethod();
                }
            }
        }

        if (isset($paymentMethod)) {
            $this->unsetPaymentMethod();
            $this->addPaymentTransaction($paymentMethod, $value);
        }
    }

    /**
     * Unset payment method
     *
     * @return void
     */
    public function unsetPaymentMethod()
    {
        $transaction = $this->getFirstOpenPaymentTransaction();

        if ($transaction) {
            $this->getPaymentTransactions()->removeElement($transaction);
            $transaction->getPaymentMethod()->getTransactions()->removeElement($transaction);
            \XLite\Core\Database::getEM()->remove($transaction);
        }
    }

    /**
     * Get active payment transactions
     *
     * @return array
     */
    public function getActivePaymentTransactions()
    {
        $result = array();
        foreach ($this->getPaymentTransactions() as $t) {
            if ($t->isCompleted() || $t->isPending()) {
                $result[] = $t;
            }
        }

        return $result;
    }

    /**
     * Get visible payment methods
     *
     * @return array
     */
    public function getVisiblePaymentMethods()
    {
        $result = array();

        foreach ($this->getActivePaymentTransactions() as $t) {
            $result[] = $t->getPaymentMethod();
        }

        if (0 == count($result) && 0 < count($this->getPaymentTransactions())) {
            $result[] = $this->getPaymentTransactions()->last()->getPaymentMethod();
        }

        return $result;
    }

    /**
     * Get first open (not payed) payment transaction
     *
     * @return \XLite\Model\Payment\Transaction|void
     */
    public function getFirstOpenPaymentTransaction()
    {
        $transactions = $this->getPaymentTransactions();

        return \Includes\Utils\ArrayManager::findValue(
            $transactions,
            array($this, 'checkPaymentTransactionOpen')
        );
    }

    /**
     * Get open (not-payed) total
     *
     * @return float
     */
    public function getOpenTotal()
    {
        $total = $this->getCurrency()->roundValue($this->getTotal());

        foreach ($this->getPaymentTransactions() as $t) {
            $total -= $this->getCurrency()->roundValue($t->getChargeValueModifier());
        }

        return $total;
    }

    /**
     * Check - order is open (has initialized transactions and has open total) or not
     *
     * @return boolean
     */
    public function isOpen()
    {
        return $this->getFirstOpenPaymentTransaction() && $this->hasUnpaidTotal();
    }

    /**
     * Has unpaid total?
     *
     * @return boolean
     */
    public function hasUnpaidTotal()
    {
        return $this->getCurrency()->getMinimumValue() < $this->getCurrency()->roundValue(abs($this->getOpenTotal()));
    }

    /**
     * Get totally payed total
     *
     * @return float
     */
    public function getPayedTotal()
    {
        $total = $this->getCurrency()->roundValue($this->getTotal());

        foreach ($this->getPaymentTransactions() as $t) {
            if ($t->isCompleted() && ($t->isAuthorized() || $t->isCaptured())) {
                $total -= $this->getCurrency()->roundValue($t->getChargeValueModifier());
            }
        }

        $sums = $this->getPaymentTransactionSums();
        if (!empty($sums[static::t('Refunded amount')])) {
            $total += $sums[static::t('Refunded amount')];
        }

        return $total;
    }

    /**
     * Check - order is payed or not
     * Payed - order has not open total and all payment transactions are failed or completed
     *
     * @return boolean
     */
    public function isPayed()
    {
        return 0 >= $this->getPayedTotal();
    }

    /**
     * Check - order has in-progress payments or not
     *
     * @return boolean
     */
    public function hasInprogressPayments()
    {
        $result = false;

        foreach ($this->getPaymentTransactions() as $t) {
            if ($t->isInProgress()) {
                $result = true;
                break;
            }
        }

        return $result;
    }

    /**
     * Assign last used payment method
     *
     * @return \XLite\Model\Payment\Transaction|void
     */
    protected function assignLastPaymentMethod()
    {
        $found = null;

        if ($this->getProfile() && $this->getProfile()->getLastPaymentId()) {
            $paymentMethods = $this->getPaymentMethods();
            $found = \Includes\Utils\ArrayManager::findValue(
                $paymentMethods,
                array($this, 'checkLastPaymentMethod'),
                $this->getProfile()->getLastPaymentId()
            );
        }

        return $found ? $this->getFirstOpenPaymentTransaction() : null;
    }

    /**
     * Get first applicable payment method
     *
     * @return \XLite\Model\Payment\Method
     */
    protected function getFirstPaymentMethod()
    {
        $list = $this->getPaymentMethods();

        return $list ? array_shift($list) : null;
    }

    /**
     * Add payment transaction
     * FIXME: move logic into \XLite\Model\Payment\Transaction
     *
     * @param \XLite\Model\Payment\Method $method Payment method
     * @param float                       $value  Value OPTIONAL
     *
     * @return void
     */
    protected function addPaymentTransaction(\XLite\Model\Payment\Method $method, $value = null)
    {
        if (!isset($value) || 0 >= $value) {
            $value = $this->getOpenTotal();

        } else {
            $value = min($value, $this->getOpenTotal());
        }

        // Do not add 0 or <0 transactions. This is for a "Payment not required" case.
        if ($value > 0) {

            $transaction = new \XLite\Model\Payment\Transaction();

            $transaction->setPaymentMethod($method);
            $method->addTransactions($transaction);

            \XLite\Core\Database::getEM()->persist($method);

            $this->addPaymentTransactions($transaction);
            $transaction->setOrder($this);

            $transaction->setMethodName($method->getServiceName());
            $transaction->setMethodLocalName($method->getName());
            $transaction->setStatus($transaction::STATUS_INITIALIZED);
            $transaction->setValue($value);
            $transaction->setType($method->getProcessor()->getInitialTransactionType($method));

            if ($method->getProcessor()->isTestMode($method)) {
                $transaction->setDataCell(
                    'test_mode',
                    true,
                    'Test mode'
                );
            }

            \XLite\Core\Database::getEM()->persist($transaction);
        }
    }

    // }}}

    // {{{ Shippings

    /**
     * Renew shipping method
     *
     * @return void
     */
    public function renewShippingMethod()
    {
        $modifier = $this->getModifier(\XLite\Model\Base\Surcharge::TYPE_SHIPPING, 'SHIPPING');
        if ($modifier) {
            $this->setShippingId(0);
            $rate = $modifier->getSelectedRate();
            if (!$rate) {
                $method = $this->getFirtstShippingMethod();
                if ($method) {
                    if ($this->getProfile()) {
                        $this->getProfile()->setLastShippingId($method->getMethodId());
                    }

                    $this->setShippingId($method->getMethodId());
                }
            }
        }
    }

    /**
     * Get firtst shipping method
     *
     * @return \XLite\Model\Shipping\Method
     */
    protected function getFirtstShippingMethod()
    {
        $method = null;

        $modifier = $this->getModifier(\XLite\Model\Base\Surcharge::TYPE_SHIPPING, 'SHIPPING');
        if ($modifier) {
            $rates = $modifier->getRates();
            $rate = array_shift($rates);
            if ($rate) {
                $method = $rate->getMethod();
            }
        }

        return $method;
    }

    // }}}

    // {{{ Mail notification

    /**
     * Called when an order becomes processed, before saving it to the database
     *
     * @return void
     */
    protected function sendProcessMail()
    {
        $mail = new \XLite\View\Mailer();
        $mail->order = $this;
        $mail->adminMail = true;
        $mail->compose(
            \XLite\Core\Config::getInstance()->Company->site_administrator,
            \XLite\Core\Config::getInstance()->Company->orders_department,
            'order_processed'
        );
        $mail->send();

        $mail->adminMail = false;
        $mail->selectCustomerLayout();
        $profile = $this->getProfile();
        if ($profile) {
            $mail->compose(
                \XLite\Core\Config::getInstance()->Company->orders_department,
                $profile->getLogin(),
                'order_processed'
            );
            $mail->send();
        }
    }

    /**
     * Called when the order status changed to failed
     *
     * @return void
     */
    protected function sendFailMail()
    {
        $mail = new \XLite\View\Mailer();
        $mail->order = $this;
        $mail->adminMail = true;
        $mail->compose(
            \XLite\Core\Config::getInstance()->Company->site_administrator,
            \XLite\Core\Config::getInstance()->Company->orders_department,
            'order_failed'
        );
        $mail->send();

        $mail->adminMail = false;
        $mail->selectCustomerLayout();
        $profile = $this->getProfile();
        if ($profile) {
            $mail->compose(
                \XLite\Core\Config::getInstance()->Company->orders_department,
                $profile->getLogin(),
                'order_failed'
            );
            $mail->send();
        }
    }

    // }}}

    // {{{ Calculation

    /**
     * Get modifiers
     *
     * @return \XLite\DataSet\Collection\OrderModifier
     */
    public function getModifiers()
    {
        if (!isset($this->modifiers)) {
            $this->modifiers = \XLite\Core\Database::getRepo('XLite\Model\Order\Modifier')->findActive();

            // Initialize
            foreach ($this->modifiers as $modifier) {
                $modifier->initialize($this, $this->modifiers);
            }

            // Preprocess modifiers
            foreach ($this->modifiers as $modifier) {
                $modifier->preprocess();
            }
        }

        return $this->modifiers;
    }

    /**
     * Get modifier
     *
     * @param string $type Modifier type
     * @param string $code Modifier code
     *
     * @return \XLite\Model\Order\Modifier
     */
    public function getModifier($type, $code)
    {
        $result = null;

        foreach ($this->getModifiers() as $modifier) {
            if ($modifier->getType() == $type && $modifier->getCode() == $code) {
                $result = $modifier;
                break;
            }
        }

        return $result;
    }

    /**
     * Check - modifier is exists or not (by type)
     *
     * @param string $type Type
     *
     * @return boolean
     */
    public function isModifierByType($type)
    {
        $result = false;

        foreach ($this->getModifiers() as $modifier) {
            if ($modifier->getType() == $type) {
                $result = true;
                break;
            }
        }

        return $result;
    }

    /**
     * Get modifiers by type
     *
     * @param string $type Modifier type
     *
     * @return array
     */
    public function getModifiersByType($type)
    {
        $list = array();

        foreach ($this->getModifiers() as $modifier) {
            if ($modifier->getType() == $type) {
                $list[] = $modifier;
            }
        }

        return $list;
    }

    /**
     * Get items exclude surcharges info
     *
     * @return array
     */
    public function getItemsExcludeSurcharges()
    {
        $list = array();

        foreach ($this->getItems() as $item) {
            foreach ($item->getExcludeSurcharges() as $surcharge) {
                if (!isset($list[$surcharge->getKey()])) {
                    $list[$surcharge->getKey()] = $surcharge->getName();
                }
            }
        }

        return $list;
    }

    /**
     * Get items included surcharges totals
     *
     * @return array
     */
    public function getItemsIncludeSurchargesTotals()
    {
        $list = array();

        foreach ($this->getItems() as $item) {
            foreach ($item->getExcludeSurcharges() as $surcharge) {
                if (!isset($list[$surcharge->getKey()])) {
                    $list[$surcharge->getKey()] = array(
                        'surcharge' => $surcharge,
                        'cost'      => 0,
                    );
                }

                $list[$surcharge->getKey()]['cost'] += $surcharge->getValue();
            }
        }

        return $list;

    }

    /**
     * Common method to update cart/order
     *
     * @return void
     */
    public function updateOrder()
    {
        $total = $this->getTotal();

        $this->normalizeItems();

        // If shipping method is not selected or shipping conditios is changed (remove order items or changed address)
        $this->renewShippingMethod();

        $this->calculate();

        $this->renewPaymentMethod();
    }

    /**
     * Calculate order
     *
     * @return void
     */
    public function calculate()
    {
        $oldSurcharges = $this->resetSurcharges();

        $this->reinitializeCurrency();

        $this->calculateInitialValues();

        foreach ($this->getModifiers() as $modifier) {
            if ($modifier->canApply()) {
                $modifier->calculate();
            }
        }

        $this->mergeSurcharges($oldSurcharges);

        $this->finalizeItemsCalculation();

        $this->setTotal($this->getSurchargesTotal());
    }

    /**
     * Renew order
     *
     * @return void
     */
    public function renew()
    {
        foreach ($this->getItems() as $item) {
            if (!$item->renew()) {
                $this->getItems()->removeElement($item);
                \XLite\Core\Database::getRepo('XLite\Model\OrderItem')->delete($item);
            }
        }

        $this->calculate();
    }

    /**
     * Soft renew
     *
     * @return void
     */
    public function renewSoft()
    {
        $this->reinitializeCurrency();
    }

    /**
     * Reinitialize currency
     *
     * @return void
     */
    protected function reinitializeCurrency()
    {
        $new = $this->defineCurrency();
        $old = $this->getCurrency();

        if (empty($old) || (!empty($new) && $old->getCode() !== $new->getCode())) {
            $this->setCurrency($new);
        }
    }

    /**
     * Define order currency
     *
     * @return \XLite\Model\Currency
     */
    protected function defineCurrency()
    {
        return \XLite::getInstance()->getCurrency();
    }

    /**
     * Reset surcharges list
     *
     * @return array
     */
    public function resetSurcharges()
    {
        $result = array(
            'items' => array(),
        );

        foreach ($this->getItems() as $item) {
            $result['items'][$item->getItemId()] = $item->resetSurcharges();
        }

        $result['surcharges'] = parent::resetSurcharges();

        return $result;
    }

    /**
     * Merge surcharges
     *
     * @param array $oldSurcharges Old surcharges
     *
     * @return void
     */
    protected function mergeSurcharges(array $oldSurcharges)
    {
        foreach ($this->getItems() as $item) {
            if (!empty($oldSurcharges['items'][$item->getItemId()])) {
                $item->compareSurcharges($oldSurcharges['items'][$item->getItemId()]);
            }
        }

        $this->compareSurcharges($oldSurcharges['surcharges']);
    }

    /**
     * Calculate initial order values
     *
     * @return void
     */
    protected function calculateInitialValues()
    {
        $subtotal = 0;

        foreach ($this->getItems() as $item) {
            $item->calculate();

            $subtotal += $item->getSubtotal();
        }

        $subtotal = $this->getCurrency()->roundValue($subtotal);

        $this->setSubtotal($subtotal);
        $this->setTotal($subtotal);
    }

    /**
     * Finalize items calculation
     *
     * @return void
     */
    protected function finalizeItemsCalculation()
    {
        $subtotal = 0;
        foreach ($this->getItems() as $item) {
            $itemTotal = $item->calculateTotal();
            $subtotal += $itemTotal;
            $item->setTotal($itemTotal);
        }

        $this->setSubtotal($subtotal);
        $this->setTotal($subtotal);
    }

    // }}}

    // {{{ Surcharges

    /**
     * Get surcharges by type
     *
     * @param string $type Surcharge type
     *
     * @return array
     */
    public function getSurchargesByType($type)
    {
        $list = array();

        foreach ($this->getSurcharges() as $surcharge) {
            if ($surcharge->getType() == $type) {
                $list[] = $surcharge;
            }
        }

        return $list;
    }

    /**
     * Get surcharges subtotal with specified type
     *
     * @param string  $type    Surcharge type OPTIONAL
     * @param boolean $include Surcharge include flag OPTIONAL
     *
     * @return float
     */
    public function getSurchargesSubtotal($type = null, $include = null)
    {
        $surcharges = $type
            ? $this->getSurchargesByType($type)
            : $this->getSurcharges();

        $subtotal = 0;

        foreach ($surcharges as $surcharge) {
            if ($surcharge->getAvailable() && (!isset($include) || $surcharge->getInclude() == $include)) {
                $subtotal += $this->getCurrency()->roundValue($surcharge->getValue());
            }
        }

        return $subtotal;
    }

    /**
     * Get surcharges total with specified type
     *
     * @param string $type Surcharge type OPTIONAL
     *
     * @return float
     */
    public function getSurchargesTotal($type = null)
    {
        return $this->getSubtotal() + $this->getSurchargesSubtotal($type, false);
    }

    // }}}

    // {{{ Lifecycle callbacks

    /**
     * Prepare order before save data operation
     *
     * @return void
     *
     * @PrePersist
     * @PreUpdate
     */
    public function prepareBeforeSave()
    {
        if (!is_numeric($this->date) || !is_int($this->date)) {
            $this->setDate(\XLite\Core\Converter::time());
        }

        $this->setLastRenewDate(\XLite\Core\Converter::time());
    }

    /**
     * Prepare order before remove operation
     *
     * @return void
     */
    public function prepareBeforeRemove()
    {
        if (in_array($this->getStatus(), array(static::STATUS_QUEUED, static::STATUS_INPROGRESS))) {
            $this->setStatus(self::STATUS_DECLINED);
        }
    }

    /**
     * Since Doctrine lifecycle callbacks do not allow to modify associations, we've added this method
     *
     * @param string $type Type of current operation
     *
     * @return void
     */
    public function prepareEntityBeforeCommit($type)
    {
        if (static::ACTION_DELETE == $type) {
            $this->prepareBeforeRemove();
        }
    }

    // }}}

    // {{{ Change status routine

    /**
     * Set status
     *
     * @param string $value Status code
     *
     * @return void
     */
    public function setStatus($value)
    {
        $this->oldStatus = $this->status != $value ? $this->status : null;

        $this->status = $value;

        if ($this->oldStatus && $this->isPersistent()) {
            $this->changeStatusPostprocess($this->oldStatus, $this->status);
        }

        // TODO - rework
        //$this->refresh('shippingRates');
    }

    /**
     * Return base part of the certain "change status" handler name
     *
     * @param string $old Old order status
     * @param string $new New order status
     *
     * @return string|array
     */
    protected function getStatusHandlers($old, $new)
    {
        return isset(static::$statusHandlers[$old][$new])
            ? static::$statusHandlers[$old][$new]
            : array();
    }

    /**
     * Postprocess status changes
     *
     * @param string $old Old status
     * @param string $new New status
     *
     * @return void
     */
    protected function changeStatusPostprocess($old, $new)
    {
        \XLite\Core\OrderHistory::getInstance()->registerOrderChangeStatus(
            $this->getOrderId(),
            array(
                'old' => $old,
                'new' => $new,
            )
        );

        foreach ($this->getStatusHandlers($old, $new) as $handler) {
            $this->{'process' . ucfirst($handler)}();
        }
    }

    /**
     * A "change status" handler
     *
     * @return void
     */
    protected function processCheckout()
    {
        // Transform attributes
        foreach ($this->getItems() as $item) {
            if ($item->hasAttributeValues()) {
                foreach ($item->getAttributeValues() as $av) {
                    if ($av->getAttributeValue()) {
                        $attributeValue = $av->getAttributeValue();
                        $av->setName($attributeValue->getAttribute()->getName());
                        $av->setValue($attributeValue->asString());
                        $av->setAttributeId($attributeValue->getAttribute()->getId());
                        $av->setAttributeValueId($attributeValue->getId());
                        $method = 'setAttributeValue' . $attributeValue->getAttribute()->getType();
                        if (method_exists($av, $method)) {
                            $av->{$method}(null);
                        }
                    }
                }
            }
        }
    }

    /**
     * A "change status" handler
     *
     * @return void
     */
    protected function processDecrease()
    {
        $this->decreaseInventory();
    }

    /**
     * A "change status" handler
     *
     * @return void
     */
    protected function processUncheckout()
    {
    }

    /**
     * A "change status" handler
     *
     * @return void
     */
    protected function processQueue()
    {
    }

    /**
     * A "change status" handler
     *
     * @return void
     */
    protected function processAuthorize()
    {
    }

    /**
     * A "change status" handler
     *
     * @return void
     */
    protected function processProcess()
    {
        \XLite\Core\Mailer::getInstance()->sendProcessOrder($this);
    }

    /**
     * A "change status" handler
     *
     * @return void
     */
    protected function processShip()
    {
        \XLite\Core\Mailer::getInstance()->sendShippedOrder($this);
    }

    /**
     * A "change status" handler
     *
     * @return void
     */
    protected function processIncrease()
    {
        $this->increaseInventory();
    }

    /**
     * A "change status" handler
     *
     * @return void
     */
    protected function processDecline()
    {
    }

    /**
     * A "change status" handler
     *
     * @return void
     */
    protected function processFail()
    {
        \XLite\Core\Mailer::getInstance()->sendFailedOrder($this);
    }

    /**
     * A "change status" handler
     *
     * @return void
     */
    protected function processCancel()
    {
        \XLite\Core\Mailer::getInstance()->sendCanceledOrder($this);
    }

    // }}}

    // {{{ Inventory tracking

    /**
     * Get item inventory delta
     *
     * @param \XLite\Model\OrderItem $item Current item
     * @param integer                $sign Flag; "1" or "-1"
     *
     * @return integer
     */
    protected function getItemInventoryAmount(\XLite\Model\OrderItem $item, $sign)
    {
        return $sign * $item->getAmount();
    }

    /**
     * Increase / decrease item products inventory
     *
     * @param integer $sign Flag; "1" or "-1"
     *
     * @return void
     */
    protected function changeItemsInventory($sign)
    {
        $history = \XLite\Core\OrderHistory::getInstance();
        $orderId = $this->getOrderId();

        foreach ($this->getItems() as $item) {
            $amount = $this->getItemInventoryAmount($item, $sign);

            $history->registerChangeAmount($orderId, $item->getProduct(), $amount);
            $item->changeAmount($amount);
        }
    }

    /**
     * Order processed: decrease products inventory
     *
     * @return void
     */
    protected function decreaseInventory()
    {
        $this->changeItemsInventory(-1);
    }

    /**
     * Order declined: increase products inventory
     *
     * @return void
     */
    protected function increaseInventory()
    {
        $this->changeItemsInventory(1);
    }

    // }}}

    // {{{ Order actions

    /**
     * Get allowed actions
     *
     * @return array
     */
    public function getAllowedActions()
    {
        return array();
    }

    /**
     * Get allowed payment actions
     *
     * @return array
     */
    public function getAllowedPaymentActions()
    {
        $actions = array();

        $transactions = $this->getPaymentTransactions();

        if ($transactions) {

            foreach ($transactions as $transaction) {

                $processor = $transaction->getPaymentMethod()->getProcessor();

                if ($processor) {

                    $allowedTransactions = $processor->getAllowedTransactions();

                    foreach ($allowedTransactions as $transactionType) {
                        if ($processor->isTransactionAllowed($transaction, $transactionType)) {
                            $actions[$transactionType] = $transaction->getTransactionId();
                        }
                    }
                }
            }
        }

        return $actions;
    }

    /**
     * Get array of payment transaction sums (how much is authorized, captured and refunded)
     *
     * @return array
     */
    public function getPaymentTransactionSums()
    {
        static $paymentTransactionSums = null;

        if (!isset($paymentTransactionSums)) {

            $transactions = $this->getPaymentTransactions();

            $authorized = 0;
            $captured = 0;
            $refunded = 0;

            foreach ($transactions as $t) {

                foreach ($t->getBackendTransactions() as $bt) {

                    if ($bt->isCompleted()) {

                        switch($bt->getType()) {
                            case $bt::TRAN_TYPE_AUTH:
                                $authorized += $bt->getValue();
                                break;

                            case $bt::TRAN_TYPE_SALE:
                            case $bt::TRAN_TYPE_CAPTURE:
                            case $bt::TRAN_TYPE_CAPTURE_PART:
                                $captured += $bt->getValue();
                                $authorized -= $bt->getValue();
                                break;

                            case $bt::TRAN_TYPE_REFUND:
                            case $bt::TRAN_TYPE_REFUND_PART:
                                $refunded += $bt->getValue();
                                $captured -= $bt->getValue();
                                break;

                            case $bt::TRAN_TYPE_VOID:
                            case $bt::TRAN_TYPE_VOID_PART:
                                $authorized -= $bt->getValue();
                        }
                    }
                }
            }

            $paymentTransactionSums = array(
                static::t('Authorized amount') => $authorized,
                static::t('Captured amount')   => $captured,
                static::t('Refunded amount')   => $refunded,
            );

            // Remove from array all zero sums
            foreach ($paymentTransactionSums as $k => $v) {
                if (0 >= $v) {
                    unset($paymentTransactionSums[$k]);
                }
            }
        }

        return $paymentTransactionSums;
    }

    // }}}
}
