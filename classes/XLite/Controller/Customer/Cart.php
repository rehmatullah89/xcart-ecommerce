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

namespace XLite\Controller\Customer;

/**
 * \XLite\Controller\Customer\Cart
 */
class Cart extends \XLite\Controller\Customer\ACustomer
{
    /**
     * Cache of the product model
     *
     * @var \XLite\Model\Product
     */
    protected $product;

    /**
     * Cache of the added order model
     *
     * @var \XLite\Model\Order
     */
    protected $addedOrder;

    /**
     * Initialize controller
     *
     * @return void
     */
    public function init()
    {
        parent::init();

        $this->checkItemsAmount();
    }

    /**
     * Get page title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->getCart()->isEmpty()
            ? 'Your shopping bag is empty'
            : static::t('Your shopping bag - X items', array('count' => $this->getCart()->countQuantity()));
    }

    /**
     * Get continue shopping URL
     *
     * @return string
     */
    public function getContinueShoppingURL()
    {
        return \XLite\Core\Session::getInstance()->continueURL
            ? \XLite::getInstance()->getShopURL(\XLite\Core\Session::getInstance()->continueURL)
            : parent::getContinueShoppingURL();
    }

    /**
     * Controller marks the cart calculation.
     * We need cart recalculation if we go to the cart page directly
     *
     * @return boolean
     */
    protected function markCartCalculate()
    {
        return !$this->getAction();
    }

    /**
     * Get cart fingerprint exclude keys
     *
     * @return array
     */
    protected function getCartFingerprintExclude()
    {
        return array('shippingMethodsHash', 'paymentMethodsHash', 'shippingMethodId', 'paymentMethodId', 'shippingTotal');
    }

    /**
     * isSecure
     * TODO: check if this method is used
     *
     * @return void
     */
    public function isSecure()
    {
        return $this->is('HTTPS') ? true : parent::isSecure();
    }

    /**
     * Check - is top 'Continue Shopping' button is visible or not
     *
     * @return boolean
     */
    public function isContinueShoppingVisible()
    {
        return true;
    }

    /**
     * Common method to determine current location
     *
     * @return string
     */
    protected function getLocation()
    {
        return $this->getTitle();
    }

    /**
     * Return current product Id
     *
     * @return integer
     */
    protected function getCurrentProductId()
    {
        return intval(\XLite\Core\Request::getInstance()->product_id);
    }

    /**
     * Return product amount
     *
     * @return integer
     */
    protected function getCurrentAmount()
    {
        return intval(\XLite\Core\Request::getInstance()->amount);
    }

    /**
     * Check - amount is set into request data or not
     *
     * @return boolean
     */
    protected function isSetCurrentAmount()
    {
        return isset(\XLite\Core\Request::getInstance()->amount);
    }

    /**
     * Return current product class for further adding to cart
     *
     * @return \XLite\Model\Product
     */
    protected function getCurrentProduct()
    {
        if (is_null($this->product)) {
            $this->product = \XLite\Core\Database::getRepo('XLite\Model\Product')->find($this->getCurrentProductId());
        }
        return ($this->product && $this->product->isAvailable()) ? $this->product : null;
    }

    /**
     * Get available amount for the product
     *
     * @param \XLite\Model\OrderItem $item Order item to add
     *
     * @return integer
     */
    protected function getProductAvailableAmount(\XLite\Model\OrderItem $item)
    {
        $inventory = $item->getProduct()->getInventory();

        return $inventory->getEnabled()
            ? $inventory->getAmount()
            : $inventory->getDefaultAmount();
    }

    /**
     * Check if the requested amount is available for the product
     *
     * @param \XLite\Model\OrderItem $item   Order item to add
     * @param integer                $amount Amount to check OPTIONAL
     *
     * @return integer
     */
    protected function checkAmount(\XLite\Model\OrderItem $item, $amount = null)
    {
        return !$item->getProduct()->getInventory()->getEnabled();
    }

    /**
     * Check product amount before add it to the cart
     *
     * @param \XLite\Model\OrderItem $item   Order item to add
     * @param integer                $amount Amount OPTIONAL
     *
     * @return boolean
     */
    protected function checkAmountToAdd(\XLite\Model\OrderItem $item, $amount = null)
    {
        return $this->checkAmount($item)
            || $this->getProductAvailableAmount($item) >= $amount;
    }

    /**
     * Check product amount before update it in the cart
     *
     * @param \XLite\Model\OrderItem $item   Order item to add
     * @param integer                $amount Amount OPTIONAL
     *
     * @return boolean
     */
    protected function checkAmountToUpdate(\XLite\Model\OrderItem $item, $amount = null)
    {
        return $this->checkAmount($item)
            || ($this->getProductAvailableAmount($item) + $item->getAmount()) >= $amount;
    }

    /**
     * Check amount for all cart items
     *
     * @return void
     */
    protected function checkItemsAmount()
    {
        foreach ($this->getCart()->getItemsWithWrongAmounts() as $item) {
            $this->processInvalidAmountError($item);
        }
    }

