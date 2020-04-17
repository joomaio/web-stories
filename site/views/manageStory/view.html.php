<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_helloworld
 *
 * @copyright   Copyright (C) 2005 - 2018 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

/**
 * HelloWorld View
 *
 * @since  0.0.1
 */
class StoriesViewManagestory extends JViewLegacy
{
	/**
	* View form
	*
	* @var         form
	*/
   protected $form = null;
   protected $canDo;
   protected $toolbar;
   protected $checked = array();

   /**
	* Display the Hello World view
	*
	* @param   string  $tpl  The name of the template file to parse; automatically searches through the template paths.
	*
	* @return  void
	*/
   public function display($tpl = null)
   {
	   // Get the Data
	   $this->item = $this->get("Item");
	   $this->form = $this->get('Form');
	   $this->categories = $this->get("Categories");
	   $this->storyCategories = $this->get("StoryCategories");
	   $this->canDo = JHelperContent::getActions('com_stories', 'story', $this->item->id);
	   $this->checkCategories();
	   $this->addBreadcrumbs();
	   $this->addToolBar();

	   // Check for errors.
	   if (count($errors = $this->get('Errors')))
	   {
		   JError::raiseError(500, implode('<br />', $errors));

		   return false;
	   }
	  

	   // Display the template
	   parent::display($tpl);
	   //var_dump($this->form);
	   //die;
   }

   /**
	* Add the page title and toolbar.
	*
	* @return  void
	*
	* @since   1.6
	*/
	protected function addToolBar()
	{
		$input = JFactory::getApplication()->input;

		// Hide Joomla Administrator Main menu
		//$input->set('hidemainmenu', true);

		$isNew = ($this->item->id == 0);
		if ($isNew){
			$title = JText::_('COM_STORIES_STORY_NEW');
			if ( $this->canDo->get('core.create') ){
				JToolbarHelper::save('managestory.save', 'JTOOLBAR_SAVE');
			}
			}
			else{
				$title = JText::_('COM_STORIES_STORY_EDIT');
				if ( $this->canDo->get('core.edit') ){
					JToolbarHelper::save('managestory.save', 'JTOOLBAR_SAVE');
			}	
		}
		JToolbarHelper::title($title, 'story');
		JToolbarHelper::cancel( 'managestory.cancel', $isNew ? 'JTOOLBAR_CANCEL' : 'JTOOLBAR_CLOSE' );
		$this->toolbar = JToolbar::getInstance()->render();
	}


   protected function checkCategories(){
	   $i = 0;
	   $n = count($this->storyCategories);
	   if ( $n == 0 || empty($this->categories) ) return;
	   foreach( $this->categories as $category ){
		   while ( $i < $n-1 && (int)$category['id'] > (int) $this->storyCategories[$i]['id_cat'] ) $i++;
		   if ( $category['id'] == $this->storyCategories[$i]['id_cat']  ){
			   $this->checked[ $category['id'] ] = 1;
		   }
	   }
   }

   protected function addBreadcrumbs(){
	JLoader::register('StoriesHelperRoute', JPATH_COMPONENT . '/helpers/route.php');
	$app    = JFactory::getApplication();
	$pathway = $app->getPathway();
	if ( $this->item->id )
		$pathway->addItem($this->item->name, StoriesHelperRoute::getManagestoryRoute($this->item->id) );
	else 
		$pathway->addItem(JText::_("COM_STORIES_STORY_NEW"), StoriesHelperRoute::getManagestoryRoute() );
}
}