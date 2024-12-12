<?php
 
namespace XLite\Module\Tony\News\View\Form\ItemsList\News;
  
class Table extends \XLite\View\Form\ItemsList\AItemsList
{
    protected function getDefaultTarget()
    {
        return 'news';
    }
 
  
    protected function getDefaultAction()
    {
        return 'update';
    }
}