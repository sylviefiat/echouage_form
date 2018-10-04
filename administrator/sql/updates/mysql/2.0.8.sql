ALTER TABLE `#__cot_admin` ADD `id_location` INT(12) NOT NULL AFTER `id`;
ALTER TABLE `#__cot_admin` ADD `form_references` VARCHAR(50) NOT NULL AFTER `id`;

ALTER TABLE `#__cot_admin` ADD `informant_name` VARCHAR(100) NOT NULL AFTER `observer_email`;
ALTER TABLE `#__cot_admin` ADD `informant_tel` VARCHAR(100) NOT NULL AFTER `informant_name`;
ALTER TABLE `#__cot_admin` ADD `informant_email` VARCHAR(100) NOT NULL AFTER `informant_tel`;

ALTER TABLE `#__cot_admin`
ADD COLUMN `observation_spaces` VARCHAR(100) NOT NULL,
ADD COLUMN `observation_spaces_identification` VARCHAR(100) NOT NULL,
ADD COLUMN `observation_size` VARCHAR(100) NOT NULL,
ADD COLUMN `observation_sex` VARCHAR(100) NOT NULL,
ADD COLUMN `observation_state_decomposition` VARCHAR(100) NOT NULL,
ADD COLUMN `observation_abnormalities` VARCHAR(250) NOT NULL,
ADD COLUMN `levies_protocole` VARCHAR(100) NOT NULL
AFTER `observation_number`;

ALTER TABLE `#__cot_admin`
DROP `observation_culled`,
DROP `counting_method_timed_swim`,
DROP `counting_method_distance_swim`,
DROP `counting_method_other`,
DROP `depth_range`,
DROP `observation_method`;

ALTER TABLE `#__cot_admin` CHANGE `remarks` `remarks` TEXT NOT NULL AFTER `observation_abnormalities` ;
ALTER TABLE `#__cot_admin` CHANGE `localisation` `localisation` POINT NOT NULL AFTER `remarks` ;
ALTER TABLE `#__cot_admin` CHANGE `created_by` `created_by` INT(11) NOT NULL AFTER `localisation` ;
ALTER TABLE `#__cot_admin` CHANGE `admin_validation` `admin_validation` TINYINT(1) NOT NULL DEFAULT 0 AFTER `created_by` ;

ALTER TABLE `#__cot_admin` CHANGE `levies_protocole` `levies_protocole` VARCHAR(100) NOT NULL AFTER `observation_abnormalities` ;
ALTER TABLE `#__cot_admin` CHANGE `form_references` `form_references` VARCHAR(50) NOT NULL DEFAULT 'EC2018' ;
ALTER TABLE `#__cot_admin` CHANGE `observation_date` `observation_datetime` DATE NOT NULL ;

ALTER TABLE `#__cot_admin` ADD `observation_datetime_death` DATE NOT NULL AFTER `observation_state` ;
ALTER TABLE `#__cot_admin` ADD `observation_datetime_release` DATE NOT NULL AFTER `observation_datetime_death` ;

ALTER TABLE `#__cot_admin` ADD `observer_address` VARCHAR(200) NOT NULL AFTER `observer_name`;
ALTER TABLE `#__cot_admin` ADD `informant_address` VARCHAR(200) NOT NULL AFTER `informant_name`;
ALTER TABLE `#__cot_admin` ADD `observation_stranding_type` VARCHAR(100) NOT NULL AFTER `observation_longitude`;
ALTER TABLE `#__cot_admin` ADD `observation_caudal` VARCHAR(100) NOT NULL AFTER `observation_size`;
ALTER TABLE `#__cot_admin` CHANGE `observation_country_code` `observation_country_code` VARCHAR(100) NOT NULL AFTER `remark`;
ALTER TABLE `#__cot_admin` ADD `observation_death` VARCHAR(100) NOT NULL AFTER `observation_state`;

