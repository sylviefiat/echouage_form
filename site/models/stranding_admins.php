<?php

/**
 * @version     0.0.0
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
          'list.select', 
          'CONCAT("EC",Year(a.observation_datetime),"-","0",a.id,"-",b.observation_id),
          CONCAT(b.observation_species_genus," ",b.observation_species),
          a.observation_datetime,
          Year(a.observation_datetime),
          a.observation_country,
          988,
          a.observation_region,
          a.observation_localisation,
          a.observation_latitude,
          a.observation_longitude,
          a.observation_number,
          b.observation_sex,
          b.observation_size,
          b.observation_size_precision,
          b.observation_state_decomposition,
          CONCAT(a.informant_name, " ", a.informant_address, " ", a.informant_tel, " ", a.informant_email),
          CONCAT(a.observer_name, " ", a.observer_address, " ", a.observer_tel, " ", a.observer_email),
          b.remarks,
          b.sampling,
          b.observation_location_stock'
        )
      );

      $query->from('`#__stranding_admin` AS a, `#__stranding_animal` AS b');

      // Join over the created by field 'created_by'
      /*$query->select('created_by.name AS created_by');
      $query->join('LEFT', '#__users AS created_by ON created_by.id = a.created_by');
*/
      $query->where('a.id = b.stranding_id');

      return $query;
    }

    // Simple data output
    protected function getListQueryComplex() {
      // Create a new query object.
      $db = $this->getDbo();
      $query = $db->getQuery(true);

      // Select the required fields from the table.
      $query->select(
        $this->getState(
          'list.select', 
          'CONCAT("EC",Year(a.observation_datetime),"-",a.id,"-",b.observation_id),
          Year(a.observation_datetime),
          Month(a.observation_datetime),
          a.observation_datetime,
          a.observation_region,
          a.observation_localisation,
          a.observation_country,
          a.observation_latitude,
          a.observation_longitude,
          a.observation_stranding_type,
          a.observation_number,
          b.observation_species_common_name,
          b.observation_species_genus,
          b.observation_species,
          b.observation_species_identification,
          b.observation_sex,
          b.observation_size,
          b.observation_color,
          a.observer_name,
          CONCAT(a.observer_address, " ", a.observer_tel, " ", a.observer_email),
          a.informant_name,
          CONCAT(a.informant_address, " ", a.informant_tel, " ", a.informant_email),
          b.sampling,
          b.photos,
          b.observation_caudal,
          b.observation_beak_or_furrows,
          b.observation_tooth_or_baleen_or_defenses,
          b.nb_teeth_upper_right,
          b.nb_teeth_upper_left,
          b.nb_teeth_lower_right,
          b.nb_teeth_lower_left,
          b.observation_teeth_base_diametre,
          b.observation_baleen_color,
          b.observation_baleen_height,
          b.observation_baleen_base_height,
          b.observation_abnormalities,
          b.observation_capture_traces,
          b.catch_indices,
          b.observation_state_decomposition,
          b.observation_datetime_death,
          b.observation_datetime_release,
          b.sampling_protocole,
          b.label_references,
          CASE WHEN lower(b.observation_dead_or_alive)="mort" b.observation_tissue_removal_dead ELSE b.observation_tissue_removal_alive,
          b.observation_mesure_a,
          b.observation_mesure_b,
          b.observation_mesure_c,
          b.observation_mesure_d,
          b.observation_mesure_e,
          b.observation_mesure_f,
          b.observation_mesure_g,
          b.observation_mesure_h,
          b.observation_mesure_i,
          b.observation_mesure_j,
          b.observation_mesure_k,
          b.observation_mesure_l,
          b.observation_mesure_m,
          b.observation_mesure_n,
          b.observation_mesure_o,
          b.observation_mesure_p,
          b.observation_mesure_q,
          b.observation_mesure_r,
          b.observation_mesure_s,
          b.observation_mesure_t,
          b.observation_mesure_u,
          b.observation_mesure_v,
          b.observation_location_stock,
          b.remarks'
        )
      );

      $query->from('`#__stranding_admin` AS a, `#__stranding_animal` AS b');

      // Join over the created by field 'created_by'
      /*$query->select('created_by.name AS created_by');
      $query->join('LEFT', '#__users AS created_by ON created_by.id = a.created_by');
      */
      $query->where('a.id = b.stranding_id');

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
          'list.select', 'CONCAT("EC",Year(observation_datetime),"-","0",a.id,"-","0"),
          Year(observation_datetime),
          Month(observation_datetime),
          a.observation_datetime,
          a.observation_region,
          a.observation_localisation,
          a.observation_location,
          a.observation_latitude,
          a.observation_longitude,
          a.observation_stranding_type,
          a.observation_number,
          
          a.observer_name,
          CONCAT(observer_address, " ", observer_tel, " ", observer_email),
          a.informant_name, 
          CONCAT(informant_address, " ", informant_tel, " ", informant_email),
          
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
        //$delimiter = ';';
        //$enclosure = '"';

        if($var == 0) {
          array_push($cols, 'ID_OM', 'Espèce', 'Date_examen', 'Année','Collectivité', 'Dpt', 'Commune', 'Lieu', 'Position_latitude', 'Postion_longitude', 'Nombre', 'Sexe', 'Longueur','precision', 'DCC', 'Informateur', 'Observateur', 'Observations','Prélèvements', 'Stockage_lieu');

          $csv =  fopen('php://output', 'w');
          // encodage pour excel windows
          //fputcsv($csv, $cols, $delimiter, $enclosure);
          fprintf($csv, chr(0xEF).chr(0xBB).chr(0xBF));
          fputcsv($csv, $cols);

          $items = $db->setQuery($this->getListQuerySimple())->loadObjectList();
          foreach($items as $line){
            $in = (array) $line;
            array_pop($in);
            array_pop($in);
            // Début : Convertion d'une chaîne UTF-8 en ISO-8859-1
            /*$keys_in = array_keys($in);
            $i = 0;
            while($i < count($keys_in)){
            $data = $keys_in_1[$i];
            $in[$data] = utf8_decode ($in[$data]);
            $i++;
            }*/
            // Fin : Convertion d'une chaîne UTF-8 en ISO-8859-1
            //fputcsv($csv, (array) $in, $delimiter, $enclosure);
            fputcsv($csv, (array) $in);
          }
          return fclose($csv);

        }else if($var == 1) {
          array_push($cols, 'Réferences', 'Année', 'Mois', 'Date', 'Commune', 'Lieu', 'Information complémentaire sur le lieu','Latitude', 'Longitude',  'Echouage isolé ou en groupe', "Nombre d'individus", 'Nom commun','Genre','Espèce', 'Identification', 'Sexe', 'Taille', 'Couleur',"Nom de l'observateur", "Contact de l'observateur", "Nom de l'informateur","Contact de l'informateur", 'Prélèvements','Photos', 'Encoche médiane à la caudale', 'Bec/Sillons sous la gorge', 'Dents/Fanons/Défenses','Nombre de dents en haut à droite', 'Nombre de dents en haut à gauche', 'Nombre de dents en bas à droite', 'Nombre de dents en bas à gauche', 'Diamètre à la base', 'Couleur des fanons', 'Hauteur des fanons', 'largeure à la base','Présence de blessures, morssures', 'Présence de traces de capture', 'Indices de capture', 'DCC','Date de la mort', "Date de la remise à l'eau", 'Protocole de prélèvements', 'Référence sur les étiquettes', 'Prélèvements de tissus', 'Mesure A', 'Mesure B', 'Mesure C', 'Mesure D', 'Mesure E', 'Mesure F', 'Mesure G', 'Mesure H', 'Mesure I', 'Mesure J', 'Mesure K', 'Mesure L', 'Mesure M','Mesure N', 'Mesure O', 'Mesure P', 'Mesure Q', 'Mesure R', 'Mesure S', 'Mesure T', 'Mesure U', 'Mersure V', 'Lieu de stockage', 'Remarques');
          
          $csv =  fopen('php://output', 'w');
          // encodage pour excel windows
          //fputcsv($csv, $cols, $delimiter, $enclosure);
          fprintf($csv, chr(0xEF).chr(0xBB).chr(0xBF));
          fputcsv($csv, $cols);

          $items = $db->setQuery($this->getListQueryComplex())->loadObjectList();
          foreach($items as $line){
            $in = (array) $line;

            array_pop($in);
            array_pop($in);
            array_pop($in);

            // Début : Convertion d'une chaîne UTF-8 en ISO-8859-1
            /*$keys_in = array_keys($in);
            $i = 0;
            while($i < count($keys_in)){
            $data = $keys_in_1[$i];
            $in[$data] = utf8_decode ($in[$data]);
            $i++;
            }*/
            // Fin : Convertion d'une chaîne UTF-8 en ISO-8859-1
            //fputcsv($csv, (array) $in, $delimiter, $enclosure);
            fputcsv($csv, (array) $in);
          }
          return fclose($csv);
        }
      }
    }


