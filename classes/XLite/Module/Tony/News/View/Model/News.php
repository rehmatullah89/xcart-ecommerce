<?php
 
  
namespace XLite\Module\Tony\News\View\Model;
 
  
class News extends \XLite\View\Model\AModel
{
    protected $schemaDefault = array(
        'title' => array(
            self::SCHEMA_CLASS => 'XLite\View\FormField\Input\Text',
            self::SCHEMA_LABEL => 'News title',
            self::SCHEMA_REQUIRED => true,
        ),
        'body' => array(
            self::SCHEMA_CLASS => 'XLite\View\FormField\Textarea\Advanced',
            self::SCHEMA_LABEL => 'Main text',
            self::SCHEMA_REQUIRED => true,
        ),
    );
 
  
    protected function getDefaultModelObject()
    {
        $id = \XLite\Core\Request::getInstance()->id;
 
  
        $model = $id
            ? \XLite\Core\Database::getRepo('XLite\Module\Tony\News\Model\News')->find($id)
            : null;
 
  
        return $model ?: new \XLite\Module\Tony\News\Model\News;
    }
 
  
    protected function getFormClass()
    {
        return '\XLite\Module\Tony\News\View\Form\Model\News';
    }
 
  
    protected function getFormButtons()
    {
        $result = parent::getFormButtons();
 
  
        $result['update'] = new \XLite\View\Button\Submit(
            array(
                \XLite\View\Button\AButton::PARAM_LABEL  => 'Update',
            )
        );
 
  
       return $result;
    }
}