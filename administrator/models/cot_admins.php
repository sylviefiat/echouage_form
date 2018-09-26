<?php

/**
 * @version     2.0.7
 * @package     com_cot_forms
 * @copyright   Copyright (C) 2014. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Sylvie Fiat <sylvie.fiat@ird.fr>
 */
defined('_JEXEC') or die;

jimport('joomla.application.component.modellist');

/**
 * Methods supporting a list of Cot_Admins records.
 */
class Cot_formsModelCot_admins extends JModelList {

    /**
     * Constructor.
     *
     * @param    array    An optional associative array of configuration settings.
     * @see        JController
     * @since    1.6
     */
    public function __construct($config = array()) {
        if (empty($config['filter_fields'])) {
            $config['filter_fields'] = array(
                'id', 'a.id',

                //references and id_location
                'references','a.references',
                'id_location','a.id_location',

                'observer_name', 'a.observer_name',
                'observer_tel', 'a.observer_tel',
                'observer_email', 'a.observer_email',

                // grounding data
                'informant_name', 'a.informant_name',
                'informant_tel', 'a.informant_tel',
                'informant_email', 'a.informant_email',
		        'observation_datetime', 'a.observation_datetime',
		        'observation_location', 'a.observation_location',
                'observation_localisation', 'a.observation_localisation',
                'observation_region', 'a.observation_region',
                'observation_country', 'a.observation_country',
                'observation_country_code', 'a.observation_country_code',
                'observation_latitude', 'a.observation_latitude',
                'observation_longitude', 'a.observation_longitude',
                'observation_number', 'a.observation_number',
                'observation_spaces', 'a.observation_spaces',
                'observation_spaces_identification', 'a.observation_spaces_identification',
                'observation_size','a.observation_size',
                'observation_abnormalities','a.observation_abnormalities',
                'observation_capture_traces','a.observation_capture_traces',
                'catch_indices','a.catch_indices',
                'observation_sex','a.observation_sex',
                'observation_state', 'a.observation_state',
                'observation_state_decomposition', 'a.observation_state_decomposition',
                'levies_protocole', 'a.levies_protocole',
		        'remarks', 'a.remarks',
                'created_by', 'a.created_by',
                'localisation', 'a.localisation',
		        'admin_validation', 'a.admin_validation'
            );
        }

        parent::__construct($config);
    }

    /**
     * Method to auto-populate the model state.
     *
     * Note. Calling getState in this method will result in recursion.
     */
    protected function populateState($ordering = null, $direction = null) {
        // Initialise variables.
        $app = JFactory::getApplication('administrator');

        // Load the filter state.
        $search = $app->getUserStateFromRequest($this->context . '.filter.search', 'filter_search');
        $this->setState('filter.search', $search);

        $published = $app->getUserStateFromRequest($this->context . '.filter.state', 'filter_published', '', 'string');
        $this->setState('filter.state', $published);



        // Load the parameters.
        $params = JComponentHelper::getParams('com_cot_forms');
        $this->setState('params', $params);

        // List state information.
        parent::populateState('a.observer_name', 'asc');
    }

    /**
     * Method to get a store id based on model configuration state.
     *
     * This is necessary because the model is used by the component and
     * different modules that might need different sets of data or different
     * ordering requirements.
     *
     * @param	string		$id	A prefix for the store id.
     * @return	string		A store id.
     * @since	1.6
     */
    protected function getStoreId($id = '') {
        // Compile the store id.
        $id.= ':' . $this->getState('filter.search');
        $id.= ':' . $this->getState('filter.state');

        return parent::getStoreId($id);
    }

    /**
     * Build an SQL query to load the list data.
     *
     * @return	JDatabaseQuery
     * @since	1.6
     */
    protected function getListQuery() {
        // Create a new query object.
        $db = $this->getDbo();
        $query = $db->getQuery(true);

        // Select the required fields from the table.
        $query->select(
                $this->getState(
                        'list.select', 'a.*'
                )
        );
        $query->from('`#__cot_admin` AS a');


		// Join over the user field 'created_by'
		$query->select('created_by.name AS created_by');
		$query->join('LEFT', '#__users AS created_by ON created_by.id = a.created_by');



        // Filter by search in title
        $search = $this->getState('filter.search');
        if (!empty($search)) {
            if (stripos($search, 'id:') === 0) {
                $query->where('a.id = ' . (int) substr($search, 3));
            } else {
                $search = $db->Quote('%' . $db->escape($search, true) . '%');
                $query->where('( a.observer_name LIKE '.$search.' )');
            }
        }




        // Add the list ordering clause.
        $orderCol = $this->state->get('list.ordering');
        $orderDirn = $this->state->get('list.direction');
        if ($orderCol && $orderDirn) {
            $query->order($db->escape($orderCol . ' ' . $orderDirn));
        }

        return $query;
    }

    public function getItems() {
        $items = parent::getItems();

        return $items;
    }

}
