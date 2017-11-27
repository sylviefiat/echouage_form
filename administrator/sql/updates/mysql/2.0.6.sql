alter table `#__cot_admin` add `observation_datetime` date;
alter table `#__cot_admin` modify `observation_day` int(11) null;
alter table `#__cot_admin` modify `observation_month` int(11) null;
alter table `#__cot_admin` modify `observation_year` int(11) null;

DROP TRIGGER `#__trig_cot_admin_insert`;
CREATE TRIGGER `#__trig_cot_admin_insert` BEFORE INSERT ON `#__cot_admin`
FOR EACH ROW SET NEW.localisation = GeomFromText(CONCAT('POINT(', NEW.observation_longitude, ' ', NEW.observation_latitude, ')' )),NEW.observation_day = day(NEW.observation_datetime),NEW.observation_month=month(NEW.observation_datetime),NEW.observation_year=year(NEW.observation_datetime);

DROP TRIGGER `#__trig_cot_admin_update`;
CREATE TRIGGER `#__trig_cot_admin_update` BEFORE UPDATE ON `#__cot_admin`
FOR EACH ROW SET NEW.localisation = GeomFromText(CONCAT('POINT(', NEW.observation_longitude, ' ', NEW.observation_latitude, ')' )),NEW.observation_day = day(NEW.observation_datetime),NEW.observation_month=month(NEW.observation_datetime),NEW.observation_year=year(NEW.observation_datetime);