    /**
     * Correct product amount to add to cart.
     * Common correction amount of order item as a product unit
     * irrespective of customer selections or order conditions (options/variants/offers)
     *
     * @param \XLite\Model\Product $product Product to add
     * @param integer|null         $amount  Amount of product.
     *                                      Null is given when there is no amount in request.
     *
     * @return integer
     */
    protected function correctAmountAsProduct(\XLite\Model\Product $product, $amount)
    {
        if (is_null($amount)) {
            $amount = $product->getInventory()
                ? $product->getInventory()->getLowAvailableAmount()
                : 1;
        }

        return $amount;
    }

    /**
     * Correct product amount to add to cart
     *
     * @param \XLite\Model\OrderItem $item   Product to add
     * @param integer                $amount Amount of product
     *
     * @return integer
     */
    protected function correctAmountToAdd(\XLite\Model\OrderItem $item, $amount)
    {
        $amount = $this->correctAmountAsProduct($item->getProduct(), $amount);

        if (!$this->checkAmountToAdd($item, $amount)) {
            $this->processInvalidAmountError($item);
        }

        return $amount;
    }

    /**
     * Get (and create) current cart item.
     * Order item is changed according \XLite\Core\Request
     * (according customer request to add some specific features to item in cart. for example - options/variants/offers and so on)
     *
     * @return \XLite\Model\OrderItem
     */
    protected function getCurrentItem()
    {
        return $this->prepareOrderItem(
            $this->getCurrentProduct(),
            $this->isSetCurrentAmount() ? $this->getCurrentAmount() : null
        );
    }

    /**
     * Prepare order item class for adding to cart.
     * This method takes \XLite\Model\Product class and amount and creates \XLite\Model\OrderItem.
     * This order item container will be added to cart in $this->addItem() method.
     *
     * @param \XLite\Model\Product|null $product Product class to add to cart
     * @param integer                   $amount  Amount of product to add to cart
     *
     * @return \XLite\Model\OrderItem
     */
    protected function prepareOrderItem($product, $amount)
    {
        $item = null;

        if ($product) {
            $item = new \XLite\Model\OrderItem();
            $item->setOrder($this->getCart());
            $item->setAttributeValues($product->prepareAttributeValues(\XLite\Core\Request::getInstance()->attribute_values));
            $item->setProduct($product);

            // We make amount correction if there is no such product with additional specifications
            // which are provided in order item container
            $newAmount = $this->correctAmountToAdd($item, $amount);

            if (0 < $newAmount) {
                $item->setAmount($newAmount);
            } else {
                $item->setOrder(null);
                $item = null;
            }
        }

        return $item;
    }

    /**
     * Add order item to cart.
     * Additional correction of item amount is made before adding.
     *
     * @param \XLite\Model\OrderItem $item Order item
     *
     * @return boolean
     */
    protected function addItem($item)
    {
        return $item && $this->getCart()->addItem($item);
    }

    /**
     * Show message about wrong product amount
     *
     * @param \XLite\Model\OrderItem $item Order item
     *
     * @return void
     */
    protected function processInvalidAmountError(\XLite\Model\OrderItem $item)
    {
        \XLite\Core\TopMessage::addWarning(
            'You tried to buy more items of "{{product}}" product {{description}} than are in stock. We have {{amount}} item(s) only. Please adjust the product quantity.',
            array(
                'product'     => $item->getProduct()->getName(),
                'description' => $this->getItemDescription($item),
                'amount'      => $this->getProductAvailableAmount($item)
            )
        );
    }

    /**
     * Return item description
     *
     * @param \XLite\Model\OrderItem $item Order item
     *
     * @return string
     */
    protected function getItemDescription(\XLite\Model\OrderItem $item)
    {
        return '';
    }

    /**
     * Process 'Add item' error
     *
     * @return void
     */
    protected function processAddItemError()
    {
        if (\XLite\Model\Cart::NOT_VALID_ERROR == $this->getCart()->getAddItemError()) {
            \XLite\Core\TopMessage::addError('Product has not been added to cart');
        }
    }

    /**
     * Process 'Add item' success
     *
     * @return void
     */
    protected function processAddItemSuccess()
    {
        \XLite\Core\TopMessage::addInfo('Product has been added to cart');
    }

    /**
     * URL to return after product is added
     *
     * @return string
     */
    protected function getURLToReturn()
    {
        $url = \XLite\Core\Session::getInstance()->productListURL;

        if (!$url) {
            if (\XLite\Core\Request::getInstance()->returnURL) {
                $url = \XLite\Core\Request::getInstance()->returnURL;

            } elseif (!empty($_SERVER['HTTP_REFERER'])) {
                $url = $_SERVER['HTTP_REFERER'];

            } else {
                $url = $this->buildURL('product', '', array('product_id' => $this->getProductId()));
            }
        }

        return $url;
    }

