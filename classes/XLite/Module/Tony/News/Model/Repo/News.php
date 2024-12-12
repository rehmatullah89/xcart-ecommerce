<?php
 
namespace XLite\Module\Tony\News\Model\Repo;
  
class News extends \XLite\Model\Repo\ARepo
{
   // {{{ Search
 
  
   const SEARCH_LIMIT = 'limit';
 
  
   public function search(\XLite\Core\CommonCell $cnd, $countOnly = false)
   {
       $queryBuilder = $this->createQueryBuilder('n');
       $this->currentSearchCnd = $cnd;
 
  
       foreach ($this->currentSearchCnd as $key => $value) {
           $this->callSearchConditionHandler($value, $key, $queryBuilder, $countOnly);
       }
 
  
       return $countOnly
           ? $this->searchCount($queryBuilder)
           : $this->searchResult($queryBuilder);
   }
 
  
   public function searchCount(\Doctrine\ORM\QueryBuilder $qb)
   {
       $qb->select('COUNT(DISTINCT n.id)');
 
  
       return intval($qb->getSingleScalarResult());
   }
 
  
   public function searchResult(\Doctrine\ORM\QueryBuilder $qb)
   {
       return $qb->getResult();
   }
 
  
   protected function callSearchConditionHandler($value, $key, \Doctrine\ORM\QueryBuilder $queryBuilder, $countOnly)
   {
       if ($this->isSearchParamHasHandler($key)) {
           $this->{'prepareCnd' . ucfirst($key)}($queryBuilder, $value, $countOnly);
       }
   }
 
  
   protected function isSearchParamHasHandler($param)
   {
       return in_array($param, $this->getHandlingSearchParams());
   }
 
  
   protected function getHandlingSearchParams()
   {
       return array(
           static::SEARCH_LIMIT,
       );
   }
 
  
   protected function prepareCndLimit(\Doctrine\ORM\QueryBuilder $queryBuilder, array $value)
   {
       call_user_func_array(array($this, 'assignFrame'), array_merge(array($queryBuilder), $value));
   }
}