<?php
 
namespace XLite\Module\Tony\News\View;
 
  
/**
 * @ListChild (list="sidebar.first", zone="customer", weight="500")
 */
 
 
class NewsMenu extends \XLite\View\SideBarBox
{
    protected function getHead()
    {
        return 'News';
    }
 
  
    protected function getDir()
    {
        return 'modules/Tony/News/menu';
    }
	
	protected function getNews()
	{
		return \XLite\Core\Database::getRepo('\XLite\Module\Tony\News\Model\News')->findAll();
	}
}