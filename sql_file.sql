DELETE FROM `stock` WHERE `store_name`='Dynamix';
INSERT INTO `stock` (`stock_id`, `stock_code`, `stock_name`, `costprice`, `sales_person_price`, `high_purchase`, `low_purchase`, `slab`, `sprice`, `block`, `reorder_level`, `store_name`, `stock_count`) VALUES(9,'mlk-2749','dangote sugar',34.00,56.00,76.00,89.00,10,0.00,0,15,'Dynamix',0),(10,'mlk-202','Peak liquid milk',23.00,35.00,33.00,98.00,12,0.00,0,13,'Dynamix',0),(11,'ons-111','Titus Sardine',23.00,45.00,67.00,54.00,67,0.00,1,11,'Dynamix',0),(12,'ons-50','Broiler egg',32.00,45.00,23.00,45.00,12,0.00,0,12,'Dynamix',0),(13,'ons-50','Laser Oil',12.00,13.00,45.00,67.00,9,0.00,0,2,'Dynamix',0),(14,'ons-023','Nothern fresh onions',32.00,45.00,45.00,65.00,10,0.00,0,9,'Dynamix',0),(15,'mlk-25','Dangote Spagetti',23.00,25.00,56.00,76.00,89,0.00,1,21,'Dynamix',0);
INSERT INTO `stock_position` ( `stock_id`, `store_name`, `unit`, `stock_count`) VALUES(9,'Dynamix',1,0),(10,'Dynamix',1,0),(11,'Dynamix',1,0),(12,'Dynamix',1,0),(13,'Dynamix',1,0),(14,'Dynamix',1,0),(15,'Dynamix',1,0);
INSERT INTO `sales_invoice_daily` (`sales_date`, `sales_time`, `purchase_amount`, `store_name`, `payment_type`, `status`, `cashier`, `store_confirmation`, `operator`, `customer`, `invoice_num`) VALUES('2016-02-10','09:47:39',3344.00,'Dynamix','CASH','CLOSED','','SUPPLIED','charles','ijeoma',556);
UPDATE `stock`
SET `stock`.`stock_count`=2348 WHERE `stock`.`store_name`='Dynamix' AND `stock`.`stock_id`='10';
UPDATE `stock`
SET `stock`.`stock_count`=2370245 WHERE `stock`.`store_name`='Dynamix' AND `stock`.`stock_id`='11';
UPDATE `stock`
SET `stock`.`stock_count`=234567 WHERE `stock`.`store_name`='Dynamix' AND `stock`.`stock_id`='13';
UPDATE `stock`
SET `stock_position`.`stock_count`=2348 WHERE `stock`.`store_name`='Dynamix' AND `stock`.`stock_id`='10';
UPDATE `stock`
SET `stock_position`.`stock_count`=2370245 WHERE `stock`.`store_name`='Dynamix' AND `stock`.`stock_id`='11';
UPDATE `stock`
SET `stock_position`.`stock_count`=234567 WHERE `stock`.`store_name`='Dynamix' AND `stock`.`stock_id`='13';
