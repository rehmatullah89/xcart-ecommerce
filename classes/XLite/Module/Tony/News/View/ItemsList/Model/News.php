<?php
 
  
namespace XLite\Module\Tony\News\View\ItemsList\Model;
 
  
class News extends \XLite\View\ItemsList\Model\Table
{
 
    protected function defineColumns()
    {
        return array(
            'title' => array(
                static::COLUMN_CLASS => 'XLite\View\FormField\Inline\Input\Text',
                static::COLUMN_NAME => \XLite\Core\Translation::lbl('News title'),
                static::COLUMN_ORDERBY => 100,
            ),
        );
    }
 
  
    protected function defineRepositoryName()
    {
        return 'XLite\Module\Tony\News\Model\News';
    }
 
  
   protected function isSwitchable()
   {
       return true;
   }
 
  
   /**
    * Mark list as removable
    *
    * @return boolean
    */
   protected function isRemoved()
   {
       return true;
   }
 
  
   protected function isCreation()
   {
       return static::CREATE_INLINE_TOP;
   }
 
  
   protected function getCreateURL()
   {
       return \XLite\Core\Converter::buildUrl('news_edit');
   }
}