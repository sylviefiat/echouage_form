alter table `#__cot_admin` add `observation_date` date;
alter table `#__cot_admin` modify `observation_day` int(11) null;
alter table `#__cot_admin` modify `observation_month` int(11) null;
alter table `#__cot_admin` modify `observation_year` int(11) null;
update `#__cot_admin` set `observation_date`=STR_TO_DATE(CONCAT('01/',`observation_month`,'/',`observation_day`), '%d/%m/%Y') where `observation_day`=0 and `observation_month`<>0 and `observation_year`<>0;
update `#__cot_admin` set `observation_date`=STR_TO_DATE(CONCAT(`observation_day`,'/01/',`observation_year`), '%d/%m/%Y') where `observation_day`<>0 and `observation_month`=0 and `observation_year`<>0;
update `#__cot_admin` set `observation_date`=STR_TO_DATE(CONCAT('01/01/',`observation_year`), '%d/%m/%Y') where `observation_day`=0 and `observation_month`=0 and `observation_year`<>0;
update `#__cot_admin` set `observation_date`=STR_TO_DATE(CONCAT('01/01/2017'), '%d/%m/%Y') where `observation_day`=0 and `observation_month`=0 and `observation_year`=0;

DROP TRIGGER `#__trig_cot_admin_insert`;
CREATE TRIGGER `#__trig_cot_admin_insert` BEFORE INSERT ON `#__cot_admin`
FOR EACH ROW SET NEW.localisation = GeomFromText(CONCAT('POINT(', NEW.observation_longitude, ' ', NEW.observation_latitude, ')' )),NEW.observation_day = day(NEW.observation_date),NEW.observation_month=month(NEW.observation_date),NEW.observation_year=year(NEW.observation_date);

DROP TRIGGER `#__trig_cot_admin_update`;
CREATE TRIGGER `#__trig_cot_admin_update` BEFORE UPDATE ON `#__cot_admin`
FOR EACH ROW SET NEW.localisation = GeomFromText(CONCAT('POINT(', NEW.observation_longitude, ' ', NEW.observation_latitude, ')' )),NEW.observation_day = day(NEW.observation_date),NEW.observation_month=month(NEW.observation_date),NEW.observation_year=year(NEW.observation_date);
