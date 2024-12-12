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

namespace XLite\Controller\Admin;

/**
 * Product
 */
class Product extends \XLite\Controller\Admin\Base\Catalog
{
    /**
     * Backward compatibility
     *
     * @var array
     */
    protected $params = array('target', 'id', 'product_id', 'page', 'backURL');

    /**
     * Chuck length
     */
    const CHUNK_LENGTH = 100;

    // {{{ Abstract method implementations

    /**
     * Check if we need to create new product or modify an existsing one
     *
     * NOTE: this function is public since it's neede for widgets
     *
     * @return boolean
     */
    public function isNew()
    {
        return !$this->getProduct()->isPersistent();
    }

    /**
     * Defines the product preview URL
     *
     * @param integer $productId
     *
     * @return string
     */
    public function buildProductPreviewURL($productId)
    {
        return \XLite\Core\Converter::buildURL('product', 'preview', array('product_id' => $productId), \XLite::CART_SELF);
    }

    /**
     * Return class name for the controller main form
     *
     * @return string
     */
    protected function getFormClass()
    {
        return '\XLite\View\Form\Product\Modify\Single';
    }

    /**
     * Alias
     *
     * @return \XLite\Model\Product
     */
    protected function getEntity()
    {
        return $this->getProduct();
    }

    // }}}

    // {{{ Pages

    /**
     * Check ACL permissions
     *
     * @return boolean
     */
    public function checkACL()
    {
        return parent::checkACL() || \XLite\Core\Auth::getInstance()->isPermissionAllowed('manage catalog');
    }

    /**
     * Get pages sections
     *
     * @return array
     */
    public function getPages()
    {
        $list = parent::getPages();
        $list['info'] = 'Product info';

        if (!$this->isNew()) {
            $list['attributes'] = 'Attributes';
            $list['images']     = 'Product images';
            $list['inventory']  = 'Inventory tracking';
        }

        return $list;
    }

    /**
     * Get pages templates
     *
     * @return array
     */
    protected function getPageTemplates()
    {
        $list = parent::getPageTemplates();
        $list['info']    = 'product/info.tpl';
        $list['default'] = 'product/info.tpl';

        if (!$this->isNew()) {
            $list['attributes'] = 'product/attributes.tpl';
            $list['images']     = 'product/product_images.tpl';
            $list['inventory']  = 'product/inventory.tpl';
        }

        return $list;
    }

    // }}}

    // {{{ Data management

    /**
     * Alias
     *
     * @return \XLite\Model\Product
     */
    public function getProduct()
    {
        $result = \XLite\Core\Database::getRepo('\XLite\Model\Product')->find($this->getProductId());

        if (!isset($result)) {
            $result = new \XLite\Model\Product();
        }

        return $result;
    }

    /**
     * Returns the categories of the product
     *
     * @return array
     */
    public function getCategories()
    {
        return $this->isNew()
            ? array(
                $this->getCategoryId(),
            )
            : $this->getProduct()->getCategories();
    }

    /**
     * Return the current page title (for the content area)
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->getProduct()->getName();
    }

    /**
     * getInventory
     *
     * @return \XLite\Model\Inventory
     */
    public function getInventory()
    {
        return $this->getProduct()->getInventory();
    }

    /**
     * Get product category id
     *
     * @return integer
     */
    public function getCategoryId()
    {
        $categoryId = parent::getCategoryId();

        if (empty($categoryId) && !$this->isNew()) {
            $categoryId = $this->getProduct()->getCategoryId();
        }

        return $categoryId;
    }

    /**
     * Return current product Id
     *
     * NOTE: this function is public since it's neede for widgets
     *
     * @return integer
     */
    public function getProductId()
    {
        $result = intval(\XLite\Core\Request::getInstance()->product_id);

        if (0 >= $result) {
            $result = intval(\XLite\Core\Request::getInstance()->id);
        }

        return $result;
    }

    /**
     * Return list of the CategoryProduct entities
     *
     * @param \XLite\Model\Product $product Current product
     *
     * @return array
     */
    protected function getCategoryProducts(\XLite\Model\Product $product)
    {
        $data = array();

        foreach ((array) $this->getPostedData('category_ids') as $categoryId) {
            $data[] = new \XLite\Model\CategoryProducts(
                array(
                    'category'    => \XLite\Core\Database::getRepo('\XLite\Model\Category')->find($categoryId),
                    'product'     => $product,
                    'orderby'     => $product->getOrderby($categoryId),
                )
            );
        }

        return array('categoryProducts' => new \Doctrine\Common\Collections\ArrayCollection($data));
    }

