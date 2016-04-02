INSERT INTO `cashstock` (`cashstock_id`, `particulars`, `remark`, `amount`, `date`, `store_id`,`payment_type`,`transaction_type`) VALUES(1,'Kelechi Emekalam','',3428700.00,'2016-03-10','14','CREDIT','customer payment'),(2,'Oseni Yusuf','',731475.00,'2016-03-10','14','CREDIT','customer payment'),(3,'Kelechi Emekalam','',1044500.00,'2016-03-10','14','CASH','customer payment'),(4,'Kelechi Emekalam','',1044500.00,'2016-03-10','14','CASH','customer payment'),(5,'Oseni Yusuf','',733500.00,'2016-03-10','14','CREDIT','customer payment'),(6,'GENERAL','',250350.00,'2016-03-10','14','CASH','customer payment'),(7,'Kelechi Emekalam','',994800.00,'2016-03-10','14','CREDIT','customer payment'),(8,'Oseni Yusuf','',630375.00,'2016-03-10','14','CREDIT','customer payment'),(9,'Oseni Yusuf','',1171575.00,'2016-03-10','14','CREDIT','customer payment'),(10,'Magdalene Chinda','',633550.00,'2016-03-10','14','CASH','customer payment'),(11,'Magdalene Chinda','',633550.00,'2016-03-10','14','CASH','customer payment'),(12,'Magdalene Chinda','',633550.00,'2016-03-10','14','CASH','customer payment'),(13,'Oseni Yusuf','',645900.00,'2016-03-10','14','CREDIT','customer payment'),(14,'Magdalene Chinda','',1040400.00,'2016-03-10','14','CASH','customer payment'),(15,'Kelechi Emekalam','',8152950.00,'2016-03-10','14','CREDIT','customer payment'),(16,'Kelechi Emekalam','',8152950.00,'2016-03-10','14','CREDIT','customer payment'),(17,'Kelechi Emekalam','',-371550.00,'2016-03-10','14','CREDIT','customer payment'),(18,'Oseni Yusuf','',-2079550.00,'2016-03-10','14','CREDIT','customer payment'),(19,'Nasiru Negedu','',-477050.00,'2016-03-10','14','CREDIT','customer payment'),(20,'Jude Obiakor','',-385500.00,'2016-03-10','14','CREDIT','customer payment'),(21,'Jude Obiakor','',-316200.00,'2016-03-10','14','CREDIT','customer payment'),(22,'Jude Obiakor','',-72600.00,'2016-03-10','14','CREDIT','customer payment'),(23,'Sales Man Jack','',984450.00,'2016-03-10','14','CASH','customer payment'),(24,'Sales Man Jack','',281550.00,'2016-03-10','14','CASH','customer payment'),(25,'Sales Man Jack','',228000.00,'2016-03-10','14','CASH','customer payment'),(26,'Sales Man Jack','',171600.00,'2016-03-10','14','CASH','customer payment'),(27,'Oseni Yusuf','',-356800.00,'2016-03-10','14','CREDIT','customer payment'),(28,'Magdalene Chinda','',-250350.00,'2016-03-10','14','CREDIT','customer payment'),(29,'Magdalene Chinda','',-592200.00,'2016-03-10','14','CREDIT','customer payment'),(30,'Oseni Yusuf','',726100.00,'2016-03-10','14','CASH','customer payment'),(31,'Mr Mike Chandler','',495600.00,'2016-03-10','14','CASH','customer payment'),(32,'GENERAL','												
											',2333.00,'2016-03-10','14','cash','customer payment'),(33,'GENERAL','												
											',2444.00,'2016-03-10','14','pos','customer payment'),(34,'GENERAL','				well done								
											',2333.00,'2016-03-10','14','pos','customer payment'),(35,'GENERAL','remark												
											',1222.00,'2016-03-10','14','pos','customer payment'),(36,'Sales Man Jack','',247500.00,'2016-03-10','14','CASH','customer payment'),(38,'Magdalene Chinda','',-1544350.00,'2016-03-10','14','CREDIT','customer payment'),(39,'Oseni Yusuf','',950400.00,'2016-03-10','14','CASH','customer payment');
DELETE FROM `stock` WHERE `store_id`='14';
DELETE FROM `stock_position` WHERE `store_id`='14';
INSERT INTO `stock` (`stock_id`, `stock_code`, `stock_name`,`store_id`, `stock_count`) VALUES(1,'MLK-001','PEAK SMALL','14',0),(2,'MLK-002','PEAK BIG','14',0),(3,'MLK-003','COWBELL SMALL','14',0),(4,'MLK-004','COWBELL BIG','14',0),(5,'MLK-005','COAST BIG','14',0),(6,'NDL-001','INDOMIE','14',0),(7,'NDL-002','O NOODLES','14',0),(8,'SGR-001','DANGOTE SUGAR','14',0),(9,'SGR-002','STLOUIS','14',0),(10,'BVG-001','MILO SMALL','14',0),(11,'BVG-002','MILO BIG','14',0),(12,'BVG-003','BOURNVITA SMALL','14',0),(13,'BVG-004','BOURNVITA BIG','14',0),(14,'BVG-005','OVALTINE SMALL','14',0),(15,'BVG-006','OVALTINE BIG','14',0),(16,'JUI-001','CHIVITA','14',0),(17,'JUI-002','FUMAN','14',0),(18,'JUI-003','CERES','14',0),(19,'SPG-001','DANGOTE SPAGHETTI','14',0),(20,'SPG-002','GOLDEN PENNY SPAGHETTI','14',0);
INSERT INTO `stock_position` ( `stock_id`, `store_id`, `unit`, `stock_count`) VALUES(1,'14',1,0),(2,'14',1,0),(3,'14',1,0),(4,'14',1,0),(5,'14',1,0),(6,'14',1,0),(7,'14',1,0),(8,'14',1,0),(9,'14',1,0),(10,'14',1,0),(11,'14',1,0),(12,'14',1,0),(13,'14',1,0),(14,'14',1,0),(15,'14',1,0),(16,'14',1,0),(17,'14',1,0),(18,'14',1,0),(19,'14',1,0),(20,'14',1,0);
INSERT INTO `sales_invoice_daily` (`sales_date`, `sales_time`, `purchase_amount`, `store_id`, `payment_type`, `status`, `cashier`, `store_confirmation`, `operator`, `customer`, `invoice_num`) VALUES('2016-03-10','11:15:32',250350.00,'14','CASH','CLOSED','','NOT SUPPLIED','admin','GENERAL',11),('2016-03-10','11:07:04',733500.00,'14','CREDIT','CLOSED','','NOT SUPPLIED','admin','Oseni Yusuf',8),('2016-03-10','11:21:45',1171575.00,'14','CREDIT','CLOSED','','NOT SUPPLIED','admin','Oseni Yusuf',13),('2016-03-10','11:31:43',645900.00,'14','CREDIT','CLOSED','','NOT SUPPLIED','admin','Oseni Yusuf',16),('2016-03-10','11:32:35',1040400.00,'14','CASH','CLOSED','','NOT SUPPLIED','admin','Magdalene Chinda',17),('2016-03-10','04:46:19',250350.00,'14','CREDIT','CLOSED','','NOT SUPPLIED','admin','Magdalene Chinda',27),('2016-03-10','11:18:13',994800.00,'14','CREDIT','CLOSED','','NOT SUPPLIED','admin','Kelechi Emekalam',12),('2016-03-10','11:36:49',8152950.00,'14','CREDIT','CLOSED','','NOT SUPPLIED','admin','Kelechi Emekalam',18),('2016-03-10','04:43:24',371550.00,'14','CREDIT','CLOSED','','NOT SUPPLIED','admin','Kelechi Emekalam',19);
INSERT INTO `invoice_item` ( `trans_date`, `item_quantity`, `stock_id`, `store_id`, `invoice_num`,`item_id`) VALUES('2016-03-10',21,8,'14',25,8),('2016-03-10',23,11,'14',26,8),('2016-03-10',12,13,'14',27,8),('2016-03-10',22,6,'14',28,11),('2016-03-10',21,10,'14',29,11),('2016-03-10',21,4,'14',30,12),('2016-03-10',22,5,'14',31,12),('2016-03-10',21,3,'14',32,13),('2016-03-10',22,10,'14',33,13),('2016-03-10',23,8,'14',34,13),('2016-03-10',22,5,'14',37,13),('2016-03-10',21,7,'14',41,16),('2016-03-10',24,8,'14',42,16),('2016-03-10',21,15,'14',43,16),('2016-03-10',21,4,'14',44,17),('2016-03-10',22,11,'14',45,17),('2016-03-10',21,9,'14',46,17),('2016-03-10',21,5,'14',47,18),('2016-03-10',233,11,'14',48,18),('2016-03-10',231,11,'14',49,18),('2016-03-10',21,15,'14',50,18),('2016-03-10',21,17,'14',51,18),('2016-03-10',21,6,'14',52,19),('2016-03-10',23,6,'14',53,19),('2016-03-10',21,14,'14',54,19),('2016-03-10',22,6,'14',73,27),('2016-03-10',21,10,'14',94,27);
INSERT INTO `stock_ledger` ( `opening_bal`, `task`, `quantity`, `remarks`, `closing_bal`, `date`, `stock_id`, `store_id`, `username`, `time`) VALUES(10,'reset',2333,'No Remark',2333.00,'2016-03-10',4,'14','admin','05:21:44'),(0,'reset',2133333,'Updated',2133333.00,'2016-03-10',2,'14','admin','09:43:51'),(0,'reset',2167890,'Reset Stock',2167890.00,'2016-03-10',9,'14','admin','09:44:40'),(0,'receipt',21339000,'Received Stock',21339000.00,'2016-03-10',10,'14','admin','09:45:07'),(0,'receipt',2111111,'No Remark',2111111.00,'2016-03-10',4,'14','admin','09:45:54'),(0,'reset',23333,'No Remark',23333.00,'2016-03-10',7,'14','admin','05:14:28'),(0,'reset',21111,'No Remark',21111.00,'2016-03-10',8,'14','admin','05:14:49'),(0,'reset',2333,'No Remark',2333.00,'2016-03-10',6,'14','admin','05:22:42'),(0,'reset',24444,'No Remark',24444.00,'2016-03-10',3,'14','admin','05:23:21');
UPDATE `stock` SET `stock`.`stock_count`=233904 WHERE `stock`.`store_id`='14' AND `stock`.`stock_id`='1';
UPDATE `stock` SET `stock`.`stock_count`=2176523 WHERE `stock`.`store_id`='14' AND `stock`.`stock_id`='2';
UPDATE `stock` SET `stock`.`stock_count`=32715 WHERE `stock`.`store_id`='14' AND `stock`.`stock_id`='3';
UPDATE `stock` SET `stock`.`stock_count`=36576559 WHERE `stock`.`store_id`='14' AND `stock`.`stock_id`='4';
UPDATE `stock` SET `stock`.`stock_count`=244879 WHERE `stock`.`store_id`='14' AND `stock`.`stock_id`='5';
UPDATE `stock` SET `stock`.`stock_count`=34370 WHERE `stock`.`store_id`='14' AND `stock`.`stock_id`='6';
UPDATE `stock` SET `stock`.`stock_count`=258104 WHERE `stock`.`store_id`='14' AND `stock`.`stock_id`='7';
UPDATE `stock` SET `stock`.`stock_count`=75525 WHERE `stock`.`store_id`='14' AND `stock`.`stock_id`='8';
UPDATE `stock` SET `stock`.`stock_count`=2175724 WHERE `stock`.`store_id`='14' AND `stock`.`stock_id`='9';
UPDATE `stock` SET `stock`.`stock_count`=21369269 WHERE `stock`.`store_id`='14' AND `stock`.`stock_id`='10';
UPDATE `stock` SET `stock`.`stock_count`=39479 WHERE `stock`.`store_id`='14' AND `stock`.`stock_id`='11';
UPDATE `stock` SET `stock`.`stock_count`=2147 WHERE `stock`.`store_id`='14' AND `stock`.`stock_id`='12';
UPDATE `stock` SET `stock`.`stock_count`=7236 WHERE `stock`.`store_id`='14' AND `stock`.`stock_id`='13';
UPDATE `stock` SET `stock`.`stock_count`=12508 WHERE `stock`.`store_id`='14' AND `stock`.`stock_id`='14';
UPDATE `stock` SET `stock`.`stock_count`=2147702463 WHERE `stock`.`store_id`='14' AND `stock`.`stock_id`='15';
UPDATE `stock` SET `stock`.`stock_count`=22844 WHERE `stock`.`store_id`='14' AND `stock`.`stock_id`='16';
UPDATE `stock` SET `stock`.`stock_count`=12328 WHERE `stock`.`store_id`='14' AND `stock`.`stock_id`='17';
UPDATE `stock` SET `stock`.`stock_count`=243415 WHERE `stock`.`store_id`='14' AND `stock`.`stock_id`='18';
UPDATE `stock` SET `stock`.`stock_count`=89290 WHERE `stock`.`store_id`='14' AND `stock`.`stock_id`='19';
UPDATE `stock` SET `stock`.`stock_count`=66935 WHERE `stock`.`store_id`='14' AND `stock`.`stock_id`='20';
UPDATE `stock_position` SET `stock_position`.`stock_count`=233904 WHERE `stock_position`.`store_id`='14' AND `stock_position`.`stock_id`='1';
UPDATE `stock_position` SET `stock_position`.`stock_count`=2176523 WHERE `stock_position`.`store_id`='14' AND `stock_position`.`stock_id`='2';
UPDATE `stock_position` SET `stock_position`.`stock_count`=32715 WHERE `stock_position`.`store_id`='14' AND `stock_position`.`stock_id`='3';
UPDATE `stock_position` SET `stock_position`.`stock_count`=36576559 WHERE `stock_position`.`store_id`='14' AND `stock_position`.`stock_id`='4';
UPDATE `stock_position` SET `stock_position`.`stock_count`=244879 WHERE `stock_position`.`store_id`='14' AND `stock_position`.`stock_id`='5';
UPDATE `stock_position` SET `stock_position`.`stock_count`=34370 WHERE `stock_position`.`store_id`='14' AND `stock_position`.`stock_id`='6';
UPDATE `stock_position` SET `stock_position`.`stock_count`=258104 WHERE `stock_position`.`store_id`='14' AND `stock_position`.`stock_id`='7';
UPDATE `stock_position` SET `stock_position`.`stock_count`=75525 WHERE `stock_position`.`store_id`='14' AND `stock_position`.`stock_id`='8';
UPDATE `stock_position` SET `stock_position`.`stock_count`=2175724 WHERE `stock_position`.`store_id`='14' AND `stock_position`.`stock_id`='9';
UPDATE `stock_position` SET `stock_position`.`stock_count`=21369269 WHERE `stock_position`.`store_id`='14' AND `stock_position`.`stock_id`='10';
UPDATE `stock_position` SET `stock_position`.`stock_count`=39479 WHERE `stock_position`.`store_id`='14' AND `stock_position`.`stock_id`='11';
UPDATE `stock_position` SET `stock_position`.`stock_count`=2147 WHERE `stock_position`.`store_id`='14' AND `stock_position`.`stock_id`='12';
UPDATE `stock_position` SET `stock_position`.`stock_count`=7236 WHERE `stock_position`.`store_id`='14' AND `stock_position`.`stock_id`='13';
UPDATE `stock_position` SET `stock_position`.`stock_count`=12508 WHERE `stock_position`.`store_id`='14' AND `stock_position`.`stock_id`='14';
UPDATE `stock_position` SET `stock_position`.`stock_count`=2147702463 WHERE `stock_position`.`store_id`='14' AND `stock_position`.`stock_id`='15';
UPDATE `stock_position` SET `stock_position`.`stock_count`=22844 WHERE `stock_position`.`store_id`='14' AND `stock_position`.`stock_id`='16';
UPDATE `stock_position` SET `stock_position`.`stock_count`=12328 WHERE `stock_position`.`store_id`='14' AND `stock_position`.`stock_id`='17';
UPDATE `stock_position` SET `stock_position`.`stock_count`=243415 WHERE `stock_position`.`store_id`='14' AND `stock_position`.`stock_id`='18';
UPDATE `stock_position` SET `stock_position`.`stock_count`=89290 WHERE `stock_position`.`store_id`='14' AND `stock_position`.`stock_id`='19';
UPDATE `stock_position` SET `stock_position`.`stock_count`=66935 WHERE `stock_position`.`store_id`='14' AND `stock_position`.`stock_id`='20';
INSERT INTO `store_daily_summary` ( `store_id`, `opening_balance`, `total_cash_in`, `total_cash_out`, `total_credit_sales`, `closing_balance`, `date`,  `time`) VALUES('14',245666.00,33770491,-6446150.00,0,27570007,'2016-03-10','01:20:39');