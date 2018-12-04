# Extension JOOMLA (>3.5) stranding_form 
Formulaires Echouages NC pour la signalisation des échouages de mammifères marins en Nouvelle-Calédonie
© IRD, 2018


# Stockage des données: adminstrator/tables/stranding_admin.php
- code:
	$keys_tab = array_keys($array);
	        foreach ($keys_tab as $tab) {
	            if (array_key_exists( $tab, $array ) && is_array( $array[ $tab] )) {
	            $array[ $tab] = implode( ',', $array[ $tab] );
	         }
	        }
Dans le cas où il y a échouage en group la même données est stocké dans le même champs et chancunes d'elles est séparer par une virgule.


# Base de données : administrator/sql/install.mysql.utf8.sql
- Le champs id_location représente l'id du lieu et devra être incréménter en fonction de l'id. Exemple si id = 1 donc id_location vudra 1 aussi. 

