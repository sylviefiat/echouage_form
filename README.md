<<<<<<< HEAD
# Extension JOOMLA (>3.5) stranding_form 
Formulaires EchouageNC pour le report d'échouges de cétacés et de dugongs en Nouvelle-calédonie
© IRD, 2018

# Stockage des données : administrator/model/tables/stranding_admin.php
- code :  $keys_tab = array_keys($array);

        foreach ($keys_tab as $tab) {
            if (array_key_exists( $tab, $array ) && is_array( $array[ $tab] )) {
            $array[ $tab] = implode( ',', $array[ $tab] );
         }
        } 
- Les données de chaque animal sont stockées dans la colonne correspondant à cette caractéristiques et sont séparées par des virgules.
- Exemple: Si il y a trois animaux genre Dauphin, dans la colonne Espèce on aura Dauphin,Dauphin,Dauphin

# Base de données : administrator/sql/install.mysql.utf8.sql
- Le champ id_observation est l'id de l'animal.
- Le champ id_location sert a identifié les animaux qui sont échoués sur le même lieu, c'est à dire que chacun de ces animaux aurons le même id_location. Il doit être incrémenter en fonction de id_observation, l'idée et que id_location puisse être incrémenter en tenant compte de son ancienne valeure. (J'ai essayé de créé un trigger sans succès).
- L'idée: Si NEW.id_location = OLD.id_location; Donc si id_location vaut déjà 1 alors le nouveau va valoire 2.  

# Le front-end (Formulaire) : /site/views/stranding_adminform/tmpl/default.php
- Pour les espèces j'ai séparer le "nom commun" du "genre" et de "l'espèce", à la demande de Claire. Le code JS qui permet de remplire automatiquement les champs "Genre" et "Espèce(s)" en renseignant le "Nom commun", va de la ligne 194 à la ligne 391.
- Le clonage de l'animal commence de la ligne 500 et se termine à la ligne 974, les differentes fonctions notament pour afficher et/ou masquer des champs ou encore la fonction pour les espèces sont reprisent dans la partie de clonage en y ajoutant l'indice de clonage 'cloneId' pour permettre de différencier les id et la name de chaque champs. 
- Pour les latitudes et longitudes en format DMD, j'ai ajouté deux nouveaux champs pour contenir ces deux informations. L'idée que j'ai trouvé et de cacher les anciens champs latitude et longitude ensuite de faire appraître les nouveaux et de créer une fonction jQuery pour convertir de les valeurs contenu dans les deux anciens champs pour les mettre dans les nouveaux. (Sans succès).

# Pour les langues revoir l'anglais.

# Pour info je me suis attardé sur les fonctionnalités et la mise en forme du formulaire.


