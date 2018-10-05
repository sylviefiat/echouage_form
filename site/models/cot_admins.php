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
 * Methods supporting a list of Cot_forms records.
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
        parent::__construct($config);
    }

    /**
     * Method to auto-populate the model state.
     *
     * Note. Calling getState in this method will result in recursion.
     *
     * @since	1.6
     */
    protected function populateState($ordering = null, $direction = null) {

        // Initialise variables.
        $app = JFactory::getApplication();

        // List state information
        $limit = $app->getUserStateFromRequest('global.list.limit', 'limit', $app->getCfg('list_limit'));
        $this->setState('list.limit', $limit);

        $limitstart = JFactory::getApplication()->input->getInt('limitstart', 0);
        $this->setState('list.start', $limitstart);



        // List state information.
        parent::populateState($ordering, $direction);
    }

    /**
     * Build an SQL query to load the list data.
     *
     * @return	JDatabaseQuery
     * @since	1.6
     */
    protected function getListQuerySample() {
      // Create a new query object.
      $db = $this->getDbo();
      $query = $db->getQuery(true);

      // Select the required fields from the table.
      $query->select(
            $this->getState(
                    'list.select', 'a.id,
                                    a.form_references,
                                    a.id_location,
                                    a.observation_spaces,
                                    a.observation_datetime,
                                    a.observation_country,
                                    a.observation_region,
                                    a.observation_localisation,
                                    a.observation_latitude,
                                    a.observation_longitude,
                                    a.observation_number,
                                    a.observation_sex,
                                    a.observation_size,
                                    a.observation_state_decomposition,
                                    a.informant_name,
                                    a.observer_name,
                                    a.catch_indices,
                                    a.observation_tissue_removal,
                                    a.form_references,
                                    a.admin_validation'

            )
      );
  
      $query->from('`#__cot_admin` AS a');

      // Join over the created by field 'created_by'
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
      return $query;
    }

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

      // Join over the created by field 'created_by'
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
      return $query;
    }

    public function getItems() {
        return parent::getItems();
    }

    public function getCsv($var)
    {
      $this->populateState();
      $db = $this->getDbo();

      $cols = array_keys($db->getTableColumns('#__cot_admin'));

      // Count columns 
      $nb_columns = count($cols); 

      // Delete all the columns header
      for($cptr=0; $cptr<$nb_columns; $cptr++){ array_pop($cols); }

      if($var == 0) {
          array_push($cols, 'Id', 'Référence', 'Id_location', 'Espèce', 'Date_examen', 'Collectivité', 'Commune', 'Lieu', 'Position_latitude', 'Postion_longitude', 'Nombre', 'Sexe', 'Longueur', 'DCC', 'Informateur', 'Observateur', 'Observations','Prélèvements');

          $items = $db->setQuery($this->getListQuerySample())->loadObjectList();
          $csv =  fopen('php://output', 'w');
          fprintf($csv, chr(0xEF).chr(0xBB).chr(0xBF));
          fputcsv($csv, $cols);

          foreach($items as $line){
            $in = (array) $line;
            for($i=0; $i<=1; $i++){array_pop($in);}
            fputcsv($csv, (array) $in);
          }
        return fclose($csv);

      }else {
          array_push($cols, 'Id', 'Référence', 'Id_location', 'Espèce', 'Sigle or mass stranding', '','Date_examen', 'Collectivité', 'Commune', 'Lieu', 'Position_latitude', 'Postion_longitude', 'Nombre', 'Sexe', 'Longueur', 'DCC', 'Informateur', 'Observateur', 'Observations','Prélèvements', 'Commentaires')
          $items = $db->setQuery($this->getListQuery())->loadObjectList();
          $csv =  fopen('php://output', 'w');
          fprintf($csv, chr(0xEF).chr(0xBB).chr(0xBF));
          fputcsv($csv, $cols);

          foreach($items as $line){
            $in = (array) $line;
            
            fputcsv($csv, (array) $in);
          }
        return fclose($csv);
      }
      
    }

  }


