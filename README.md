<<<<<<< HEAD
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
- Les données de chaque animal sont stockées dans la colonne correspondante à cette caractéristique avec une virgules comme séparateur.
- Exemple: Si il y a trois animaux échoué genre 3 Dauphin, dans la colonne "Espèce" on aura Dauphin,Dauphin,Dauphin

# Base de données : administrator/sql/install.mysql.utf8.sql
- Le champ id_observation représente l'id de l'animal.
- Le champ id_location sert a identifié le lieu de l'échouage, c'est à dire que pour chaque animal échoué au même endroit leur id_location sera le même. L'idée et que id_location puisse être incrémenter en tenant compte de son ancienne valeure. (J'ai essayé de créé un trigger sans succès).
- Exemple sur id_location : - Jour 1 il y a eu 3 animaux échoué, ils auront tous les 3 comme "id_location" 1.
			    - Jour 2 il y a eu 1 animal échoué, son "id_loctaion" sera normalement 2.
Le problème est que, quand le deuxième échouage est enregistré "id_location" recommence à 1.
- L'idée que j'ai eu pour les trigers (à testé avec JS): Si NEW.id_location <= OLD.id_location alors NEW.id_location = OLD.id_location+1; si l'anciènne valeure de id_location vaut 1 alors la nouvelle va valoire 2.  

# Le front-end (Formulaire) : /site/views/stranding_adminform/tmpl/default.php
- Pour les espèces j'ai séparer le "nom commun" du "genre" et de "l'espèce", à la demande de Claire. J'ai fait en sorte que lorsqu'on renseigne le "nom commun" les champs "genre" et "espèce(s)" se remplissent automatiquement.
- Pour le clonage de l'animal il fallait changer les "id" des champs (naturellement), et aussi mettre la fin des "name" des [] pour les convertir en "array" afin de stocké chaques données pour les enregistrer dans la base. 
- Pour les latitudes et longitudes en format DMD, j'ai ajouté deux nouveaux champs pour contenir ces deux informations. L'idée est de cacher les anciens champs latitude et longitude, de faire appraître les nouveaux et de créer une fonction jQuery pour convertir les valeurs contenu dans les deux champs cacher pour les mettre dans les nouveaux. (Sans succès). Je ne suis pas arrivé à les convertir dans le même champs. 

# Pour les langues revoir l'anglais.

# Pour info je me suis attardé sur les fonctionnalités et la mise en forme du formulaire.


