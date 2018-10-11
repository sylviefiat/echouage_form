<?php

/**
 * @version     1.0.0
 * @package     com_stranding_forms
 * @copyright   Copyright (C) 2014. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Sylvie Fiat <sylvie.fiat@ird.fr>
 */
defined('_JEXEC') or die;

jimport('joomla.application.component.modellist');

/**
 * Methods supporting a list of Stranding_forms records.
 */
class Stranding_formsModelStranding_admins extends JModelList {

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

    // Simple data output
    protected function getListQuerySimple() {
      // Create a new query object.
      $db = $this->getDbo();
      $query = $db->getQuery(true);

      // Select the required fields from the table.
      $query->select(
            $this->getState(
                    'list.select', 'CONCAT("EC",Year(observation_datetime),"-","0",a.id,"-","0",id_location),
                                    a.observation_spaces,
                                    a.observation_datetime,
                                    Year(observation_datetime),
                                    a.observation_country,
                                    988,
                                    a.observation_commune,
                                    a.observation_localisation,
                                    a.observation_latitude,
                                    a.observation_longitude,
                                    a.observation_number,
                                    a.observation_sex,
                                    a.observation_size,
                                    a.observation_size_precision,
                                    a.observation_state_decomposition,
                                    CONCAT(informant_name, " ", informant_address, " ", informant_tel, " ", informant_email),
                                    CONCAT(observer_name, " ", observer_address, " ", observer_tel, " ", observer_email),
                                    a.catch_indices,
                                    a.observation_tissue_removal,
                                    a.observation_location_stock,
                                    a.admin_validation'

            )
      );
  
      $query->from('`#__stranding_admin` AS a');

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

    // Extended data output
    protected function getListQuery() {
      // Create a new query object.
      $db = $this->getDbo();
      $query = $db->getQuery(true);

      // Select the required fields from the table.
      $query->select(
              $this->getState(
                      'list.select', 'CONCAT("EC",Year(observation_datetime),"-","0",a.id,"-","0",id_location),
                                      Year(observation_datetime),
                                      Month(observation_datetime),
                                      a.observation_datetime,
                                      a.observation_commune,
                                      CONCAT(observation_localisation," ", observation_region),
                                      a.observation_latitude,
                                      a.observation_longitude,
                                      a.observation_spaces,
                                      a.observation_stranding_type,
                                      a.observation_number,
                                      CONCAT(a.observer_name, " ", observer_address, " ", observer_tel, " ", observer_email),
                                      CONCAT(informant_name, " ", informant_address, " ", informant_tel, " ", informant_email),
                                      a.remarks,
                                      a.id,
                                      a.observer_name,
                                      a.admin_validation'

              )
      );
         
      $query->from('`#__stranding_admin` AS a');

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

    // The animal data output
    protected function getListQuery() {
    // Create a new query object.
    $db = $this->getDbo();
    $query = $db->getQuery(true);

    // Select the required fields from the table.
    $query->select(
            $this->getState(
                    'list.select', 'CONCAT("EC",Year(observation_datetime),"-","0",a.id,"-","0",id_location),
                                    a.observation_sex,
                                    a.observation_size,
                                    a.observation_color,
                                    a.observation_caudal,
                                    CONCAT(observation_beak, " ", observation_furrows),
                                    a.nb_teeth_upper_right,
                                    a.nb_teeth_upper_left,
                                    a.nb_teeth_lower_right,
                                    a.nb_teeth_lower_left,
                                    a.observation_teeth_base_diametre,
                                    a.observation_baleen_color,
                                    a.observation_baleen_height,
                                    a.observation_baleen_base_height,
                                    a.observation_defenses,
                                    a.observation_abnormalities,
                                    a.observation_capture_traces,
                                    a.catch_indices,
                                    CONCAT(observation_death,observation_alive),
                                    CONCAT(observation_datetime_death,observation_datetime_release),
                                    a.levies_protocole,
                                    a.label_references,
                                    observation_state_decomposition,
                                    a.observation_tissue_removal,
                                    a.observation_location_stock,
                                    a.remarks,
                                    a.id,
                                    a.observer_name,
                                    a.admin_validation'

              )
      );
         
      $query->from('`#__stranding_admin` AS a');

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

      $cols = array_keys($db->getTableColumns('#__stranding_admin'));

      // Count columns 
      $nb_columns = count($cols); 

      // Delete all the columns header
      for($cptr=0; $cptr<$nb_columns; $cptr++){ array_pop($cols); }

      if($var == 0) {
          array_push($cols, 'ID_OM', 'Espèce', 'Date_examen', 'Année','Collectivité', 'Dpt', 'Commune', 'Lieu', 'Position_latitude', 'Postion_longitude', 'Nombre', 'Sexe', 'Longueur', 'Précision', 'DCC', 'Informateur', 'Observateur', 'Observations','Prélèvements', 'Stockage_lieu');

          $items = $db->setQuery($this->getListQuerySimple())->loadObjectList();
          $csv =  fopen('php://output', 'w');
          fprintf($csv, chr(0xEF).chr(0xBB).chr(0xBF));
          fputcsv($csv, $cols);

          foreach($items as $line){
            $in = (array) $line;
            array_pop($in);
            array_pop($in);
            fputcsv($csv, (array) $in);
          }
        return fclose($csv);

      }else if($var == 1) {
            array_push($cols, 'References', 'Année', 'Mois', 'Date', 'Lieu', 'Espèce', 'Echouage isolé ou en groupe', "Nombre d'individus", 'Identification', 'Sexe', 'Contactes', "Origine de l'information", 'Remarques');
            $items = $db->setQuery($this->getListQuery())->loadObjectList();
            $csv =  fopen('php://output', 'w');
            fprintf($csv, chr(0xEF).chr(0xBB).chr(0xBF));
            fputcsv($csv, $cols);

            foreach($items as $line){
              $in = (array) $line;
              array_pop($in);
              array_pop($in);
              array_pop($in);
              array_pop($in);
              fputcsv($csv, (array) $in);
          }
        return fclose($csv);
      }else {
           array_push($cols, 'References', 'Sexe', 'Taille','Couleur','Encoche médiane à la caudale' , 'Animal mort ou vivant', 'DCC', 'Longueur', 'Prélèvements', 'Sexe', 'Les cause de la mort', 'Remarques');
            $items = $db->setQuery($this->getListQuery())->loadObjectList();
            $csv =  fopen('php://output', 'w');
            fprintf($csv, chr(0xEF).chr(0xBB).chr(0xBF));
            fputcsv($csv, $cols);

            foreach($items as $line){
              $in = (array) $line;
              array_pop($in);
              array_pop($in);
              array_pop($in);
              array_pop($in);
              fputcsv($csv, (array) $in);
          }
        return fclose($csv);
      }
      
    }

  }