    /**
     * Get posted data
     *
     * @param string $field Name of the field to retrieve OPTIONAL
     *
     * @return mixed
     */
    protected function getPostedData($field = null)
    {
        $value = parent::getPostedData($field);

        $time = \XLite\Core\Converter::time();

        if (!isset($field)) {

            if (isset($value['arrivalDate'])) {
                $value['arrivalDate'] = intval(strtotime($value['arrivalDate'])) ?: mktime(0, 0, 0, date('m', $time), date('j', $time), date('Y', $time));
            }

            if (isset($value['sku']) && \XLite\Core\Converter::isEmptyString($value['sku'])) {
                $value['sku'] = null;
            }

            if (isset($value['productClass'])) {
                $value['productClass'] = \XLite\Core\Database::getRepo('\XLite\Model\ProductClass')->find($value['productClass']);
            }

            if (isset($value['taxClass'])) {
                $value['taxClass'] = \XLite\Core\Database::getRepo('\XLite\Model\TaxClass')->find($value['taxClass']);
            }

        } elseif ('arrivalDate' === $field) {
            $value = intval(strtotime($value)) ?: mktime(0, 0, 0, date('m', $time), date('j', $time), date('Y', $time));

        } elseif ('sku' === $field) {
            $value = null;

        } elseif ('productClass' === $field) {
            $value = \XLite\Core\Database::getRepo('\XLite\Model\ProductClass')->find($value);

        } elseif ('taxClass' === $field) {
            $value = \XLite\Core\Database::getRepo('\XLite\Model\TaxClass')->find($value);
        }

        return $value;
    }

    // }}}

    // {{{ Action handlers

    /**
     * doActionAdd
     *
     * @return void
     */
    protected function doActionAdd()
    {
        $product = \XLite\Core\Database::getRepo('\XLite\Model\Product')->insert($this->getPostedData());

        if (isset($product)) {

            $this->updateSKU($product);
            $this->updateCleanURL($product);
            $this->updateMemberships($product);

            $inventory = new \XLite\Model\Inventory();
            $inventory->setProduct($product);

            // Create associations (categories and images)
            $arguments = $this->getCategoryProducts($product)
                + array('inventory' => $inventory);

            \XLite\Core\Database::getRepo('\XLite\Model\Attribute')->generateAttributeValues($product);

            \XLite\Core\Database::getRepo('\XLite\Model\Product')->update(
                $product,
                $arguments
            );

            \XLite\Core\TopMessage::addInfo('New product has been added successfully');

            // Add the ID of created product to the return URL
            $this->setReturnURL($this->buildURL('product', '', array('product_id' => $product->getProductId())));
        }
    }

    /**
     * doActionUpdate
     *
     * @return void
     */
    protected function doActionUpdate()
    {
        $product = $this->getProduct();
        $data = $this->getCategoryProducts($product) + $this->getPostedData();

        // Clear all category associates
        \XLite\Core\Database::getRepo('\XLite\Model\CategoryProducts')->deleteInBatch(
            $product->getCategoryProducts()->toArray()
        );

        $product->getCategoryProducts()->clear();

        // Update all data
        \XLite\Core\Database::getRepo('\XLite\Model\Product')->update($product, $data);

        $this->updateSKU($product);
        $this->updateCleanURL($product);
        $this->updateMemberships($product);

        \XLite\Core\TopMessage::addInfo('Product info has been updated successfully');
    }

    /**
     * Update SKU
     *
     * @param \XLite\Model\Product $product Product
     *
     * @return void
     */
    protected function updateSKU(\XLite\Model\Product $product)
    {
        if (!$product->getSKU()) {
            $product->setSKU(\XLite\Core\Database::getRepo('\XLite\Model\Product')->generateSKU($product));
            \XLite\Core\Database::getEM()->flush();
        }
    }

    /**
     * Update clean URL
     *
     * @param \XLite\Model\Product $product Product
     *
     * @return void
     */
    protected function updateCleanURL(\XLite\Model\Product $product)
    {
        if ($this->getPostedData('autogenerateCleanURL')) {
            $product->setCleanURL($product->generateCleanURL());
        }
    }

