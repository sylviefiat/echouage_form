CREATE TABLE IF NOT EXISTS `#__stranding_admin` (
	`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
	`id_location` INT(12) NOT NULL,
	`observer_name` VARCHAR(100)  NOT NULL,
	`observer_address` VARCHAR(250) NOT NULL,
	`observer_tel` VARCHAR(100)  NOT NULL,
	`observer_email` VARCHAR(100)  NOT NULL,
	`informant_name` VARCHAR(100) NOT NULL,
	`informant_address` VARCHAR(250) NOT NULL,
	`informant_tel` VARCHAR(100) NOT NULL,
	`informant_email` VARCHAR(100) NOT NULL,
	`observation_datetime` DATE NOT NULL,
	`observation_hours` VARCHAR(100) NOT NULL,
	`observation_minutes` VARCHAR(100) NOT NULL,
	`observation_location` TEXT NOT NULL,
	`observation_localisation` VARCHAR(100) NOT NULL,
	`observation_region` VARCHAR(100) NOT NULL,
	`observation_country` VARCHAR(100) NOT NULL,
	`observation_latitude` VARCHAR(100) NOT NULL,
	`observation_latitude_dmd` VARCHAR(100) NOT NULL,
	`observation_longitude` VARCHAR(100) NOT NULL,
	`observation_longitude_dmd` VARCHAR(100) NOT NULL,
	`observation_commune` VARCHAR(100) NOT NULL,
	`observation_stranding_type` VARCHAR(100) NOT NULL,
	`observation_number` VARCHAR(100)  NOT NULL,
	`localisation` POINT NOT NULL ,
	`created_by` INT(11)  NOT NULL ,
	`observation_country_code` VARCHAR(100) NOT NULL,
	`admin_validation` BOOLEAN NOT NULL default 0,
	PRIMARY KEY (`id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 DEFAULT COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `#__stranding_animal` (
	`observation_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
	`stranding_id` int(11) UNSIGNED NOT NULL,
	`observation_species_common_name` VARCHAR(100) NOT NULL,
	`observation_species_genus` VARCHAR(100) NOT NULL,
	`observation_species` VARCHAR(100) NOT NULL,
	`observation_species_identification` VARCHAR(11) NOT NULL,
	`observation_size` VARCHAR(100) NOT NULL,
	`observation_size_precision` VARCHAR(100) NOT NULL,
	`observation_sex` VARCHAR(100) NOT NULL,
	`observation_color` VARCHAR(100) NOT NULL,
	`observation_caudal` VARCHAR(100) NOT NULL,
	`observation_beak_or_furrows` VARCHAR(100) NOT NULL,
	`observation_tooth_or_baleen_or_defenses` VARCHAR(100) NOT NULL,
	`nb_teeth_upper_right` VARCHAR(100) NOT NULL,
	`nb_teeth_upper_left` VARCHAR(100) NOT NULL,
	`nb_teeth_lower_right` VARCHAR(100) NOT NULL,
	`nb_teeth_lower_left` VARCHAR(100) NOT NULL,
	`observation_teeth_base_diametre` VARCHAR(100) NOT NULL,
	`observation_baleen_color` VARCHAR(100) NOT NULL,
	`observation_baleen_height` VARCHAR(100) NOT NULL,
	`observation_baleen_base_height` VARCHAR(100) NOT NULL,
	`observation_abnormalities` VARCHAR(100) NOT NULL,
	`observation_capture_traces` VARCHAR(100) NOT NULL,
	`catch_indices` VARCHAR(100) NOT NULL,
	`observation_dead_or_alive` VARCHAR(100) NOT NULL,
	`observation_death` VARCHAR(100) NOT NULL,
	`observation_datetime_death` TIMESTAMP NOT NULL,
	`observation_state_decomposition` VARCHAR(100) NOT NULL,
	`observation_alive` VARCHAR(100) NOT NULL,
	`observation_datetime_release` TIMESTAMP NOT NULL,
	`sampling_protocole` VARCHAR(100) NOT NULL,
	`sampling` VARCHAR(100) NOT NULL,
	`photos` VARCHAR(100) NOT NULL,
	`upload_photos` TEXT NOT NULL,
	`label_references` VARCHAR(250) NOT NULL,
	`observation_tissue_removal_dead` VARCHAR(200) NOT NULL,
	`observation_tissue_removal_alive` VARCHAR(100) NOT NULL,
	`observation_mesure_a` VARCHAR(100) NOT NULL,
	`observation_mesure_b` VARCHAR(100) NOT NULL,
	`observation_mesure_c` VARCHAR(100) NOT NULL,
	`observation_mesure_d` VARCHAR(100) NOT NULL,
	`observation_mesure_e` VARCHAR(100) NOT NULL,
	`observation_mesure_f` VARCHAR(100) NOT NULL,
	`observation_mesure_g` VARCHAR(100) NOT NULL,
	`observation_mesure_h` VARCHAR(100) NOT NULL,
	`observation_mesure_i` VARCHAR(100) NOT NULL,
	`observation_mesure_j` VARCHAR(100) NOT NULL,
	`observation_mesure_k` VARCHAR(100) NOT NULL,
	`observation_mesure_l` VARCHAR(100) NOT NULL,
	`observation_mesure_m` VARCHAR(100) NOT NULL,
	`observation_mesure_n` VARCHAR(100) NOT NULL,
	`observation_mesure_o` VARCHAR(100) NOT NULL,
	`observation_mesure_p` VARCHAR(100) NOT NULL,
	`observation_mesure_q` VARCHAR(100) NOT NULL,
	`observation_mesure_r` VARCHAR(100) NOT NULL,
	`observation_mesure_s` VARCHAR(100) NOT NULL,
	`observation_mesure_t` VARCHAR(100) NOT NULL,
	`observation_mesure_u` VARCHAR(100) NOT NULL,
	`observation_mesure_v` VARCHAR(100) NOT NULL,
	`observation_location_stock` VARCHAR(250) NOT NULL,
	`remarks` TEXT NOT NULL,
	PRIMARY KEY (`observation_id`)/*,
	FOREIGN KEY (stranding_id) REFERENCES `#__stranding_admin` (id)*/)
ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 DEFAULT COLLATE=utf8mb4_unicode_ci;
	 


CREATE TRIGGER `#__trig_stranding_admin_insert` BEFORE INSERT ON `#__stranding_admin`
FOR EACH ROW SET NEW.localisation = GeomFromText( CONCAT('POINT(', NEW.observation_longitude, ' ', NEW.observation_latitude, ')' )),
				 NEW.id_location = NEW.id;

CREATE TRIGGER `#__trig_stranding_admin_update` BEFORE UPDATE ON `#__stranding_admin`
FOR EACH ROW SET NEW.localisation = GeomFromText( CONCAT('POINT(', NEW.observation_longitude, ' ', NEW.observation_latitude, ')' )),
				 NEW.id_location = NEW.id;

