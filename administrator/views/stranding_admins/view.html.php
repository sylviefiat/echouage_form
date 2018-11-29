<?php
/**
 * @version     0.0.0
 * @package     com_stranding_forms
 * @copyright   Copyright (C) 2014. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Sylvie Fiat <sylvie.fiat@ird.fr>
 */

// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.view');

/**
 * View class for a list of Stranding_admin.
 */
class Stranding_formsViewStranding_admins extends JViewLegacy
{
	protected $items;
	protected $pagination;
	protected $state;

	/**
	 * Display the view
	 */
	public function display($tpl = null)
	{
		$this->state		= $this->get('State');
		$this->items		= $this->get('Items');
		$this->pagination	= $this->get('Pagination');

		// Check for errors.
		if (count($errors = $this->get('Errors'))) {
			throw new Exception(implode("\n", $errors));
		}

		Stranding_formsHelper::addSubmenu('stranding_admins');

		$this->addToolbar();

		$this->sidebar = JHtmlSidebar::render();
		parent::display($tpl);
	}

	/**
	 * Add the page title and toolbar.
	 *
	 * @since	1.6
	 */
	protected function addToolbar()
	{
		require_once JPATH_COMPONENT.'/helpers/stranding_forms.php';

		$state	= $this->get('State');
		$canDo	= Stranding_formsHelper::getActions($state->get('filter.category_id'));

		JToolBarHelper::title(JText::_('COM_STRANDING_FORMS_TITLE_STRANDING_ADMIN'), 'stranding_admins.png');

        //Check if the form exists before showing the add/edit buttons
		$formPath = JPATH_COMPONENT_ADMINISTRATOR.'/views/stranding_admin';
		if (file_exists($formPath)) {

			if ($canDo->get('core.create')) {
				JToolBarHelper::addNew('stranding_admin.add','JTOOLBAR_NEW');
			}

			if ($canDo->get('core.edit') && isset($this->items[0])) {
				JToolBarHelper::editList('stranding_admin.edit','JTOOLBAR_EDIT');
			}

		}

		if ($canDo->get('core.edit.state')) {

			if (isset($this->items[0]->state)) {
				JToolBarHelper::divider();
				JToolBarHelper::custom('stranding_admins.publish', 'publish.png', 'publish_f2.png','JTOOLBAR_PUBLISH', true);
				JToolBarHelper::custom('stranding_admins.unpublish', 'unpublish.png', 'unpublish_f2.png', 'JTOOLBAR_UNPUBLISH', true);
			} else if (isset($this->items[0])) {
                //If this component does not use state then show a direct delete button as we can not trash
				JToolBarHelper::deleteList('', 'stranding_admins.delete','JTOOLBAR_DELETE');
			}

			if (isset($this->items[0]->state)) {
				JToolBarHelper::divider();
				JToolBarHelper::archiveList('stranding_admins.archive','JTOOLBAR_ARCHIVE');
			}
			if (isset($this->items[0]->checked_out)) {
				JToolBarHelper::custom('stranding_admins.checkin', 'checkin.png', 'checkin_f2.png', 'JTOOLBAR_CHECKIN', true);
			}
		}

        //Show trash and delete for components that uses the state field
		if (isset($this->items[0]->state)) {
			if ($state->get('filter.state') == -2 && $canDo->get('core.delete')) {
				JToolBarHelper::deleteList('', 'stranding_admins.delete','JTOOLBAR_EMPTY_TRASH');
				JToolBarHelper::divider();
			} else if ($canDo->get('core.edit.state')) {
				JToolBarHelper::trash('stranding_admins.trash','JTOOLBAR_TRASH');
				JToolBarHelper::divider();
			}
		}

		if ($canDo->get('core.admin')) {
			JToolBarHelper::preferences('com_stranding_forms');
		}

        //Set sidebar action - New in 3.0
		JHtmlSidebar::setAction('index.php?option=com_stranding_forms&view=stranding_admins');

		$this->extra_sidebar = '';


	}

	protected function getSortFields()
	{
		return array(
			'a.id' => JText::_('JGRID_HEADING_ID'),
			'a.observer_name' => JText::_('COM_STRANDING_FORMS_STRANDING_ADMINS_OBSERVER_NAME'),
			'a.observer_tel' => JText::_('COM_STRANDING_FORMS_STRANDING_ADMINS_OBSERVER_TEL'),
			'a.observer_email' => JText::_('COM_STRANDING_FORMS_STRANDING_ADMINS_OBSERVER_EMAIL'),

			'a.informant_name' => JText::_('COM_STRANDING_FORMS_STRANDING_ADMINS_INFORMANT_NAME'),
			'a.informant_tel' => JText::_('COM_STRANDING_FORMS_STRANDING_ADMINS_INFORMANT_TEL'),
			'a.informant_email' => JText::_('COM_STRANDING_FORMS_STRANDING_ADMINS_INFORMANT_EMAIL'),

			'a.observation_datetime' => JText::_('COM_STRANDING_FORMS_STRANDING_ADMINS_OBSERVATION_DATE'),
			'a.observation_location' => JText::_('COM_STRANDING_FORMS_STRANDING_ADMINS_OBSERVATION_LOCATION'),
			'a.observation_localisation' => JText::_('COM_STRANDING_FORMS_STRANDING_ADMINS_OBSERVATION_LOCALISATION'),
			'a.observation_number' => JText::_('COM_STRANDING_FORMS_STRANDING_ADMINS_OBSERVATION_NUMBER'),
			'a.observation_state' => JText::_('COM_STRANDING_FORMS_STRANDING_ADMINS_OBSERVATION_STATE'),
			'a.admin_validation' => JText::_('COM_STRANDING_FORMS_STRANDING_ADMINS_ADMIN_VALIDATION'),
		);
	}
}
