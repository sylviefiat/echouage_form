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

public function getCsv()
    {
      $this->populateState();
      $db = $this->getDbo();

      $cols = array_keys($db->getTableColumns('#__cot_admin'));

      // Count the columns number
      $nb_columns = count($cols); 

      // Delete the columns header
      for($cptr=0; $cptr<$nb_columns; $cptr++){ array_pop($cols); }
      
      array_push($cols, 'Id', 'Référence', 'Id_location', 'Observateur', 'Informateur', 'Espèce', 'Date_examen', 'Année', 'Collectivité', 'Dpt', 'Commune', 'Lieu', 'Position_latitude', 'Postion_longitude', 'Nombre', 'Sexe', 'Longueur', 'Précision', 'DCC', 'Observations', 'Prélèvements', 'Stockage_lieu');

      

      // New field's index
      $id = array_search('Id', $cols);
      $id_location = array_search('Id_location', $cols);
      $spaces = array_search('Espèce', $cols);
      $date = array_search('Date_examen', $cols);
      $year = array_search('Année', $cols);
      $country = array_search('Collectivité', $cols);
      $dpt = array_search('Dpt', $cols);
      $region = array_search('Commune', $cols);
      $place = array_search('Lieu', $cols);
      $lat = array_search('Position_latitude', $cols);
      $long = array_search('Postion_longitude', $cols);
      $number = array_search('Nombre', $cols);
      $sex = array_search('Sexe', $cols);
      $size = array_search('Longueur', $cols);
      $precision = array_search('Précision', $cols);
      $dcc = array_search('DCC', $cols);
      $informant = array_search('Informateur', $cols);
      $observer = array_search('Observateur', $cols);
      $observations = array_search('Observations', $cols);
      $levies = array_search('Prélèvements', $cols);
      $stock = array_search('Stockage_lieu', $cols);

      $ob_name = array_search('observer_name', $cols);
      $ob_address = array_search('observer_address', $cols);
      $ob_tel = array_search('observer_tel', $cols);
      $ob_email = array_search('observer_email', $cols);

      $ob_lat = array_search('observer_latitude', $cols);
      $ob_long = array_search('observer_longitude', $cols);

      // Changement d'index pour que les nouveaux champs soient bien placés
      $cols = $this->change_key( $cols, $lat, $ob_lat );
      $cols = $this->change_key( $cols, $long, $ob_long );

      // nettoyage des variables à la fin de leur utilisation
      unset($lat, $long, $ob_lat, $ob_long);

      $items = $db->setQuery($this->getListQuery())->loadObjectList();
      $csv =  fopen('php://output', 'w');
      fprintf($csv, chr(0xEF).chr(0xBB).chr(0xBF));
      fputcsv($csv, $cols);

      foreach($items as $line){
        $in = (array) $line;
        for($cptr=1; $cptr<5; $cptr++){ array_pop($in); }

        // déplacement des données
          $lat =  $in['observation_latitude'];
          $long = $in['observation_longitude'];
          $ob_lat = $in['Position_latitude'];
          $ob_long = $in['Postion_longitude'];

        // Echange des données des champs spécifier
          $in['Position_latitude'] = $lat;
          $in['Postion_longitude'] = $long;
          $in['observation_latitude'] = $ob_lat;
          $in['observation_longitude'] = $ob_long;
        // Fin: Echange des données

        // nettoyage des variables à la fin de leur utilisation
            unset($num, $culled, $lat_dmd, $long_dmd, $remarks);


        fputcsv($csv, (array) $in);
      }

      return fclose($csv);
    }
  }

