<?php
  
namespace XLite\Module\Tony\News\View\Form\Model;
 
class News extends \XLite\View\Form\AForm
{
    protected function getDefaultTarget()
    {
        return 'news_edit';
    }
 
  
    protected function getDefaultAction()
    {
        return 'update';
    }
}