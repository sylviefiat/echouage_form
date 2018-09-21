ALTER TABLE `#__cot_admin` CHANGE `observation_state` `observation_state` VARCHAR( 100 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `remarks` ;
ALTER TABLE `#__cot_admin` CHANGE `observation_datetime` `observation_datetime` DATE NOT NULL AFTER `observation_date` ;
