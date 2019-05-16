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
class Stranding_formsModelStranding_animal extends JModelAdmin
{
    /**
     * @var     string  The prefix to use with controller messages.
     * @since   1.6
     */
    protected $text_prefix = 'COM_STRANDING_FORMS';


    /**
     * Returns a reference to the a Table object, always creating it.
     *
     * @param   type    The table type to instantiate
     * @param   string  A prefix for the table class name. Optional.
     * @param   array   Configuration array for model. Optional.
     * @return  JTable  A database object
     * @since   1.6
     */
    public function getTable($type = 'Stranding_animal', $prefix = 'Stranding_formsTable', $config = array())
    {
        return JTable::getInstance($type, $prefix, $config);
    }

    /**
     * Method to get the record form.
     *
     * @param   array   $data       An optional array of data for the form to interogate.
     * @param   boolean $loadData   True if the form is to load its own data (default case), false if not.
     * @return  JForm   A JForm object on success, false on failure
     * @since   1.6
     */
    public function getForm($data = array(), $loadData = true)
    {
        // Initialise variables.
        $app    = JFactory::getApplication();

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
     * @return  mixed   The data for the form.
     * @since   1.6
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
    public function &getData($id = null)
    {
        
        if ($this->_item === null)
        {
            $this->_item = false;

            if (empty($id)) {
                $id = $this->getState('stranding_animal.observation_id');                
            }
            // Get a level row instance.
            $table = $this->getTable();
            // Attempt to load the row.
            if ($table->load($id))
            {
                $user = JFactory::getUser();
                $id = $table->observation_id;
                $canEdit = $user->authorise('core.edit', 'com_stranding_forms') || $user->authorise('core.create', 'com_stranding_forms');
                if (!$canEdit && $user->authorise('core.edit.own', 'com_stranding_forms')) {
                    $canEdit = $user->id == $table->created_by;
                }
                if (!$canEdit) {
                    JError::raiseError('500', JText::_('JERROR_ALERTNOAUTHOR'));
                }
                
                // Check published state.
                if ($published = $this->getState('filter.published'))
                {
                    if ($table->state != $published) {
                        return $this->_item;
                    }
                }                
                // Convert the JTable to a clean JObject.
                $properties = $table->getProperties(1);
                $this->_item = JArrayHelper::toObject($properties, 'JObject');
            } elseif ($error = $table->getError()) {
                $this->setError($error);
            }
        }
        return $this->_item;
    }

    public function &getDataByStrandingId($strID = null)
    {
        
        $table = $this->getTable();

        $ids = $table->getIdsByStrandingId($strID);

        $index = 0;
        foreach($ids as $key => $observation_id){
            $animals[$key]=$this->getItem($observation_id);
        }

        return $animals;
    }

    /**
     * Method to get a single record.
     *
     * @param   integer The id of the primary key.
     *
     * @return  mixed   Object on success, false on failure.
     * @since   1.6
     */
    public function getItem($pk = null)
    {        
        if ($item = parent::getItem($pk)) {
            //Do any procesing on fields here if needed
            
        }
        
        return $item;
    }

    /**
     * Prepare and sanitise the table prior to saving.
     *
     * @since   1.6
     */
    protected function prepareTable($table)
    {
        jimport('joomla.filter.output');

        if (empty($table->observation_id)) {

            // Set ordering to the last item if not set
            if (@$table->ordering === '') {
                $db = JFactory::getDbo();
                $db->setQuery('SELECT MAX(ordering) FROM #__stranding_admin');
                $max = $db->loadResult();
                $table->ordering = $max+1;
            }

        }
    }
    
    /**
     * Save all the animals of a stranding
     *
     * @param    integer $strID the id of the stranding
     * @param    array $animals the array with animal object related to the stranding
     * @return   boolean true if all was saved with success, otherwise false
     */
    public function saveStrandingAnimals($strID, $animals){
        $table = $this->getTable();

        $ids = $table->getIdsByStrandingId($strID);
        $string = "";
        foreach ($animals as $key => $animal) {
            $animal['stranding_id']=$strID;
            $save = $table->save($animal);
            if($save === false){
                return false;
            }
            $observation_id = $table->get('observation_id');
            $uid = array_search($observation_id, $ids);
            unset($ids[$uid]);
        }

        foreach ($ids as $key2 => $observation_id) {
            $table->delete($observation_id);
        }
        return true;
    }

}
