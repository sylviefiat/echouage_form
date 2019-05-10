<?php
/**
 * @version     0.0.0
 * @package     com_stranding_forms
 * @copyright   Copyright (C) 2014. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Sylvie Fiat <sylvie.fiat@ird.fr>
 */

// No direct access.
defined('_JEXEC') or die;

jimport('joomla.application.component.modeladmin');

/**
 * Stranding_admin model.
 */
class Stranding_formsModelStranding_admin extends JModelAdmin
{
	/**
	 * @var		string	The prefix to use with controller messages.
	 * @since	1.6
	 */
	protected $text_prefix = 'COM_STRANDING_FORMS';


	/**
	 * Returns a reference to the a Table object, always creating it.
	 *
	 * @param	type	The table type to instantiate
	 * @param	string	A prefix for the table class name. Optional.
	 * @param	array	Configuration array for model. Optional.
	 * @return	JTable	A database object
	 * @since	1.6
	 */
	public function getTable($type = 'Stranding_admin', $prefix = 'Stranding_formsTable', $config = array())
	{
		return JTable::getInstance($type, $prefix, $config);
	}

	/**
	 * Method to get the record form.
	 *
	 * @param	array	$data		An optional array of data for the form to interogate.
	 * @param	boolean	$loadData	True if the form is to load its own data (default case), false if not.
	 * @return	JForm	A JForm object on success, false on failure
	 * @since	1.6
	 */
	public function getForm($data = array(), $loadData = true)
	{
		// Initialise variables.
		$app	= JFactory::getApplication();

		// Get the form.
		$form = $this->loadForm('com_stranding_forms.stranding_admin', 'stranding_admin', array('control' => 'jform', 'load_data' => $loadData));
        
        
		if (empty($form)) {
			return false;
		}

		return $form;
	}

	/**
	 * Method to get the data that should be injected in the form.
	 *
	 * @return	mixed	The data for the form.
	 * @since	1.6
	 */
	protected function loadFormData()
	{
		// Check the session for previously entered form data.
		$data = JFactory::getApplication()->getUserState('com_stranding_forms.edit.stranding_admin.data', array());

		if (empty($data)) {
			$data = $this->getItem();
            
		}

		return $data;
	}

	/**
	 * Method to get a single record.
	 *
	 * @param	integer	The id of the primary key.
	 *
	 * @return	mixed	Object on success, false on failure.
	 * @since	1.6
	 */
	public function getItem($pk = null)
	{
		//JFactory::getApplication()->enqueueMessage($pk);
		if ($item = parent::getItem($pk)) {
			//JFactory::getApplication()->enqueueMessage($item->id);
			$item->animal_form = $this->getAnimalFormTable($item->id);
			//Do any procesing on fields here if needed
			
		}

		return $item;
	}

	private function getAnimalFormTable($id) {
	    $model = JModelLegacy::getInstance('Stranding_animal','Stranding_formsModel');
	    $table = $model->getTable('Stranding_animal', 'Stranding_formsTable');
	    return $table->loadByStrandingId($id);
	    /**/
	}

	/**
	 * Prepare and sanitise the table prior to saving.
	 *
	 * @since	1.6
	 */
	protected function prepareTable($table)
	{
		jimport('joomla.filter.output');

		if (empty($table->id)) {

			// Set ordering to the last item if not set
			if (@$table->ordering === '') {
				$db = JFactory::getDbo();
				$db->setQuery('SELECT MAX(ordering) FROM #__stranding_admin');
				$max = $db->loadResult();
				$table->ordering = $max+1;
			}

		}
	}

	public function save($data) {
	    $this->saveStrandingAnimalTableData($data);
	    parent::save($data);
	}

	private function saveStrandingAnimalTableData($data) {
		//JFactory::getApplication()->enqueueMessage('saving animal');
	    $model = ModelLegacy::getInstance('Stranding_animal','Stranding_formsModel');
	    $table = $model->getTable('Stranding_animal', 'Stranding_formsModel');
	    $table->bind($data->animal_form);
	    $table->store();
	    parent::save($data);
	}

}