ALTER TABLE `#__cot_admin` CHANGE `observation_spaces` `observation_spaces` VARCHAR(100) NOT NULL AFTER `observation_number`;
ALTER TABLE `#__cot_admin` CHANGE `observation_spaces_identification` `observation_spaces_identification` VARCHAR(100) NOT NULL AFTER `observation_spaces`;
ALTER TABLE `#__cot_admin` CHANGE `observation_sex` `observation_sex` VARCHAR(100) NOT NULL AFTER `observation_spaces_identification`;
ALTER TABLE `#__cot_admin` ADD `observation_color` VARCHAR(100) NOT NULL AFTER `observation_sex`;
ALTER TABLE `#__cot_admin` CHANGE `observation_caudal` `observation_caudal` VARCHAR(50) NOT NULL AFTER `observation_color`;
ALTER TABLE `#__cot_admin` CHANGE `observation_abnormalities` `observation_abnormalities` VARCHAR(50) NOT NULL AFTER `observation_caudal`;
ALTER TABLE `#__cot_admin` CHANGE `observation_size` `observation_size` VARCHAR(100) NOT NULL AFTER `observation_spaces_identification`;
ALTER TABLE `#__cot_admin` ADD `observation_alive` VARCHAR(100) NOT NULL AFTER `observation_datetime_death`;
ALTER TABLE `#__cot_admin` CHANGE `observation_state_decomposition` `observation_state_decomposition` VARCHAR(100) NOT NULL AFTER `observation_datetime_death`;

ALTER TABLE cetace_cot_admin ADD `observation_capture_traces` VARCHAR(50) NOT NULL AFTER `observation_abnormalities`;
ALTER TABLE cetace_cot_admin ADD `catch_indices` VARCHAR(100) NOT NULL AFTER `observation_capture_traces`;

ALTER TABLE `#__cot_admin` CHANGE `observation_datetime_death` `observation_datetime_death` DATE NULL;
ALTER TABLE `#__cot_admin` CHANGE `observation_datetime_release` `observation_datetime_release` DATE NULL;

ALTER TABLE cetace_cot_admin
ADD `observation_furrows` VARCHAR(100) NOT NULL,
ADD `nb_teeth_upper_right` VARCHAR(100) NOT NULL,
ADD `nb_teeth_upper_left` VARCHAR(100) NOT NULL,
ADD `nb_teeth_lower_right` VARCHAR(100) NOT NULL,
ADD `nb_teeth_lower_left` VARCHAR(100) NOT NULL,
ADD `observation_base_diametre` VARCHAR(100) NOT NULL,
ADD `observation_baleen_color` VARCHAR(100) NOT NULL,
ADD `observation_baleen_height` VARCHAR(100) NOT NULL,
ADD `observation_baleen_base_diametre` VARCHAR(100) NOT NULL, 
ADD `observation_defenses` VARCHAR(100) NOT NULL;

ALTER TABLE `#__cot_admin` CHANGE `observation_furrows` `observation_furrows` VARCHAR(100) NOT NULL AFTER `observation_beak`;
ALTER TABLE `#__cot_admin` CHANGE `nb_teeth_upper_right` `nb_teeth_upper_right` VARCHAR(100) NOT NULL AFTER `observation_furrows`;
ALTER TABLE `#__cot_admin` CHANGE `nb_teeth_upper_left` `nb_teeth_upper_left` VARCHAR(100) NOT NULL AFTER `nb_teeth_upper_right`;
ALTER TABLE `#__cot_admin` CHANGE `nb_teeth_lower_right` `nb_teeth_lower_right` VARCHAR(100) NOT NULL AFTER `nb_teeth_upper_left`;
ALTER TABLE `#__cot_admin` CHANGE `nb_teeth_lower_left` `nb_teeth_lower_left` VARCHAR(100) NOT NULL AFTER `nb_teeth_lower_right`;
ALTER TABLE `#__cot_admin` CHANGE `observation_base_diametre` `observation_base_diametre` VARCHAR(100) NOT NULL AFTER `nb_teeth_lower_left`;
ALTER TABLE `#__cot_admin` CHANGE `observation_baleen_color` `observation_baleen_color` VARCHAR(100) NOT NULL AFTER `observation_base_diametre`;
ALTER TABLE `#__cot_admin` CHANGE `observation_baleen_height` `observation_baleen_height` VARCHAR(100) NOT NULL AFTER `observation_baleen_color`;
ALTER TABLE `#__cot_admin` CHANGE `observation_baleen_base_diametre` `observation_baleen_base_diametre` VARCHAR(100) NOT NULL 
AFTER `observation_baleen_height`;
ALTER TABLE `#__cot_admin` CHANGE `observation_defenses` `observation_defenses` VARCHAR(100) NOT NULL AFTER `observation_baleen_base_diametre`;
