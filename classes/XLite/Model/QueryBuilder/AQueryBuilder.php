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

namespace XLite\Model\QueryBuilder;

/**
 * Abstract query builder
 */
abstract class AQueryBuilder extends \Doctrine\ORM\QueryBuilder implements \Countable
{

    /**
     * Service flags 
     * 
     * @var array
     */
    protected $flags = array();

    /**
     * Linked joins 
     * 
     * @var array
     */
    protected $joins = array();

    // {{{ Result helpers

    /**
     * Get result
     *
     * @return array
     */
    public function getResult()
    {
        return $this->getQuery()->getResult();
    }

    /**
     * Get result as object array.
     *
     * @return array
     */
    public function getObjectResult()
    {
        $result = array();

        foreach ($this->getResult() as $idx => $item) {
            $result[$idx] = is_object($item) ? $item : $item[0];
        }

        return $result;
    }

    /**
     * Get result as array
     *
     * @return array
     */
    public function getArrayResult()
    {
        return $this->getQuery()->getArrayResult();
    }

    /**
     * Get single result
     *
     * @return \XLite\Model\AEntity|void
     */
    public function getSingleResult()
    {
        try {
            $entity = $this->getQuery()->getSingleResult();

        } catch (\Doctrine\ORM\NonUniqueResultException $exception) {
            $entity = null;

        } catch (\Doctrine\ORM\NoResultException $exception) {
            $entity = null;
        }

        return $entity;
    }

    /**
     * Get single scalar result
     *
     * @return mixed
     */
    public function getSingleScalarResult()
    {
        try {
            $scalar = $this->getQuery()->getSingleScalarResult();

        } catch (\Doctrine\ORM\NonUniqueResultException $exception) {
            $scalar = null;

        } catch (\Doctrine\ORM\NoResultException $exception) {
            $scalar = null;
        }

        return $scalar;
    }

    /**
     * Get iterator
     *
     * @return \Iterator
     */
    public function iterate()
    {
        return $this->getQuery()->iterate();
    }

    /**
     * Execute query
     *
     * @return mixed
     */
    public function execute()
    {
        return $this->getQuery()->execute();
    }

    /**
     * Get only entities
     *
     * @return array
     */
    public function getOnlyEntities()
    {
        $result = array();

        foreach ($this->getResult() as $entity) {

            if (is_array($entity)) {
                $entity = $entity[0];
            }

            $result[] = $entity;
        }

        return $result;
    }

    /**
     * Get count 
     * 
     * @return integer
     */
    public function count()
    {
        $count = $this->select('COUNT(' . $this->getMainAlias() . ')')
            ->setMaxResults(1)
            ->getSingleScalarResult();

        return intval($count);
    }

    // }}}

    // {{{ Service flags

    /**
     * Get service flag 
     * 
     * @param string $name Flag name
     *  
     * @return mixed
     */
    public function getFlag($name)
    {
        return isset($this->flags[$name]) ? $this->flags[$name] : null;
    }

    /**
     * Set service flag 
     * 
     * @param string $name  Flag name
     * @param mixed  $value Value OPTIONAL
     *  
     * @return void
     */
    public function setFlag($name, $value = true)
    {
        $this->flags[$name] = $value;
    }

    // }}}

    // {{{ Query builder helpers

    /**
     * Get Query builder main alias
     *
     * @return string
     */
    public function getMainAlias()
    {
        $from = $this->getDQLPart('from');
        $from = explode(' ', array_shift($from), 2);

        return isset($from[1]) ? $from[1] : $from[0];
    }


    /**
     * Link association as inner join
     * 
     * @param string $join  The relationship to join
     * @param string $alias The alias of the join OPTIONAL
     *  
     * @return \XLite\Model\QueryBuilder\AQueryBuilder
     */
    public function linkInner($join, $alias = null)
    {
        if (!$alias) {
            list($main, $alias) = explode('.', $join, 2);
        }

        if (!in_array($alias, $this->joins)) {
            $this->innerJoin($join, $alias);
            $this->joins[] = $alias;
        }

        return $this;
    }

    /**
     * Link association as left join
     *
     * @param string $join  The relationship to join
     * @param string $alias The alias of the join OPTIONAL
     *
     * @return \XLite\Model\QueryBuilder\AQueryBuilder
     */
    public function linkLeft($join, $alias = null)
    {
        if (!$alias) {
            list($main, $alias) = explode('.', $join, 2);
        }

        if (!in_array($alias, $this->joins)) {
            $this->leftJoin($join, $alias);
            $this->joins[] = $alias;
        }

        return $this;
    }

    /**
     * Get IN () condition
     * 
     * @param array  $data   Data
     * @param string $prefix Parameter prefix OPTIONAL
     *  
     * @return string
     */
    public function getInCondition(array $data, $prefix = 'id')
    {
        $keys = \XLite\Core\Database::buildInCondition($this, $data, $prefix);

        return implode(', ', $keys);
    }

    // }}}

}