    /**
     * Update memberships
     *
     * @param \XLite\Model\Product $product Current product
     *
     * @return void
     */
    protected function updateMemberships(\XLite\Model\Product $product)
    {
        if ($product->getMemberships()) {
            foreach ($product->getMemberships() as $membership) {
                $membership->getProducts()->removeElement($product);
            }
            $product->getMemberships()->clear();
        }

        foreach ((array) $this->getPostedData('membership_ids') as $mid) {
            $membership = \XLite\Core\Database::getRepo('XLite\Model\Membership')->find($mid);
            if ($membership) {
                $product->addMemberships($membership);
                $membership->addProduct($product);
            }
        }
        \XLite\Core\Database::getEM()->flush();
    }

    // TODO: refactor

    /**
     * Delete detailed image
     *
     * @return void
     */
    protected function doActionDeleteImage()
    {
        $img = \XLite\Core\Database::getRepo('\XLite\Model\Image\Product\Image')
            ->find(\XLite\Core\Request::getInstance()->image_id);

        if ($img) {

            $img->getProduct()->getImages()->removeElement($img);

            \XLite\Core\Database::getEM()->remove($img);
            \XLite\Core\Database::getEM()->flush();

            \XLite\Core\TopMessage::addInfo(
                'The detailed image has been deleted'
            );

        } else {

            \XLite\Core\TopMessage::addError(
                'The detailed image has not been deleted'
            );
        }
    }

    /**
     * Update image
     *
     * @return void
     */
    protected function doActionUpdateImages()
    {
        $zoomId = 0;

        if (isset(\XLite\Core\Request::getInstance()->is_zoom)) {

            $keys = array_keys(\XLite\Core\Request::getInstance()->is_zoom);

            $zoomId = array_shift($keys);
        }

        foreach (\XLite\Core\Request::getInstance()->alt as $imageId => $alt) {

            $img = \XLite\Core\Database::getRepo('\XLite\Model\Image\Product\Image')
                ->find($imageId);

            if ($img) {

                $img->setAlt($alt);

                $img->setOrderby(\XLite\Core\Request::getInstance()->orderby[$imageId]);

                \XLite\Core\Database::getEM()->persist($img);
            }
        }

        \XLite\Core\Database::getEM()->flush();

        \XLite\Core\TopMessage::addInfo('The detailed images have been updated successfully');
    }

    /**
     * Do action clone
     *
     * @return void
     */
    protected function doActionClone()
    {
        if ($this->getProduct()) {
            $newProduct = $this->getProduct()->cloneEntity();
            $newProduct->updateQuickData();
            $this->setReturnURL($this->buildURL('product', '', array('product_id' => $newProduct->getId())));
        }
    }

    /**
     * Update inventory
     *
     * @return void
     */
    protected function doActionUpdateInventory()
    {
        $inv = $this->getInventory();

        $inv->map($this->getPostedData());

        if (!$inv->getInventoryId()) {
            $product = $this->getProduct();
            $product->setInventory($inv);
            $inv->setProduct($product);
            \XLite\Core\Database::getEM()->persist($inv);
        }

        \XLite\Core\Database::getEM()->flush();
    }

    /**
     * Update attributes
     *
     * @return void
     */
    protected function doActionUpdateAttributes()
    {
        $name           = \XLite\Core\Request::getInstance()->name;
        $attributeValue = \XLite\Core\Request::getInstance()->attributeValue;
        $delete         = \XLite\Core\Request::getInstance()->delete;
        $newValue       = \XLite\Core\Request::getInstance()->newValue;
        $save_mode      = \XLite\Core\Request::getInstance()->save_mode;

        $repo      = \XLite\Core\Database::getRepo('\XLite\Model\Attribute');
        $repoGroup = \XLite\Core\Database::getRepo('\XLite\Model\AttributeGroup');

        if ('globaly' == $save_mode) {
            $oldValues = $this->getAttributeValues();
        }

        if ($delete) {
            foreach ($delete as $k => $v) {
                if (isset($name[$k])) {
                    unset($name[$k]);
                }
                if (isset($attributeValue[$k])) {
                    unset($attributeValue[$k]);
                }
                $a = $repo->find($k);
                if ($a) {
                    $repo->delete($repo->find($k));
                }
            }
        }

        if ($name) {
            $attributes = $repo->findByIds(array_keys($name));

            if ($attributes) {
                foreach ($attributes as $a) {
                    if ($name[$a->getId()]) {
                        $a->setName($name[$a->getId()]);
                    }

                    if (isset($attributeValue[$a->getId()])) {
                        $a->setAttributeValue(
                            $this->getProduct(),
                            $attributeValue[$a->getId()]
                        );
                    }
                }
            }
        }

        if ($newValue) {
            foreach ($newValue as $data) {
                $data['name'] = trim($data['name']);
                if (
                    $data['name']
                    && $data['type']
                    && \XLite\Model\Attribute::getTypes($data['type'])
                ) {
                    $a = new \XLite\Model\Attribute();
                    $a->setName($data['name']);
                    $a->setType($data['type']);
                    if (0 < $data['listId']) {
                        $group = $repoGroup->find($data['listId']);
                        if ($group) {
                            $a->setAttributeGroup($group);
                            $a->setProductClass($group->getProductClass());
                        }

                    } elseif (
                        -2 == $data['listId']
                        && $this->getProduct()->getProductClass()
                    ) {
                        $a->setProductClass($this->getProduct()->getProductClass());

                    } elseif (-3 == $data['listId']) {
                        $a->setProduct($this->getProduct());
                        $this->getProduct()->addAttributes($a);
                    }

                    unset($data['name'], $data['type']);
                    $repo->insert($a);

                    $a->setAttributeValue($this->getProduct(), $data);
                }
            }
        }

        $this->getProduct()->updateQuickData();

        if ('globaly' == $save_mode) {
            $this->applyAttributeValuesChanges(
                $oldValues,
                $this->getAttributeValues()
            );
        }

        \XLite\Core\Database::getEM()->flush();
        \XLite\Core\TopMessage::addInfo('Attributes have been updated successfully');
    }

