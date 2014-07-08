<?php

/*
 * @version		$Id: view.html.php 2.5.0 2014-06-15 $
 * @package		Joomla
 * @copyright   Copyright (C) 2013-2014 Jom Classifieds
 * @license     GNU/GPL http://www.gnu.org/licenses/gpl-2.0.html
*/

// no direct access
defined('_JEXEC') or die('Restricted access');
//testing

// Import Joomla! libraries
jimport( 'joomla.application.component.view');

class JomClassifiedsViewUser extends JViewLegacy {

    function display($tpl = null) {
		$mainframe = JFactory::getApplication();
		$params = $mainframe->getParams();
		$menus		= $mainframe->getMenu();	
		$menu = $menus->getActive();
		if ($menu){
			$params->def('page_heading', $params->get('page_title', $menu->title));
		} else {
			$params->def('page_heading',  $params->get('page_title'));
		}		
		$this->assignRef('params', $params);
		
		$model = $this->getModel();	
		
		$lists = $model->getLists();	
		$this->assignRef('lists', $lists);
		
		$items = $model->getItems();	
		$this->assignRef('items', $items);
		
		$isFreeMemebership = $model->isFreeMemebership();
		$this->assignRef('isFreeMemebership', $isFreeMemebership);
		
		if(!$items) {
			$msg = JText::_('ITEM_NOT_FOUND');
			JError::raiseNotice( 100, $msg );
			return;
		}
		
		$pagination = $model->getPagination();
		$this->assignRef('pagination', $pagination);
		
		$task = JRequest::getCmd('task');
		if($task == 'favourites') {
			$fav = JText::_('MY_FAVOURITES');
			$this->assignRef('title', $fav);			
			$tpl = 'list';
		}
        parent::display($tpl);
    }
	
	function add($tpl = null) {
		$mainframe = JFactory::getApplication();
		$params = $mainframe->getParams();
		$menus		= $mainframe->getMenu();	
		$menu = $menus->getActive();
		if ($menu){
			$params->def('page_heading', $params->get('page_title', $menu->title));
		} else {
			$params->def('page_heading',  $params->get('page_title'));
		}		
		$this->assignRef('params', $params);
		
        parent::display($tpl);
    }
	
	function edit($tpl = null) {
		$mainframe = JFactory::getApplication();
		$params = $mainframe->getParams();
		$menus		= $mainframe->getMenu();	
		$menu = $menus->getActive();
		if ($menu){
			$params->def('page_heading', $params->get('page_title', $menu->title));
		} else {
			$params->def('page_heading',  $params->get('page_title'));
		}		
		$this->assignRef('params', $params);
		
		$model = $this->getModel();
		 
		$item = $model->getItem();
		$this->assignRef('item', $item);
		
		$parentcategory = JomclUtils::getParentCatid($item->catid);
		$this->assignRef('parentcategory', $parentcategory);
				
        parent::display($tpl);
    }
	
	function addScript($showmap = 0) {
		if($showmap == 1) {
			$document = JFactory::getDocument();
			$document->addCustomTag('<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />');
			$document->addScript("http://maps.googleapis.com/maps/api/js?sensor=false");
			$document->addScript(JURI::root()."components/com_jomclassifieds/js/maps.js");
		}
	}	
	  
}