/*
    // Fonction de conversion latitude_dmd
    public function convert_Lat_DMD($lat) {
      if($lat >= 0) $lat_dir = 'N';
      else $lat_dir = 'S';
      // Garde la partie entière
      $lat_deg = ( abs( ( int ) $lat ) );
      $lat_min = ( abs( ( abs( $lat ) - $lat_deg ) * 60 ) );
      //    176 code ascci du degré. Ne garde que 3 décimales
      return $lat_deg . chr(176) . number_format($lat_min, 3) . "'" . $lat_dir;
    }

    // Fonction de conversion longitude_dmd
    public function convert_Long_DMD($long){
      if ($long >= 0) $long_dir = 'E';
      else $long_dir = 'W';
      // Garde la partie entière
      $long_deg = ( abs( ( int ) $long ) );
      $long_min = ( abs( ( abs( $long ) - $long_deg ) * 60 ) );
      //    176 code ascci du degré. Ne garde que 3 décimales
      return $long_deg . chr(176) . number_format($long_min, 3). "'" . $long_dir;
    }

    // Fonction de changement d'index
    public function change_key( $array, $old_key, $new_key ) {
      if( ! array_key_exists( $old_key, $array ) )
          return $array;
      // Retourne les indexes du tableau
      $keys = array_keys( $array );
      // Recherche l'ancien index dans le tableau et la remplace par le nouvel index
      $keys[ array_search( $old_key, $keys ) ] = $new_key;
      return array_combine( $keys, $array );
    }

    public function getCsv()
    {
      $this->populateState();
      $db = $this->getDbo();

      $cols = array_keys($db->getTableColumns('#__cot_admin'));

      // Enlève les headers des 4 derniers champs de la BD : state, localisation, created_by
      // et admin_validation
      for($cptr=1; $cptr<8; $cptr++){ array_pop($cols); }

      // Place les les deux champs lat_dmd et long_dmd à la fin
      array_push($cols, 'observation_latitude_dmd', 'observation_longitude_dmd');

      // indexes des nouveaux champs
      $lat_dmd = array_search('observation_latitude_dmd', $cols);
      $long_dmd = array_search('observation_longitude_dmd', $cols);
      $number = array_search('observation_number', $cols);
      $culled = array_search('observation_culled', $cols);

      // Changement d'index pour que les nouveaux champs soient bien placés
      $cols = $this->change_key( $cols, $number, $lat_dmd );
      $cols = $this->change_key( $cols, $culled, $long_dmd );

      // nettoyage des variables à la fin de
      // leur utilisation
      unset($lat_dmd, $long_dmd, $number, $culled);

      // Enlève le header du champ remarks
      unset($cols[array_search('remarks', $cols)]);

      // Place les champs déplacés en dernier
      array_push($cols, 'observation_number', 'observation_culled','remarks' );

      // Ouvre le fichier CSV
      $csv = fopen('php://output', 'w');

      $delimiter = ';';
      $enclosure = '"';
      // encodage pour excel windows
      //fprintf($csv, chr(0xEF).chr(0xBB).chr(0xBF));
      fputcsv($csv, $cols, $delimiter, $enclosure);
      // recupération des données dans la bdd
      $items = $db->setQuery($this->getListQuery())->loadObjectList();

      foreach ($items as $line)
      {
        // La ligne de données sous forme de tableau
               $in = (array) $line;

        // Enlève les données des 4 derniers champs de la BD : state, localistaion, created_by
        // et admin_validation
            for($cptr=1; $cptr<8; $cptr++){ array_pop($in); }

        // Début : Convertion d'une chaîne UTF-8 en ISO-8859-1
        $keys_in = array_keys($in);

        $i = 0;
        while($i < count($keys_in)){
          $data = $keys_in[$i];
          $in[$data] = utf8_decode ($in[$data]);
          $i++;
        }
        // Fin : Convertion d'une chaîne UTF-8 en ISO-8859-1

        // Convertion des lat et long
            $in['observation_latitude_dmd'] = $this->convert_Lat_DMD($in['observation_latitude']);
            $in['observation_longitude_dmd'] = $this->convert_Long_DMD($in['observation_longitude']);

        // déplacement des données
            $num = $in['observation_number'];
            $culled = $in['observation_culled'];
            $lat_dmd =  $in['observation_latitude_dmd'];
            $long_dmd = $in['observation_longitude_dmd'];
            $remarks = $in['remarks'];

        // Echange des données des champs spécifier
            $in['observation_number'] = $lat_dmd;
            $in['observation_culled'] = $long_dmd;
            $in['remarks'] = $num;
            $in['observation_latitude_dmd'] = $culled;
            $in['observation_longitude_dmd'] = $remarks;
        // Fin: Echange des données

        // nettoyage des variables à la fin de leur utilisation
            unset($num, $culled, $lat_dmd, $long_dmd, $remarks);

        // Réglage du format de la date
            $datetime = $in['observation_datetime'];
            $date = date_create($datetime);
            $in['observation_datetime'] =  date_format($date, "d/m/Y");

        fputcsv($csv, (array) $in, $delimiter,$enclosure);
      }
      return fclose($csv);
    }
    */


