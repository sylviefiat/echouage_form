ALTER TABLE `#__cot_admin` ADD `id_location` VARCHAR(50) NOT NULL AFTER `id`;
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