    /**
     * URL to return after product is added
     *
     * @return string
     */
    protected function setURLToReturn()
    {
        \XLite\Core\Session::getInstance()->continueURL = $this->getURLToReturn();

        if (\XLite\Core\Config::getInstance()->General->redirect_to_cart) {
            // Hard redirect to cart
            $this->setReturnURL($this->buildURL('cart'));
            $this->setHardRedirect();

        } else {
            $this->setReturnURL($this->getURLToReturn());
        }
    }

    /**
     * Add product to cart
     *
     * @return void
     */
    protected function doActionAdd()
    {
        if (
            !\XLite\Core\Request::getInstance()->attribute_values
            && \XLite\Core\Config::getInstance()->General->force_choose_product_options
            && $this->getCurrentProduct()->hasMultipleAttributes()
        ) {
            $this->setReturnURL($this->buildURL(
                'product',
                '',
                array('product_id' => $this->getProductId())
            ));

        } else {
            // Add product to the cart and set a top message (if needed)
            $this->addItem($this->getCurrentItem())
                ? $this->processAddItemSuccess()
                : $this->processAddItemError();

            // Update cart
            $this->updateCart();

            // Set return URL
            $this->setURLToReturn();
        }
    }

    /**
     * Add products from the order to cart
     *
     * @return void
     */
    protected function doActionAddOrder()
    {
        $order = null;

        if (\XLite\Core\Request::getInstance()->order_id) {
            $order = \XLite\Core\Database::getRepo('\XLite\Model\Order')
                ->find(intval(\XLite\Core\Request::getInstance()->order_id));

        } elseif (\XLite\Core\Request::getInstance()->order_number) {
            $order = \XLite\Core\Database::getRepo('\XLite\Model\Order')
                ->findOneByOrderNumber(\XLite\Core\Request::getInstance()->order_number);
        }

        if (
            $order
            && (
                $order->getProfile()->getAnonymous()
                || (
                    \XLite\Core\Auth::getInstance()->isLogged()
                    && \XLite\Core\Auth::getInstance()->getProfile()->getProfileId() == $order->getOrigProfile()->getProfileId()
                )
            )
        ) {
            $this->addedOrder = $order;

            foreach ($order->getItems() as $item) {
                if ($item->isValidToClone()) {
                    $this->addItem($item->cloneEntity());
                }
            }

            $this->updateCart();
        }

        $this->setReturnURL($this->getURL());
    }

    // TODO: refactoring

    /**
     * 'delete' action
     *
     * @return void
     */
    protected function doActionDelete()
    {
        $item = $this->getCart()->getItemByItemId(\XLite\Core\Request::getInstance()->cart_id);

        if ($item) {
            $this->getCart()->getItems()->removeElement($item);
            \XLite\Core\Database::getEM()->remove($item);
            $this->updateCart();
            \XLite\Core\TopMessage::addInfo('Item has been deleted from cart');
        } else {
            $this->valid = false;

            \XLite\Core\TopMessage::addError(
                'Item has not been deleted from cart'
            );
        }
    }

    /**
     * Update cart
     *
     * @return void
     */
    protected function doActionUpdate()
    {
        // Update quantity
        $cartId = \XLite\Core\Request::getInstance()->cart_id;
        $amount = \XLite\Core\Request::getInstance()->amount;

        if (!is_array($amount)) {
            $amount = isset(\XLite\Core\Request::getInstance()->cart_id)
                ? array($cartId => $amount)
                : array();
        } elseif (isset($cartId)) {
            $amount = isset($amount[$cartId])
                ? array($cartId => $amount[$cartId])
                : array();
        }

        $result = false;

        foreach ($amount as $id => $quantity) {
            $item = $this->getCart()->getItemByItemId($id);
            if ($item) {
                $item->setAmount($quantity);
                $result = true;
            }
        }

        // Update shipping method
        if (isset(\XLite\Core\Request::getInstance()->shipping)) {
            $this->getCart()->setShippingId(\XLite\Core\Request::getInstance()->shipping);
            $result = true;
        }

        if ($result) {
            $this->updateCart();
        }
    }

    /**
     * 'checkout' action
     *
     * @return void
     */
    protected function doActionCheckout()
    {
        $this->doActionUpdate();

        // switch to checkout dialog
        $this->setReturnURL($this->buildURL('checkout'));
    }

    /**
     * Clear cart
     *
     * @return void
     */
    protected function doActionClear()
    {
        if (!$this->getCart()->isEmpty()) {
            foreach ($this->getCart()->getItems() as $item) {
                \XLite\Core\Database::getEM()->remove($item);
            }
            $this->getCart()->getItems()->clear();
            $this->updateCart();
        }

        \XLite\Core\TopMessage::addInfo('Item has been deleted from cart');
        $this->setReturnURL($this->buildURL('cart'));
    }

    /**
     * Just update the cart if no action is defined
     *
     * @return void
     */
    protected function doNoAction()
    {
        $this->updateCart();
    }

}
