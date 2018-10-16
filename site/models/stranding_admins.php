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
                                    a.observation_region,
                                    a.observation_localisation,
                                    a.observation_latitude,
                                    a.observation_longitude,
                                    a.observation_number,
                                    a.observation_sex,
                                    a.observation_size,
                                    a.observation_size_precision,
                                    CONCAT(observation_state_decomposition, observation_alive),
                                    CONCAT(informant_name, " ", informant_address, " ", informant_tel, " ", informant_email),
                                    CONCAT(observer_name, " ", observer_address, " ", observer_tel, " ", observer_email),
                                    a.catch_indices,
                                    a.levies,
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
                                      a.observation_region,
                                      a.observation_localisation,
                                      a.observation_latitude,
                                      a.observation_longitude,
                                      a.observation_stranding_type,
                                      a.observation_number,
                                      a.observation_spaces,
                                      a.observation_spaces_identification,
                                      a.observation_sex,
                                      a.observation_size,
                                      a.observation_color,
                                      CONCAT(a.observer_name, " ", observer_address, " ", observer_tel, " ", observer_email),
                                      CONCAT(informant_name, " ", informant_address, " ", informant_tel, " ", informant_email),
                                      a.levies,
                                      a.photos,
                                      a.observation_caudal,
                                      CONCAT(observation_beak, observation_furrows, observation_defenses),
                                      a.nb_teeth_upper_right,
                                      a.nb_teeth_upper_left,
                                      a.nb_teeth_lower_right,
                                      a.nb_teeth_lower_left,
                                      a.observation_teeth_base_diametre,
                                      a.observation_baleen_color,
                                      a.observation_baleen_height,
                                      a.observation_baleen_base_height,
                                      a.observation_abnormalities,
                                      a.observation_capture_traces,
                                      a.catch_indices,
                                      CONCAT(observation_state_decomposition,observation_alive),
                                      a.observation_datetime_death,
                                      a.observation_datetime_release,
                                      a.levies_protocole,
                                      a.label_references,
                                      CONCAT(observation_tissue_removal_dead, observation_tissue_removal_alive),
                                      a.observation_location_stock,
                                      a.remarks,
                                      a.observer_name,
                                      a.id,
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
            array_push($cols, 'References', 'Année', 'Mois', 'Date', 'Commune', 'Lieu', 'Latitude', 'Longitude',  'Echouage isolé ou en groupe', "Nombre d'individus",'Espèce', 'Identification', 'Sexe', 'Taille', 'Couleur', "Contact de l'observateur", "Origine de l'information", 'Prélèvements','Photos', 'Encoche médiane à la caudale', 'Bec, sillons sous la gorge ou défenses', 'Nombre de dents en haut à droite', 'Nombre de dents en haut à gauche', 'Nombre de dents en bas à droite', 'Nombre de dents en bas à gauche', 'Diamètre à la base', 'Couleur des fanons', 'Hauteur des fanons', 'largeure à la base','Présence de blessures, morssures', 'Présence de traces de capture', 'Indices de capture', 'DCC','Date de la mort', "Date de la remise à l'eau", 'Protocole de prélèvements', 'Référence sur les étiquettes', 'Prélèvements de tissus','Lieu de stockage','Remarques');
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


