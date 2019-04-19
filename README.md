# Extension JOOMLA (>3.5) stranding_form 
Formulaires EchouageNC pour le report d'échouges de cétacés et de dugongs en Nouvelle-calédonie
© IRD, 2018

# Stockage des données : administrator/model/tables/stranding_admin.php
- code :  

		$keys_tab = array_keys($array);

        foreach ($keys_tab as $tab) {
            if (array_key_exists( $tab, $array ) && is_array( $array[ $tab] )) {
            $array[ $tab] = implode( ',', $array[ $tab] );
         }
        } 
- Les données de chaque animal sont stockées dans la colonne correspondante à cette caractéristique avec une virgule comme séparateur.
- Exemple: Si il y a trois animaux genre Dauphin, dans la colonne "Espèce" on aura Dauphin,Dauphin,Dauphin

# Base de données : administrator/sql/install.mysql.utf8.sql
- Le champ id_observation représente l'id de l'animal.
- Le champ id_location sert a identifier le lieu de l'échouage, c'est à dire que pour chaque animal échoué au même endroit leur id_location sera le même. 
L'idée est que id_location puisse être incrémenté en tenant compte de son ancienne valeur. (J'ai essayé de créé un trigger sans succès).
- L'idée: Si NEW.id_location <= OLD.id_location alors NEW.id_location = OLD.id_location+1; si l'anciènne valeur de id_location vaut 1 alors la nouvelle va valoir 2.  

# Le front-end (Formulaire) : /site/views/stranding_adminform/tmpl/default.php
- Pour les espèces j'ai séparer le "nom commun" du "genre" et de "l'espèce", à la demande de Claire. J'ai fait en sorte que lorsqu'on renseigne le "nom commun" les champs "genre" et "espèce(s)" se remplissent automatiquement.
- Pour le clonage de l'animal il fallait changer les "id" des champs (naturellement), et aussi mettre la fin des "name" [] pour les convertir en "array" afin de stocker chaque donnée. 
- Pour les latitudes et longitudes en format DMD, j'ai ajouté deux nouveaux champs pour contenir ces deux informations. L'idée est de cacher les anciens champs latitude et longitude, de faire appraître les nouveaux et de créer une fonction jQuery pour convertir les valeurs contenu dans les deux anciens champs pour les mettre dans les nouveaux. (Sans succès).

# Pour les langues revoir l'anglais.

# Pour info je me suis attardé sur les fonctionnalités et la mise en forme du formulaire.


