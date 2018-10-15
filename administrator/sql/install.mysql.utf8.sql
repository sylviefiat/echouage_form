CREATE TABLE IF NOT EXISTS `#__stranding_admin` (
`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
`id_location` INT(12) NOT NULL,
`observer_name` VARCHAR(100)  NOT NULL,
`observer_address` VARCHAR(200) NOT NULL,
`observer_tel` VARCHAR(100)  NOT NULL,
`observer_email` VARCHAR(100)  NOT NULL,
`informant_name` VARCHAR(100) NOT NULL,
`informant_address` VARCHAR(200) NOT NULL,
`informant_tel` VARCHAR(100) NOT NULL,
`informant_email` VARCHAR(100) NOT NULL,
`observation_datetime` DATE NOT NULL,
`observation_location` TEXT NOT NULL,
`observation_localisation` VARCHAR(100) NOT NULL,
`observation_region` VARCHAR(100) NOT NULL,
`observation_country` VARCHAR(100) NOT NULL,
`observation_latitude` VARCHAR(100) NOT NULL,
`observation_longitude` VARCHAR(100) NOT NULL,
`observation_commune` VARCHAR(100) NOT NULL,
`observation_stranding_type` VARCHAR(100) NOT NULL,
`observation_number` VARCHAR(100)  NOT NULL,
`observation_spaces` VARCHAR(100) NOT NULL,
`observation_spaces_identification` VARCHAR(100) NOT NULL,
`observation_size` VARCHAR(100) NOT NULL,
`observation_size_precision` VARCHAR(50) NOT NULL,
`observation_sex` VARCHAR(100) NOT NULL,
`observation_color` VARCHAR(100) NOT NULL,
`observation_caudal` VARCHAR(50) NOT NULL,
`observation_beak` VARCHAR(100) NOT NULL,
`observation_furrows` VARCHAR(100) NOT NULL,
`nb_teeth_upper_right` VARCHAR(100) NOT NULL,
`nb_teeth_upper_left` VARCHAR(100) NOT NULL,
`nb_teeth_lower_right` VARCHAR(100) NOT NULL,
`nb_teeth_lower_left` VARCHAR(100) NOT NULL,
`observation_teeth_base_diametre` VARCHAR(100) NOT NULL,
`observation_baleen_color` VARCHAR(100) NOT NULL,
`observation_baleen_height` VARCHAR(100) NOT NULL,
`observation_baleen_base_height` VARCHAR(100) NOT NULL, 
`observation_defenses` VARCHAR(100) NOT NULL,
`observation_abnormalities` VARCHAR(50) NOT NULL,
`observation_capture_traces` VARCHAR(50) NOT NULL,
`catch_indices` VARCHAR(100) NOT NULL,
`observation_death` VARCHAR(100) NOT NULL,
`observation_datetime_death` VARCHAR(100) NOT NULL,
`observation_state_decomposition` VARCHAR(100) NOT NULL,
`levies_protocole` VARCHAR(100) NOT NULL,
`levies` VARCHAR(50) NOT NULL,
`photos` VARCHAR(50) NOT NULL,
`label_references` VARCHAR(250) NOT NULL,
`observation_alive` VARCHAR(100) NOT NULL,
`observation_datetime_release` VARCHAR(100) NOT NULL,
`observation_tissue_removal_dead` VARCHAR(200) NOT NULL,
`observation_tissue_removal_alive` VARCHAR(50) NOT NULL,
`observation_location_stock` VARCHAR(100) NOT NULL,
`remarks` TEXT NOT NULL,
`localisation` POINT NOT NULL ,
`created_by` INT(11)  NOT NULL ,
`observation_country_code` VARCHAR(100) NOT NULL,
`admin_validation` BOOLEAN NOT NULL default 0,
PRIMARY KEY (`id`)
) DEFAULT COLLATE=utf8_general_ci;


CREATE TRIGGER `#__trig_stranding_admin_insert` BEFORE INSERT ON `#__stranding_admin`
FOR EACH ROW SET NEW.localisation = GeomFromText( CONCAT('POINT(', NEW.observation_longitude, ' ', NEW.observation_latitude, ')' ));

CREATE TRIGGER `#__trig_stranding_admin_update` BEFORE UPDATE ON `#__stranding_admin`
FOR EACH ROW SET NEW.localisation = GeomFromText( CONCAT('POINT(', NEW.observation_longitude, ' ', NEW.observation_latitude, ')' ));


CREATE TRIGGER `#__trig_stranding_admin_id_location_insert` BEFORE INSERT ON `#__stranding_admin`
FOR EACH ROW SET NEW.id_location = id_location + 1;

CREATE TRIGGER `#__trig_stranding_admin_id_location_update` BEFORE UPDATE ON `#__stranding_admin`
FOR EACH ROW SET NEW.id_location = id_location + 1;