    /**
     * Get attribute values for diff
     *
     * @return array
     */
    protected function getAttributeValues()
    {
        $result = array();

        foreach (\XLite\Model\Attribute::getTypes() as $type => $name) {
            $class = \XLite\Model\Attribute::getAttributeValueClass($type);
            $result[$type] = \XLite\Core\Database::getRepo($class)->findCommonValues($this->getProduct());
        }

        return $result;
    }

    /**
     * Apply attribute values changes
     *
     * @param array oldValues Old values
     * @param array newValues New values
     *
     * @return void
     */
    protected function applyAttributeValuesChanges(array $oldValues, array $newValues)
    {
        $diff = array();
        foreach (\XLite\Model\Attribute::getTypes() as $type => $name) {
            $class = \XLite\Model\Attribute::getAttributeValueClass($type);
            $diff += $class::getDiff($oldValues[$type], $newValues[$type]);
        }

        if ($diff) {
            foreach (\XLite\Core\Database::getRepo('XLite\Model\Product')->iterateAll() as $product) {
                $product = $product[0];

                foreach ($diff as $attributeId => $changes) {
                    $attribute = \XLite\Core\Database::getRepo('XLite\Model\Attribute')->find($attributeId);
                    $attribute->applyChanges($product, $changes);
                }
                $cache[] = $product;

                if (static::CHUNK_LENGTH <= count($cache)) {
                    \XLite\Core\Database::getEM()->flush();

                    foreach ($cache as $product) {
                        \XLite\Core\Database::getEM()->detach($product);
                    }
                    $cache = array();
                }
            }
        }
    }

    /**
     * Update product class
     *
     * @return void
     */
    protected function doActionUpdateProductClass()
    {
        $updateClass = false;

        if (-1 == \XLite\Core\Request::getInstance()->productClass) {
            $name = trim(\XLite\Core\Request::getInstance()->newProductClass);

            if ($name) {
                $productClass = new \XLite\Model\ProductClass;
                $productClass->setName($name);
                \XLite\Core\Database::getRepo('\XLite\Model\ProductClass')->insert($productClass);
                $updateClass = true;
            }

        } else {
            $productClass = \XLite\Core\Database::getRepo('\XLite\Model\ProductClass')->find(
                \XLite\Core\Request::getInstance()->productClass
            );
            $updateClass = true;
        }

        if ($updateClass) {
            $productClassChanged = $productClass
                && (
                    !$this->getProduct()->getProductClass()
                    || $productClass->getId() != $this->getProduct()->getProductClass()->getId()
                );

            $this->getProduct()->setProductClass($productClass);

            if ($productClassChanged) {
                \XLite\Core\Database::getRepo('\XLite\Model\Attribute')->generateAttributeValues(
                    $this->getProduct(),
                    true
                );
            }

            \XLite\Core\Database::getEM()->flush();
            \XLite\Core\TopMessage::addInfo('Product class have been updated successfully');

        } else {
            \XLite\Core\TopMessage::addWarning('Product class name is empty');
        }
    }

    // }}}
}
