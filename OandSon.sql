DELETE FROM `stock` WHERE `store_name`='OandSon';
DELETE FROM `stock_position` WHERE `store_name`='OandSon';
INSERT INTO `stock` (`stock_id`, `stock_code`, `stock_name`,`store_name`, `stock_count`) VALUES(1,'PROV-200','rice','OandSon',0),(9,'SUG-2749','dangote sugar','OandSon',0),(11,'ONS-111','Titus Sardine','OandSon',0),(13,'PROV-50','Laser Oil','OandSon',0),(14,'ONS-023','Nothern fresh onions','OandSon',0),(15,'PROV-25','Dangote Spagetti','OandSon',0);
INSERT INTO `stock_position` ( `stock_id`, `store_name`, `unit`, `stock_count`) VALUES(1,'OandSon',1,0),(9,'OandSon',1,0),(11,'OandSon',1,0),(13,'OandSon',1,0),(14,'OandSon',1,0),(15,'OandSon',1,0);
UPDATE `stock` SET `stock`.`stock_count`=2342236 WHERE `stock`.`store_name`='OandSon' AND `stock`.`stock_id`='1';
UPDATE `stock` SET `stock`.`stock_count`=3435844 WHERE `stock`.`store_name`='OandSon' AND `stock`.`stock_id`='9';
UPDATE `stock` SET `stock`.`stock_count`=55908569 WHERE `stock`.`store_name`='OandSon' AND `stock`.`stock_id`='11';
UPDATE `stock` SET `stock`.`stock_count`=342626 WHERE `stock`.`store_name`='OandSon' AND `stock`.`stock_id`='13';
UPDATE `stock` SET `stock`.`stock_count`=346124 WHERE `stock`.`store_name`='OandSon' AND `stock`.`stock_id`='14';
UPDATE `stock` SET `stock`.`stock_count`=2177736 WHERE `stock`.`store_name`='OandSon' AND `stock`.`stock_id`='15';
UPDATE `stock_position` SET `stock_position`.`stock_count`=2342236 WHERE `stock_position`.`store_name`='OandSon' AND `stock_position`.`stock_id`='1';
UPDATE `stock_position` SET `stock_position`.`stock_count`=3435844 WHERE `stock_position`.`store_name`='OandSon' AND `stock_position`.`stock_id`='9';
UPDATE `stock_position` SET `stock_position`.`stock_count`=55908569 WHERE `stock_position`.`store_name`='OandSon' AND `stock_position`.`stock_id`='11';
UPDATE `stock_position` SET `stock_position`.`stock_count`=342626 WHERE `stock_position`.`store_name`='OandSon' AND `stock_position`.`stock_id`='13';
UPDATE `stock_position` SET `stock_position`.`stock_count`=346124 WHERE `stock_position`.`store_name`='OandSon' AND `stock_position`.`stock_id`='14';
UPDATE `stock_position` SET `stock_position`.`stock_count`=2177736 WHERE `stock_position`.`store_name`='OandSon' AND `stock_position`.`stock_id`='15';
INSERT INTO `store_daily_summary` ( `store_name`, `opening_balance`, `total_cash_in`, `total_cash_out`, `total_credit_sales`, `closing_balance`, `date`,  `time`) VALUES('OandSon',0,0,0,0,0,'2016-03-02','05:51:40');