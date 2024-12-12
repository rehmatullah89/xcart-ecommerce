<?php
 
namespace XLite\Module\Tony\News\Model;
  
/**
 * @Entity
 * @Table  (name="news")
 */
class News extends \XLite\Model\AEntity
{
   /**
    * @Id
    * @GeneratedValue (strategy="AUTO")
    * @Column         (type="integer")
    */
   protected $id;
 
  
   /**
    * @Column (type="boolean")
    */
   protected $enabled = true;
 
  
   /**
    * @Column (type="string", length=255)
    */
   protected $title = '';
 
  
   /**
    * @Column (type="text")
    */
   protected $body = '';
}