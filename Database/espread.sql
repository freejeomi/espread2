-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 08, 2016 at 05:21 PM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `espread`
--

-- --------------------------------------------------------

--
-- Table structure for table `allocationfile_sales`
--

CREATE TABLE IF NOT EXISTS `allocationfile_sales` (
  `allocation_id` int(11) NOT NULL AUTO_INCREMENT,
  `stock` varchar(100) NOT NULL,
  `customer` varchar(100) NOT NULL,
  `quantity` int(11) NOT NULL,
  PRIMARY KEY (`allocation_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=79 ;

--
-- Dumping data for table `allocationfile_sales`
--

INSERT INTO `allocationfile_sales` (`allocation_id`, `stock`, `customer`, `quantity`) VALUES
(76, 'dangote sugar', 'charles udoh', 306864),
(77, 'dangote sugar', 'bassey', 3101337),
(78, 'dangote sugar', 'bisi', 27668);

-- --------------------------------------------------------

--
-- Table structure for table `allocationfile_turnover`
--

CREATE TABLE IF NOT EXISTS `allocationfile_turnover` (
  `allocation_id` int(11) NOT NULL AUTO_INCREMENT,
  `stock` varchar(100) NOT NULL,
  `customer` varchar(100) NOT NULL,
  `quantity` int(11) NOT NULL,
  PRIMARY KEY (`allocation_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

--
-- Dumping data for table `allocationfile_turnover`
--

INSERT INTO `allocationfile_turnover` (`allocation_id`, `stock`, `customer`, `quantity`) VALUES
(9, 'dangote sugar', 'bassey', 0),
(10, 'Titus Sardine', 'charles udoh', 0),
(11, 'rice', 'charles udoh', 0),
(12, 'Laser Oil', 'charles udoh', 33994),
(13, 'beans', 'charles udoh', 0),
(14, 'dangote sugar', 'charles udoh', 306864),
(15, 'dangote sugar', 'charles udoh', 306864),
(16, 'dangote sugar', 'charles udoh', 306864);

-- --------------------------------------------------------

--
-- Table structure for table `cashier`
--

CREATE TABLE IF NOT EXISTS `cashier` (
  `cashier_id` int(3) NOT NULL AUTO_INCREMENT,
  `cashier_name` varchar(50) NOT NULL,
  PRIMARY KEY (`cashier_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `cashier`
--

INSERT INTO `cashier` (`cashier_id`, `cashier_name`) VALUES
(1, 'charles'),
(2, 'bassey');

-- --------------------------------------------------------

--
-- Table structure for table `cashstock`
--

CREATE TABLE IF NOT EXISTS `cashstock` (
  `cashstock_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `particulars` varchar(100) NOT NULL,
  `amount` double(16,2) NOT NULL DEFAULT '0.00',
  `remark` varchar(255) NOT NULL,
  `ref_code` int(11) DEFAULT NULL,
  `time` time NOT NULL,
  `payment_type` varchar(100) NOT NULL,
  `transaction_type` varchar(100) NOT NULL,
  `user_Id` int(11) NOT NULL,
  PRIMARY KEY (`cashstock_id`),
  KEY `fkexpensestock` (`date`),
  KEY `fktransactionstock` (`particulars`),
  KEY `fk_user_name` (`user_Id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=175 ;

--
-- Dumping data for table `cashstock`
--

INSERT INTO `cashstock` (`cashstock_id`, `date`, `particulars`, `amount`, `remark`, `ref_code`, `time`, `payment_type`, `transaction_type`, `user_Id`) VALUES
(78, '2016-01-26', 'charles udoh', 20000.00, '', 0, '11:31:25', 'cash', 'customer payment', 26),
(79, '2016-01-26', 'dbsiioerlf', 234560.00, 'cgf fhgijofdj', 0, '07:52:20', '', 'supplier payment', 26),
(80, '2016-01-26', 'dbsiioerlf', 234560.00, 'cgf fhgijofdj', NULL, '07:52:20', '', 'supplier payment', 26),
(81, '2016-01-26', 'opening', 0.00, 'fdgjkhkg', 43675, '07:52:20', 'hghtd', 'opening balance', 26),
(82, '2016-01-27', '', 7890.00, '												\n											', 0, '01:29:02', 'payment', 'supplier payment', 26),
(83, '2016-01-27', '4', 6890.00, '												\n											', 0, '01:33:57', 'payment', 'supplier payment', 26),
(84, '2016-01-27', 'fhgjkalsd', 126890.00, 'gfhhjkl', NULL, '07:52:20', '', 'other expenses', 26),
(85, '2016-01-28', 'dddd', -10000.00, 'ghijpk fdi', 0, '13:08:44', '', 'supplier payment', 26),
(86, '2016-01-28', 'Opening Balance', 335460.00, '', 0, '01:01:45', '', 'opening balance', 26),
(87, '2016-01-29', 'hotel', 300293.00, '', 0, '08:11:42', '', 'other expenses', 26),
(88, '2016-01-29', '4', 450000.00, '												\n											', 1234567, '09:40:49', 'payment', 'supplier payment', 26),
(89, '2016-01-29', '4', 569033.00, '												\n											', 46757, '09:49:07', 'payment', 'supplier payment', 26),
(90, '2016-02-04', 'bassey', 1782.00, '', 335, '11:02:42', 'CASH', 'customer payment', 26),
(91, '2016-02-04', 'bassey', 1782.00, '', 336, '00:00:00', 'CASH', 'customer payment', 26),
(92, '2016-02-04', 'bassey', 1672.00, '', 337, '11:32:37', 'CASH', 'customer payment', 26),
(93, '2016-02-05', 'ijeoma', 6374.00, '', 340, '12:46:04', 'CASH', 'customer payment', 26),
(94, '2016-02-09', 'charles udoh', 4101.00, '', 553, '03:38:35', 'CASH', 'customer payment', 26),
(95, '2016-02-10', 'charles udoh', 6863.00, '', 554, '09:32:04', 'CASH', 'customer payment', 26),
(96, '2016-02-10', 'ijeoma', 3344.00, '', 556, '09:51:21', 'CASH', 'customer payment', 26),
(97, '2016-02-10', 'charles udoh', 1848.00, '', 555, '12:16:44', 'CASH', 'customer payment', 26),
(98, '2016-02-10', 'ijeoma', 3344.00, '', 556, '01:35:43', 'CASH', 'customer payment', 26),
(99, '2016-02-10', 'charles udoh', 1848.00, '', 555, '01:36:07', 'CASH', 'customer payment', 26),
(100, '2016-02-11', 'charles udoh', 6863.00, '', 554, '11:15:25', 'CASH', 'customer payment', 26),
(101, '2016-02-12', 'bassey', 2432.00, '', 561, '07:41:57', 'CASH', 'customer payment', 26),
(102, '2016-02-12', 'bassey', 4596.00, '', 565, '01:59:51', 'CASH', 'customer payment', 26),
(103, '2016-02-12', 'charles udoh', 1672.00, '', 570, '05:05:55', 'CREDIT', 'customer payment', 26),
(104, '2016-02-17', 'toyota bus', 10000.00, '', 111, '12:04:30', '', 'Haulage Expense', 26),
(105, '2017-02-16', 'toyota bus', 65780.00, '', 111, '12:10:06', '', 'Haulage expense', 26),
(106, '2017-02-16', 'toyota bus', 12000.00, '', 112, '12:11:56', '', 'Haulage expense', 26),
(107, '2017-02-16', 'toyota bus', 67000.00, '', 112, '12:17:43', '', 'Haulage expense', 26),
(108, '2017-02-16', 'toyota bus', 89000.00, '', 344, '12:20:10', '', 'Haulage expense', 26),
(109, '2017-02-16', 'toyota bus', 1000.00, '', 345, '12:24:33', '', 'Haulage expense', 26),
(110, '2017-02-16', 'benz', 50000.00, '', 123, '12:25:35', '', 'Haulage expense', 26),
(111, '2017-02-16', 'benz', 10000.00, '', 5879, '12:27:09', '', 'Haulage expense', 26),
(112, '2017-02-16', 'toyota bus', 10000.00, '', 1122, '12:28:58', '', 'Haulage expense', 26),
(113, '2017-02-16', 'toyota bus', 20000.00, '', 200, '12:34:26', '', 'Haulage expense', 26),
(114, '2017-02-16', 'toyota bus', 15000.00, '', 189, '12:39:00', '', 'Haulage expense', 26),
(115, '2017-02-16', 'toyota bus', 10000.00, '', 212, '12:40:55', '', 'Haulage expense', 26),
(116, '2017-02-16', 'toyota bus', 10000.00, '', 123, '12:56:53', '', 'Haulage expense', 26),
(117, '2017-02-26', 'toyota bus', 78800.00, '', 124, '12:58:09', '', 'Haulage expense', 26),
(118, '2017-02-16', 'toyota bus', 10000.00, '', 23, '01:01:28', '', 'Haulage expense', 26),
(119, '2017-02-16', 'benz', 23000.00, '', 23, '01:02:11', '', 'Haulage expense', 26),
(120, '2017-02-16', 'benz', 89000.00, '', 122, '01:02:49', '', 'Haulage expense', 26),
(121, '2017-02-16', 'toyota bus', 60000.00, '', 233, '01:04:55', '', 'Haulage expense', 26),
(122, '2017-02-16', 'benz', 1000.00, '', 556, '01:06:50', '', 'Haulage expense', 26),
(123, '2017-02-16', 'toyota bus', 20000.00, '', 432, '01:07:29', '', 'Haulage expense', 26),
(124, '2016-02-19', 'ijeoma', 4454.00, '', 627, '10:24:09', 'CASH', 'customer payment', 26),
(125, '2016-02-19', 'bisi', 4412.00, '', 628, '10:45:56', 'CASH', 'customer payment', 26),
(126, '2022-02-16', 'toyota bus', 213890.00, 'Paid Something', 21, '09:29:50', '', 'Haulage expense', 26),
(127, '2016-02-22', 'bassey', 1523019.00, '', 629, '10:35:27', 'CREDIT', 'customer payment', 26),
(128, '2016-02-22', 'bassey', 1532604.00, '', 629, '10:36:03', 'CREDIT', 'customer payment', 26),
(129, '2016-02-22', 'Opening Balance', 234567.00, '', 0, '10:02:32', '', 'opening balance', 26),
(130, '2016-02-22', 'bisi', 4412.00, '', 628, '10:38:05', 'CASH', 'customer payment', 26),
(131, '2022-02-16', 'toyota bus', 12200.00, '', 44, '10:40:46', '', 'Haulage expense', 26),
(132, '2016-02-24', 'charles udoh', 6666.00, '', 646, '03:29:27', 'CASH', 'customer payment', 26),
(133, '2016-02-25', 'jbsfsiow wfsk', 33082.00, '', 651, '08:23:05', 'CASH', 'customer payment', 26),
(134, '2016-02-26', 'charles udoh', 760.00, '', 652, '02:17:04', 'CASH', 'customer payment', 26),
(135, '2016-02-26', 'Opening Balance', 1000.00, '', 0, '04:02:54', '', 'opening balance', 26),
(136, '2016-03-04', 'jbsfsiow wfsk', 27476.00, '', 651, '11:13:56', 'CASH', 'customer payment', 26),
(137, '2016-03-04', 'bassey', 21728.00, '', 656, '11:44:18', 'CASH', 'customer payment', 26),
(138, '2016-03-04', 'bassey', 4641.00, '', 659, '12:01:09', 'CASH', 'customer payment', 26),
(139, '2016-03-04', 'charles udoh', 2584.00, '', 660, '12:04:17', 'CASH', 'customer payment', 26),
(140, '2016-03-04', 'charles udoh', 2618.00, '', 661, '12:10:19', 'CASH', 'customer payment', 26),
(141, '2016-03-04', 'charles udoh', 2618.00, '', 661, '12:10:26', 'CASH', 'customer payment', 26),
(142, '2016-03-04', 'bassey', 18592.00, '', 662, '12:11:43', 'CASH', 'customer payment', 26),
(143, '2016-03-04', 'charles udoh', 3212.00, '', 663, '02:14:44', 'CASH', 'customer payment', 26),
(144, '2016-03-04', 'charles udoh', 1232.00, '', 664, '02:17:11', 'CASH', 'customer payment', 26),
(145, '2016-03-04', 'charles udoh', 836.00, '', 665, '02:25:40', 'CASH', 'customer payment', 26),
(146, '2016-03-04', 'charles udoh', 836.00, '', 666, '02:48:13', 'CASH', 'customer payment', 26),
(147, '2016-03-04', 'charles udoh', 836.00, '', 666, '02:48:27', 'CASH', 'customer payment', 26),
(148, '2016-03-04', 'charles udoh', 6104.00, '', 667, '02:50:56', 'CASH', 'customer payment', 26),
(149, '2016-03-04', 'charles udoh', 5016.00, '', 668, '02:51:47', 'CASH', 'customer payment', 26),
(150, '2016-03-04', 'bassey', 453389.00, '', 669, '02:57:10', 'CASH', 'customer payment', 26),
(151, '2016-03-04', 'bassey', 3024.00, '', 672, '02:59:08', 'CASH', 'customer payment', 26),
(152, '2016-03-04', 'bassey', 2584.00, '', 674, '03:00:38', 'CASH', 'customer payment', 26),
(153, '2016-03-04', 'bassey', 1836.00, '', 676, '03:01:47', 'CASH', 'customer payment', 26),
(154, '2016-03-04', 'charles udoh', 836.00, '', 677, '03:14:35', 'CASH', 'customer payment', 26),
(155, '2016-03-04', 'bassey', 594.00, '', 678, '03:15:14', 'CASH', 'customer payment', 26),
(156, '2016-03-07', 'bassey', 2068.00, '', 687, '02:57:45', 'CASH', 'customer payment', 26),
(157, '2016-03-08', 'charles udoh', 1407.00, '', 690, '12:42:17', 'CASH', 'customer payment', 26),
(158, '2016-03-08', 'charles udoh', 3090.00, '', 695, '01:13:22', 'CASH', 'customer payment', 26),
(159, '2016-03-08', 'bassey', 9348.00, '', 696, '01:16:44', 'CASH', 'customer payment', 26),
(160, '2016-03-08', 'charles udoh', 836.00, '', 698, '01:38:35', 'CASH', 'customer payment', 26),
(161, '2016-03-08', 'bassey', 2475.00, '', 699, '01:45:51', 'CASH', 'customer payment', 26),
(162, '2016-03-08', 'bisi', 2508.00, '', 700, '01:48:21', 'CASH', 'customer payment', 26),
(163, '2016-03-08', 'charles udoh', 1672.00, '', 701, '01:50:36', 'CASH', 'customer payment', 26),
(164, '2016-03-08', 'bassey', 836.00, '', 702, '01:51:57', 'CASH', 'customer payment', 26),
(165, '2016-03-08', 'charles udoh', 836.00, '', 703, '01:52:58', 'CASH', 'customer payment', 26),
(166, '2016-03-08', 'charles udoh', 836.00, '', 705, '02:36:49', 'CASH', 'customer payment', 26),
(167, '2016-03-08', 'charles udoh', 2376.00, '', 706, '02:40:25', 'CASH', 'customer payment', 26),
(168, '2016-03-08', 'charles udoh', 836.00, '', 707, '03:02:31', 'CASH', 'customer payment', 26),
(169, '2016-03-08', 'bassey', 3080.00, '', 708, '03:17:05', 'CASH', 'customer payment', 26),
(170, '2016-03-08', 'charles udoh', 2024.00, '', 704, '03:37:58', 'CASH', 'customer payment', 26),
(171, '2016-03-08', 'charles udoh', 2208.00, '', 707, '04:03:31', 'CASH', 'customer payment', 26),
(172, '2016-03-08', 'bassey', 1188.00, '', 709, '04:11:04', 'CASH', 'customer payment', 26),
(173, '2016-03-08', 'bassey', 1782.00, '', 709, '04:13:25', 'CASH', 'customer payment', 26),
(174, '2016-03-08', 'bassey', 3454.00, '', 709, '04:15:57', 'CASH', 'customer payment', 26);

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `category_id` int(2) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(100) NOT NULL,
  `cat_code` varchar(100) NOT NULL,
  PRIMARY KEY (`category_id`),
  UNIQUE KEY `category_id` (`category_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`category_id`, `category_name`, `cat_code`) VALUES
(1, 'Milk', 'MLK'),
(2, 'Sugar', 'SUG'),
(3, 'Onions', 'ONS'),
(4, 'provisions', 'PROV'),
(5, 'Oil', 'OIL');

-- --------------------------------------------------------

--
-- Table structure for table `country`
--

CREATE TABLE IF NOT EXISTS `country` (
  `iso` char(2) NOT NULL,
  `name` varchar(80) NOT NULL,
  `printable_name` varchar(80) NOT NULL,
  `iso3` char(3) DEFAULT NULL,
  `numcode` smallint(6) DEFAULT NULL,
  PRIMARY KEY (`iso`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `country`
--

INSERT INTO `country` (`iso`, `name`, `printable_name`, `iso3`, `numcode`) VALUES
('AD', 'ANDORRA', 'Andorra', 'AND', 20),
('AE', 'UNITED ARAB EMIRATES', 'United Arab Emirates', 'ARE', 784),
('AF', 'AFGHANISTAN', 'Afghanistan', 'AFG', 4),
('AG', 'ANTIGUA AND BARBUDA', 'Antigua and Barbuda', 'ATG', 28),
('AI', 'ANGUILLA', 'Anguilla', 'AIA', 660),
('AL', 'ALBANIA', 'Albania', 'ALB', 8),
('AM', 'ARMENIA', 'Armenia', 'ARM', 51),
('AN', 'NETHERLANDS ANTILLES', 'Netherlands Antilles', 'ANT', 530),
('AO', 'ANGOLA', 'Angola', 'AGO', 24),
('AQ', 'ANTARCTICA', 'Antarctica', NULL, NULL),
('AR', 'ARGENTINA', 'Argentina', 'ARG', 32),
('AS', 'AMERICAN SAMOA', 'American Samoa', 'ASM', 16),
('AT', 'AUSTRIA', 'Austria', 'AUT', 40),
('AU', 'AUSTRALIA', 'Australia', 'AUS', 36),
('AW', 'ARUBA', 'Aruba', 'ABW', 533),
('AZ', 'AZERBAIJAN', 'Azerbaijan', 'AZE', 31),
('BA', 'BOSNIA AND HERZEGOVINA', 'Bosnia and Herzegovina', 'BIH', 70),
('BB', 'BARBADOS', 'Barbados', 'BRB', 52),
('BD', 'BANGLADESH', 'Bangladesh', 'BGD', 50),
('BE', 'BELGIUM', 'Belgium', 'BEL', 56),
('BF', 'BURKINA FASO', 'Burkina Faso', 'BFA', 854),
('BG', 'BULGARIA', 'Bulgaria', 'BGR', 100),
('BH', 'BAHRAIN', 'Bahrain', 'BHR', 48),
('BI', 'BURUNDI', 'Burundi', 'BDI', 108),
('BJ', 'BENIN', 'Benin', 'BEN', 204),
('BM', 'BERMUDA', 'Bermuda', 'BMU', 60),
('BN', 'BRUNEI DARUSSALAM', 'Brunei Darussalam', 'BRN', 96),
('BO', 'BOLIVIA', 'Bolivia', 'BOL', 68),
('BR', 'BRAZIL', 'Brazil', 'BRA', 76),
('BS', 'BAHAMAS', 'Bahamas', 'BHS', 44),
('BT', 'BHUTAN', 'Bhutan', 'BTN', 64),
('BV', 'BOUVET ISLAND', 'Bouvet Island', NULL, NULL),
('BW', 'BOTSWANA', 'Botswana', 'BWA', 72),
('BY', 'BELARUS', 'Belarus', 'BLR', 112),
('BZ', 'BELIZE', 'Belize', 'BLZ', 84),
('CA', 'CANADA', 'Canada', 'CAN', 124),
('CC', 'COCOS (KEELING) ISLANDS', 'Cocos (Keeling) Islands', NULL, NULL),
('CD', 'CONGO, THE DEMOCRATIC REPUBLIC OF THE', 'Congo, the Democratic Republic of the', 'COD', 180),
('CF', 'CENTRAL AFRICAN REPUBLIC', 'Central African Republic', 'CAF', 140),
('CG', 'CONGO', 'Congo', 'COG', 178),
('CH', 'SWITZERLAND', 'Switzerland', 'CHE', 756),
('CI', 'COTE D''IVOIRE', 'Cote D''Ivoire', 'CIV', 384),
('CK', 'COOK ISLANDS', 'Cook Islands', 'COK', 184),
('CL', 'CHILE', 'Chile', 'CHL', 152),
('CM', 'CAMEROON', 'Cameroon', 'CMR', 120),
('CN', 'CHINA', 'China', 'CHN', 156),
('CO', 'COLOMBIA', 'Colombia', 'COL', 170),
('CR', 'COSTA RICA', 'Costa Rica', 'CRI', 188),
('CS', 'SERBIA AND MONTENEGRO', 'Serbia and Montenegro', NULL, NULL),
('CU', 'CUBA', 'Cuba', 'CUB', 192),
('CV', 'CAPE VERDE', 'Cape Verde', 'CPV', 132),
('CX', 'CHRISTMAS ISLAND', 'Christmas Island', NULL, NULL),
('CY', 'CYPRUS', 'Cyprus', 'CYP', 196),
('CZ', 'CZECH REPUBLIC', 'Czech Republic', 'CZE', 203),
('DE', 'GERMANY', 'Germany', 'DEU', 276),
('DJ', 'DJIBOUTI', 'Djibouti', 'DJI', 262),
('DK', 'DENMARK', 'Denmark', 'DNK', 208),
('DM', 'DOMINICA', 'Dominica', 'DMA', 212),
('DO', 'DOMINICAN REPUBLIC', 'Dominican Republic', 'DOM', 214),
('DZ', 'ALGERIA', 'Algeria', 'DZA', 12),
('EC', 'ECUADOR', 'Ecuador', 'ECU', 218),
('EE', 'ESTONIA', 'Estonia', 'EST', 233),
('EG', 'EGYPT', 'Egypt', 'EGY', 818),
('EH', 'WESTERN SAHARA', 'Western Sahara', 'ESH', 732),
('ER', 'ERITREA', 'Eritrea', 'ERI', 232),
('ES', 'SPAIN', 'Spain', 'ESP', 724),
('ET', 'ETHIOPIA', 'Ethiopia', 'ETH', 231),
('FI', 'FINLAND', 'Finland', 'FIN', 246),
('FJ', 'FIJI', 'Fiji', 'FJI', 242),
('FK', 'FALKLAND ISLANDS (MALVINAS)', 'Falkland Islands (Malvinas)', 'FLK', 238),
('FM', 'MICRONESIA, FEDERATED STATES OF', 'Micronesia, Federated States of', 'FSM', 583),
('FO', 'FAROE ISLANDS', 'Faroe Islands', 'FRO', 234),
('FR', 'FRANCE', 'France', 'FRA', 250),
('GA', 'GABON', 'Gabon', 'GAB', 266),
('GB', 'UNITED KINGDOM', 'United Kingdom', 'GBR', 826),
('GD', 'GRENADA', 'Grenada', 'GRD', 308),
('GE', 'GEORGIA', 'Georgia', 'GEO', 268),
('GF', 'FRENCH GUIANA', 'French Guiana', 'GUF', 254),
('GH', 'GHANA', 'Ghana', 'GHA', 288),
('GI', 'GIBRALTAR', 'Gibraltar', 'GIB', 292),
('GL', 'GREENLAND', 'Greenland', 'GRL', 304),
('GM', 'GAMBIA', 'Gambia', 'GMB', 270),
('GN', 'GUINEA', 'Guinea', 'GIN', 324),
('GP', 'GUADELOUPE', 'Guadeloupe', 'GLP', 312),
('GQ', 'EQUATORIAL GUINEA', 'Equatorial Guinea', 'GNQ', 226),
('GR', 'GREECE', 'Greece', 'GRC', 300),
('GS', 'SOUTH GEORGIA AND THE SOUTH SANDWICH ISLANDS', 'South Georgia and the South Sandwich Islands', NULL, NULL),
('GT', 'GUATEMALA', 'Guatemala', 'GTM', 320),
('GU', 'GUAM', 'Guam', 'GUM', 316),
('GW', 'GUINEA-BISSAU', 'Guinea-Bissau', 'GNB', 624),
('GY', 'GUYANA', 'Guyana', 'GUY', 328),
('HK', 'HONG KONG', 'Hong Kong', 'HKG', 344),
('HM', 'HEARD ISLAND AND MCDONALD ISLANDS', 'Heard Island and Mcdonald Islands', NULL, NULL),
('HN', 'HONDURAS', 'Honduras', 'HND', 340),
('HR', 'CROATIA', 'Croatia', 'HRV', 191),
('HT', 'HAITI', 'Haiti', 'HTI', 332),
('HU', 'HUNGARY', 'Hungary', 'HUN', 348),
('ID', 'INDONESIA', 'Indonesia', 'IDN', 360),
('IE', 'IRELAND', 'Ireland', 'IRL', 372),
('IL', 'ISRAEL', 'Israel', 'ISR', 376),
('IN', 'INDIA', 'India', 'IND', 356),
('IO', 'BRITISH INDIAN OCEAN TERRITORY', 'British Indian Ocean Territory', NULL, NULL),
('IQ', 'IRAQ', 'Iraq', 'IRQ', 368),
('IR', 'IRAN, ISLAMIC REPUBLIC OF', 'Iran, Islamic Republic of', 'IRN', 364),
('IS', 'ICELAND', 'Iceland', 'ISL', 352),
('IT', 'ITALY', 'Italy', 'ITA', 380),
('JM', 'JAMAICA', 'Jamaica', 'JAM', 388),
('JO', 'JORDAN', 'Jordan', 'JOR', 400),
('JP', 'JAPAN', 'Japan', 'JPN', 392),
('KE', 'KENYA', 'Kenya', 'KEN', 404),
('KG', 'KYRGYZSTAN', 'Kyrgyzstan', 'KGZ', 417),
('KH', 'CAMBODIA', 'Cambodia', 'KHM', 116),
('KI', 'KIRIBATI', 'Kiribati', 'KIR', 296),
('KM', 'COMOROS', 'Comoros', 'COM', 174),
('KN', 'SAINT KITTS AND NEVIS', 'Saint Kitts and Nevis', 'KNA', 659),
('KP', 'KOREA, DEMOCRATIC PEOPLE''S REPUBLIC OF', 'Korea, Democratic People''s Republic of', 'PRK', 408),
('KR', 'KOREA, REPUBLIC OF', 'Korea, Republic of', 'KOR', 410),
('KW', 'KUWAIT', 'Kuwait', 'KWT', 414),
('KY', 'CAYMAN ISLANDS', 'Cayman Islands', 'CYM', 136),
('KZ', 'KAZAKHSTAN', 'Kazakhstan', 'KAZ', 398),
('LA', 'LAO PEOPLE''S DEMOCRATIC REPUBLIC', 'Lao People''s Democratic Republic', 'LAO', 418),
('LB', 'LEBANON', 'Lebanon', 'LBN', 422),
('LC', 'SAINT LUCIA', 'Saint Lucia', 'LCA', 662),
('LI', 'LIECHTENSTEIN', 'Liechtenstein', 'LIE', 438),
('LK', 'SRI LANKA', 'Sri Lanka', 'LKA', 144),
('LR', 'LIBERIA', 'Liberia', 'LBR', 430),
('LS', 'LESOTHO', 'Lesotho', 'LSO', 426),
('LT', 'LITHUANIA', 'Lithuania', 'LTU', 440),
('LU', 'LUXEMBOURG', 'Luxembourg', 'LUX', 442),
('LV', 'LATVIA', 'Latvia', 'LVA', 428),
('LY', 'LIBYAN ARAB JAMAHIRIYA', 'Libyan Arab Jamahiriya', 'LBY', 434),
('MA', 'MOROCCO', 'Morocco', 'MAR', 504),
('MC', 'MONACO', 'Monaco', 'MCO', 492),
('MD', 'MOLDOVA, REPUBLIC OF', 'Moldova, Republic of', 'MDA', 498),
('MG', 'MADAGASCAR', 'Madagascar', 'MDG', 450),
('MH', 'MARSHALL ISLANDS', 'Marshall Islands', 'MHL', 584),
('MK', 'MACEDONIA, THE FORMER YUGOSLAV REPUBLIC OF', 'Macedonia, the Former Yugoslav Republic of', 'MKD', 807),
('ML', 'MALI', 'Mali', 'MLI', 466),
('MM', 'MYANMAR', 'Myanmar', 'MMR', 104),
('MN', 'MONGOLIA', 'Mongolia', 'MNG', 496),
('MO', 'MACAO', 'Macao', 'MAC', 446),
('MP', 'NORTHERN MARIANA ISLANDS', 'Northern Mariana Islands', 'MNP', 580),
('MQ', 'MARTINIQUE', 'Martinique', 'MTQ', 474),
('MR', 'MAURITANIA', 'Mauritania', 'MRT', 478),
('MS', 'MONTSERRAT', 'Montserrat', 'MSR', 500),
('MT', 'MALTA', 'Malta', 'MLT', 470),
('MU', 'MAURITIUS', 'Mauritius', 'MUS', 480),
('MV', 'MALDIVES', 'Maldives', 'MDV', 462),
('MW', 'MALAWI', 'Malawi', 'MWI', 454),
('MX', 'MEXICO', 'Mexico', 'MEX', 484),
('MY', 'MALAYSIA', 'Malaysia', 'MYS', 458),
('MZ', 'MOZAMBIQUE', 'Mozambique', 'MOZ', 508),
('NA', 'NAMIBIA', 'Namibia', 'NAM', 516),
('NC', 'NEW CALEDONIA', 'New Caledonia', 'NCL', 540),
('NE', 'NIGER', 'Niger', 'NER', 562),
('NF', 'NORFOLK ISLAND', 'Norfolk Island', 'NFK', 574),
('NG', 'NIGERIA', 'Nigeria', 'NGA', 566),
('NI', 'NICARAGUA', 'Nicaragua', 'NIC', 558),
('NL', 'NETHERLANDS', 'Netherlands', 'NLD', 528),
('NO', 'NORWAY', 'Norway', 'NOR', 578),
('NP', 'NEPAL', 'Nepal', 'NPL', 524),
('NR', 'NAURU', 'Nauru', 'NRU', 520),
('NU', 'NIUE', 'Niue', 'NIU', 570),
('NZ', 'NEW ZEALAND', 'New Zealand', 'NZL', 554),
('OM', 'OMAN', 'Oman', 'OMN', 512),
('PA', 'PANAMA', 'Panama', 'PAN', 591),
('PE', 'PERU', 'Peru', 'PER', 604),
('PF', 'FRENCH POLYNESIA', 'French Polynesia', 'PYF', 258),
('PG', 'PAPUA NEW GUINEA', 'Papua New Guinea', 'PNG', 598),
('PH', 'PHILIPPINES', 'Philippines', 'PHL', 608),
('PK', 'PAKISTAN', 'Pakistan', 'PAK', 586),
('PL', 'POLAND', 'Poland', 'POL', 616),
('PM', 'SAINT PIERRE AND MIQUELON', 'Saint Pierre and Miquelon', 'SPM', 666),
('PN', 'PITCAIRN', 'Pitcairn', 'PCN', 612),
('PR', 'PUERTO RICO', 'Puerto Rico', 'PRI', 630),
('PS', 'PALESTINIAN TERRITORY, OCCUPIED', 'Palestinian Territory, Occupied', NULL, NULL),
('PT', 'PORTUGAL', 'Portugal', 'PRT', 620),
('PW', 'PALAU', 'Palau', 'PLW', 585),
('PY', 'PARAGUAY', 'Paraguay', 'PRY', 600),
('QA', 'QATAR', 'Qatar', 'QAT', 634),
('RE', 'REUNION', 'Reunion', 'REU', 638),
('RO', 'ROMANIA', 'Romania', 'ROM', 642),
('RU', 'RUSSIAN FEDERATION', 'Russian Federation', 'RUS', 643),
('RW', 'RWANDA', 'Rwanda', 'RWA', 646),
('SA', 'SAUDI ARABIA', 'Saudi Arabia', 'SAU', 682),
('SB', 'SOLOMON ISLANDS', 'Solomon Islands', 'SLB', 90),
('SC', 'SEYCHELLES', 'Seychelles', 'SYC', 690),
('SD', 'SUDAN', 'Sudan', 'SDN', 736),
('SE', 'SWEDEN', 'Sweden', 'SWE', 752),
('SG', 'SINGAPORE', 'Singapore', 'SGP', 702),
('SH', 'SAINT HELENA', 'Saint Helena', 'SHN', 654),
('SI', 'SLOVENIA', 'Slovenia', 'SVN', 705),
('SJ', 'SVALBARD AND JAN MAYEN', 'Svalbard and Jan Mayen', 'SJM', 744),
('SK', 'SLOVAKIA', 'Slovakia', 'SVK', 703),
('SL', 'SIERRA LEONE', 'Sierra Leone', 'SLE', 694),
('SM', 'SAN MARINO', 'San Marino', 'SMR', 674),
('SN', 'SENEGAL', 'Senegal', 'SEN', 686),
('SO', 'SOMALIA', 'Somalia', 'SOM', 706),
('SR', 'SURINAME', 'Suriname', 'SUR', 740),
('ST', 'SAO TOME AND PRINCIPE', 'Sao Tome and Principe', 'STP', 678),
('SV', 'EL SALVADOR', 'El Salvador', 'SLV', 222),
('SY', 'SYRIAN ARAB REPUBLIC', 'Syrian Arab Republic', 'SYR', 760),
('SZ', 'SWAZILAND', 'Swaziland', 'SWZ', 748),
('TC', 'TURKS AND CAICOS ISLANDS', 'Turks and Caicos Islands', 'TCA', 796),
('TD', 'CHAD', 'Chad', 'TCD', 148),
('TF', 'FRENCH SOUTHERN TERRITORIES', 'French Southern Territories', NULL, NULL),
('TG', 'TOGO', 'Togo', 'TGO', 768),
('TH', 'THAILAND', 'Thailand', 'THA', 764),
('TJ', 'TAJIKISTAN', 'Tajikistan', 'TJK', 762),
('TK', 'TOKELAU', 'Tokelau', 'TKL', 772),
('TL', 'TIMOR-LESTE', 'Timor-Leste', NULL, NULL),
('TM', 'TURKMENISTAN', 'Turkmenistan', 'TKM', 795),
('TN', 'TUNISIA', 'Tunisia', 'TUN', 788),
('TO', 'TONGA', 'Tonga', 'TON', 776),
('TR', 'TURKEY', 'Turkey', 'TUR', 792),
('TT', 'TRINIDAD AND TOBAGO', 'Trinidad and Tobago', 'TTO', 780),
('TV', 'TUVALU', 'Tuvalu', 'TUV', 798),
('TW', 'TAIWAN, PROVINCE OF CHINA', 'Taiwan, Province of China', 'TWN', 158),
('TZ', 'TANZANIA, UNITED REPUBLIC OF', 'Tanzania, United Republic of', 'TZA', 834),
('UA', 'UKRAINE', 'Ukraine', 'UKR', 804),
('UG', 'UGANDA', 'Uganda', 'UGA', 800),
('UM', 'UNITED STATES MINOR OUTLYING ISLANDS', 'United States Minor Outlying Islands', NULL, NULL),
('US', 'UNITED STATES', 'United States', 'USA', 840),
('UY', 'URUGUAY', 'Uruguay', 'URY', 858),
('UZ', 'UZBEKISTAN', 'Uzbekistan', 'UZB', 860),
('VA', 'HOLY SEE (VATICAN CITY STATE)', 'Holy See (Vatican City State)', 'VAT', 336),
('VC', 'SAINT VINCENT AND THE GRENADINES', 'Saint Vincent and the Grenadines', 'VCT', 670),
('VE', 'VENEZUELA', 'Venezuela', 'VEN', 862),
('VG', 'VIRGIN ISLANDS, BRITISH', 'Virgin Islands, British', 'VGB', 92),
('VI', 'VIRGIN ISLANDS, U.S.', 'Virgin Islands, U.s.', 'VIR', 850),
('VN', 'VIET NAM', 'Viet Nam', 'VNM', 704),
('VU', 'VANUATU', 'Vanuatu', 'VUT', 548),
('WF', 'WALLIS AND FUTUNA', 'Wallis and Futuna', 'WLF', 876),
('WS', 'SAMOA', 'Samoa', 'WSM', 882),
('YE', 'YEMEN', 'Yemen', 'YEM', 887),
('YT', 'MAYOTTE', 'Mayotte', NULL, NULL),
('ZA', 'SOUTH AFRICA', 'South Africa', 'ZAF', 710),
('ZM', 'ZAMBIA', 'Zambia', 'ZMB', 894),
('ZW', 'ZIMBABWE', 'Zimbabwe', 'ZWE', 716);

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE IF NOT EXISTS `customer` (
  `customer_id` int(5) NOT NULL AUTO_INCREMENT,
  `customer_name` varchar(100) NOT NULL,
  `customer_type` varchar(50) NOT NULL DEFAULT 'NORMAL',
  `phone` varchar(16) NOT NULL,
  `email` varchar(50) NOT NULL,
  PRIMARY KEY (`customer_id`),
  UNIQUE KEY `customer_id` (`customer_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`customer_id`, `customer_name`, `customer_type`, `phone`, `email`) VALUES
(4, 'charles udoh', 'NORMAL', '11223344556', '123@xyz.com'),
(5, 'bassey', 'NORMAL', '123456789', 'qqq@abc.com'),
(6, 'ijeoma', 'NORMAL', '1234567899', 'kdsn@fl.com'),
(7, 'bisi', 'NORMAL', '908765789', 'nbhgv@gmail.com'),
(8, 'jbsfsiow wfsk', 'NORMAL', '4356789065', 'hgvhg@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `customertype`
--

CREATE TABLE IF NOT EXISTS `customertype` (
  `customertype_id` int(11) NOT NULL AUTO_INCREMENT,
  `customertype_name` varchar(50) NOT NULL,
  PRIMARY KEY (`customertype_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `customer_transaction`
--

CREATE TABLE IF NOT EXISTS `customer_transaction` (
  `transaction_id` int(11) NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `payment_type` varchar(50) NOT NULL,
  `invoice_num` int(11) DEFAULT NULL,
  `amount` double(16,2) NOT NULL DEFAULT '0.00',
  `remark` varchar(255) DEFAULT NULL,
  `transaction_type` varchar(100) NOT NULL,
  `user_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  PRIMARY KEY (`transaction_id`),
  KEY `fkcusId` (`customer_id`),
  KEY `fkusername` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=195 ;

--
-- Dumping data for table `customer_transaction`
--

INSERT INTO `customer_transaction` (`transaction_id`, `date`, `time`, `payment_type`, `invoice_num`, `amount`, `remark`, `transaction_type`, `user_id`, `customer_id`) VALUES
(119, '2016-01-25', '04:51:02', 'cash', 0, 20000.00, '', '', 26, 4),
(120, '2016-01-25', '04:51:02', 'cash', 0, 20000.00, '', '', 26, 4),
(121, '2016-01-25', '04:55:18', 'pos', 0, 12000.00, '', '', 26, 4),
(122, '2016-01-25', '04:57:35', 'online', 0, -328000.00, '', '', 26, 4),
(123, '2016-01-25', '04:57:35', 'online', 0, -328000.00, '', '', 26, 4),
(124, '2016-01-25', '04:58:52', 'cash', 0, 56000.00, 'dfd hkjcvg', '', 26, 4),
(125, '2016-01-25', '05:00:51', 'cash', 0, 56000.00, 'dfd hkjcvg', '', 26, 4),
(126, '2016-01-25', '05:01:14', 'cash', 0, 89000.00, 'gcfy giiu', '', 26, 4),
(127, '2016-01-25', '05:09:12', 'pos', 0, 300000.00, '', '', 26, 4),
(128, '2016-01-25', '05:11:48', 'pos', 0, -5000000.00, '', '', 26, 4),
(129, '2016-01-25', '05:47:30', 'cash', 0, 20000.00, '', '', 26, 4),
(130, '2016-01-25', '10:00:00', 'Cash', NULL, -30000.00, NULL, '', 26, 4),
(131, '2016-01-25', '07:53:05', 'Cash', NULL, -80000.00, NULL, '', 26, 4),
(132, '2016-01-25', '02:23:23', 'POS', NULL, -200000.00, NULL, '', 26, 5),
(133, '2016-01-26', '11:31:25', 'cash', 0, 20000.00, '', 'customer payment', 26, 4),
(134, '2016-02-04', '11:02:42', 'CASH', 335, 1782.00, '', 'customer payment', 26, 5),
(135, '2016-02-04', '00:00:00', 'CASH', 336, 1782.00, '', 'customer payment', 26, 5),
(136, '2016-02-04', '11:32:37', 'CASH', 337, 1672.00, '', 'customer payment', 26, 5),
(137, '2016-02-05', '12:46:04', 'CASH', 340, -6374.00, '', 'customer payment', 26, 6),
(138, '2016-02-09', '03:38:35', 'CASH', 553, 4101.00, '', 'customer payment', 26, 4),
(139, '2016-02-10', '09:32:04', 'CASH', 554, 6863.00, '', 'customer payment', 26, 4),
(140, '2016-02-10', '09:51:21', 'CASH', 556, -3344.00, '', 'customer payment', 26, 6),
(141, '2016-02-10', '12:16:44', 'CASH', 555, 1848.00, '', 'customer payment', 26, 4),
(142, '2016-02-10', '01:35:43', 'CASH', 556, -3344.00, '', 'customer payment', 26, 6),
(143, '2016-02-10', '01:36:07', 'CASH', 555, 1848.00, '', 'customer payment', 26, 4),
(144, '2016-02-11', '11:15:25', 'CASH', 554, 6863.00, '', 'customer payment', 26, 4),
(145, '2016-02-12', '07:41:57', 'CASH', 561, 2432.00, '', 'customer payment', 26, 5),
(146, '2016-02-12', '01:59:51', 'CASH', 565, 4596.00, '', 'customer payment', 26, 5),
(147, '2016-02-12', '05:05:55', 'CREDIT', 570, 1672.00, '', 'customer payment', 26, 4),
(148, '2016-02-19', '10:24:09', 'CASH', 627, -4454.00, '', 'customer payment', 26, 6),
(149, '2016-02-19', '10:45:56', 'CASH', 628, 4412.00, '', 'customer payment', 26, 7),
(150, '2016-02-22', '10:35:27', 'CREDIT', 629, 1523019.00, '', 'customer payment', 26, 5),
(151, '2016-02-22', '10:36:03', 'CREDIT', 629, 1532604.00, '', 'customer payment', 26, 5),
(152, '2016-02-22', '10:38:05', 'CASH', 628, 4412.00, '', 'customer payment', 26, 7),
(153, '2016-02-24', '03:29:27', 'CASH', 646, 6666.00, '', 'customer payment', 26, 4),
(154, '2016-02-25', '08:23:05', 'CASH', 651, 33082.00, '', 'customer payment', 26, 8),
(155, '2016-02-26', '02:17:04', 'CASH', 652, 760.00, '', 'customer payment', 26, 4),
(156, '2016-03-04', '11:13:56', 'CASH', 651, 27476.00, '', 'customer payment', 26, 8),
(157, '2016-03-04', '11:44:18', 'CASH', 656, 21728.00, '', 'customer payment', 26, 5),
(158, '2016-03-04', '12:01:09', 'CASH', 659, 4641.00, '', 'customer payment', 26, 5),
(159, '2016-03-04', '12:04:17', 'CASH', 660, 2584.00, '', 'customer payment', 26, 4),
(160, '2016-03-04', '12:10:19', 'CASH', 661, 2618.00, '', 'customer payment', 26, 4),
(161, '2016-03-04', '12:10:26', 'CASH', 661, 2618.00, '', 'customer payment', 26, 4),
(162, '2016-03-04', '12:11:43', 'CASH', 662, 18592.00, '', 'customer payment', 26, 5),
(163, '2016-03-04', '02:14:44', 'CASH', 663, 3212.00, '', 'customer payment', 26, 4),
(164, '2016-03-04', '02:17:11', 'CASH', 664, 1232.00, '', 'customer payment', 26, 4),
(165, '2016-03-04', '02:25:40', 'CASH', 665, 836.00, '', 'customer payment', 26, 4),
(166, '2016-03-04', '02:48:13', 'CASH', 666, 836.00, '', 'customer payment', 26, 4),
(167, '2016-03-04', '02:48:27', 'CASH', 666, 836.00, '', 'customer payment', 26, 4),
(168, '2016-03-04', '02:50:56', 'CASH', 667, 6104.00, '', 'customer payment', 26, 4),
(169, '2016-03-04', '02:51:47', 'CASH', 668, 5016.00, '', 'customer payment', 26, 4),
(170, '2016-03-04', '02:57:10', 'CASH', 669, 453389.00, '', 'customer payment', 26, 5),
(171, '2016-03-04', '02:59:08', 'CASH', 672, 3024.00, '', 'customer payment', 26, 5),
(172, '2016-03-04', '03:00:38', 'CASH', 674, 2584.00, '', 'customer payment', 26, 5),
(173, '2016-03-04', '03:01:47', 'CASH', 676, 1836.00, '', 'customer payment', 26, 5),
(174, '2016-03-04', '03:14:35', 'CASH', 677, 836.00, '', 'customer payment', 26, 4),
(175, '2016-03-04', '03:15:14', 'CASH', 678, 594.00, '', 'customer payment', 26, 5),
(176, '2016-03-07', '02:57:45', 'CASH', 687, 2068.00, '', 'customer payment', 26, 5),
(177, '2016-03-08', '12:42:17', 'CASH', 690, 1407.00, '', 'customer payment', 26, 4),
(178, '2016-03-08', '01:13:22', 'CASH', 695, 3090.00, '', 'customer payment', 26, 4),
(179, '2016-03-08', '01:16:44', 'CASH', 696, 9348.00, '', 'customer payment', 26, 5),
(180, '2016-03-08', '01:38:35', 'CASH', 698, 836.00, '', 'customer payment', 26, 4),
(181, '2016-03-08', '01:45:51', 'CASH', 699, 2475.00, '', 'customer payment', 26, 5),
(182, '2016-03-08', '01:48:21', 'CASH', 700, 2508.00, '', 'customer payment', 26, 7),
(183, '2016-03-08', '01:50:36', 'CASH', 701, 1672.00, '', 'customer payment', 26, 4),
(184, '2016-03-08', '01:51:57', 'CASH', 702, 836.00, '', 'customer payment', 26, 5),
(185, '2016-03-08', '01:52:58', 'CASH', 703, 836.00, '', 'customer payment', 26, 4),
(186, '2016-03-08', '02:36:49', 'CASH', 705, 836.00, '', 'customer payment', 26, 4),
(187, '2016-03-08', '02:40:25', 'CASH', 706, 2376.00, '', 'customer payment', 26, 4),
(188, '2016-03-08', '03:02:31', 'CASH', 707, 836.00, '', 'customer payment', 26, 4),
(189, '2016-03-08', '03:17:05', 'CASH', 708, 3080.00, '', 'customer payment', 26, 5),
(190, '2016-03-08', '03:37:58', 'CASH', 704, 2024.00, '', 'customer payment', 26, 4),
(191, '2016-03-08', '04:03:31', 'CASH', 707, 2208.00, '', 'customer payment', 26, 4),
(192, '2016-03-08', '04:11:04', 'CASH', 709, 1188.00, '', 'customer payment', 26, 5),
(193, '2016-03-08', '04:13:25', 'CASH', 709, 1782.00, '', 'customer payment', 26, 5),
(194, '2016-03-08', '04:15:57', 'CASH', 709, 3454.00, '', 'customer payment', 26, 5);

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE IF NOT EXISTS `expenses` (
  `expenses_id` int(11) NOT NULL AUTO_INCREMENT,
  `beneficiary` varchar(100) NOT NULL,
  `amount` double(16,2) NOT NULL DEFAULT '0.00',
  `date` date NOT NULL,
  `remark` varchar(255) NOT NULL,
  `time` time NOT NULL,
  PRIMARY KEY (`expenses_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `expenses`
--

INSERT INTO `expenses` (`expenses_id`, `beneficiary`, `amount`, `date`, `remark`, `time`) VALUES
(1, 'hotel', 40000.00, '2016-01-22', '40000  paid  for hotel on 22-1-2016', '02:23:22'),
(2, 'hotel', 23000.00, '2016-01-22', '23000  paid  for hotel on 22-1-2016', '02:24:13'),
(3, 'hotel', 23000.00, '2016-01-22', '23000  paid  for hotel on 22-1-2016', '02:25:27'),
(4, 'hotel', 23000.00, '2016-01-22', '23000  paid  for hotel on 22-1-2016', '02:26:52'),
(5, 'hotel', 23000.00, '2016-01-22', '23000  paid  for hotel on 22-1-2016', '02:29:15'),
(6, 'rtuyuy', 3546780.00, '2016-01-22', '3546780  paid  for rtuyuy on 22-1-2016', '02:48:15'),
(7, 'abcdefg', 2000.00, '2016-01-22', '2000  paid  for abcdefg on 22-1-2016', '02:50:16'),
(8, 'dddd', 30000.00, '2016-01-22', 'Enenim Bassey made a payment  <br/> of 30000 to dddd  <br/> on 2016/01/22 at 16:12:20', '16:12:20'),
(9, 'charles', 99000.00, '2016-01-22', 'Enenim Bassey made a payment  <br/> of 99000 to charles  <br/> on 2016/01/22 at 16:20:53', '16:20:53'),
(10, 'drthyjufkjdhsgs', 40000.00, '2016-01-29', 'ertrytuytrrt', '07:57:56'),
(11, 'weghgrj', 5000000.00, '2016-01-29', 'rhtyukijhgre', '07:58:23'),
(12, 'fgndrjfmfhj', 40000.00, '2016-01-29', '', '07:59:48');

-- --------------------------------------------------------

--
-- Table structure for table `haulage`
--

CREATE TABLE IF NOT EXISTS `haulage` (
  `haulage_id` int(11) NOT NULL AUTO_INCREMENT,
  `trans_date` date NOT NULL,
  `trans_time` time NOT NULL,
  `waybill` int(11) NOT NULL,
  `note` varchar(255) NOT NULL,
  `expenditure` double(16,2) NOT NULL DEFAULT '0.00',
  `bbfwd` double(16,2) NOT NULL DEFAULT '0.00',
  `balance` double(16,2) NOT NULL DEFAULT '0.00',
  `vehicle_id` int(11) NOT NULL,
  PRIMARY KEY (`haulage_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;

--
-- Dumping data for table `haulage`
--

INSERT INTO `haulage` (`haulage_id`, `trans_date`, `trans_time`, `waybill`, `note`, `expenditure`, `bbfwd`, `balance`, `vehicle_id`) VALUES
(2, '2017-02-16', '12:24:33', 345, '', 1000.00, 23440.00, -1000.00, 1),
(3, '2017-02-16', '12:25:35', 123, '', 50000.00, 768900.00, -50000.00, 2),
(4, '2017-02-16', '12:27:09', 5879, '', 10000.00, 0.00, -10000.00, 2),
(5, '2017-02-16', '12:28:58', 1122, '', 10000.00, -1000.00, -10000.00, 1),
(6, '2017-02-16', '12:34:26', 200, '', 20000.00, -10000.00, -20000.00, 1),
(7, '2017-02-16', '12:39:00', 189, '', 15000.00, -20000.00, -15000.00, 1),
(8, '2017-02-16', '12:40:55', 212, '', 10000.00, -20000.00, -30000.00, 1),
(9, '2017-02-16', '12:56:53', 123, '', 10000.00, -30000.00, -40000.00, 1),
(10, '2017-02-16', '12:58:09', 124, '', 78800.00, -40000.00, -118800.00, 1),
(11, '2017-02-16', '01:01:28', 23, '', 10000.00, -118800.00, -128800.00, 1),
(12, '2017-02-16', '01:02:11', 23, '', 23000.00, -50000.00, -73000.00, 2),
(13, '2017-02-16', '01:02:49', 122, '', 89000.00, -73000.00, -162000.00, 2),
(14, '2017-02-16', '01:04:55', 233, '', 60000.00, -128800.00, -188800.00, 1),
(15, '2017-02-16', '01:06:50', 556, '', 1000.00, -162000.00, -163000.00, 2),
(16, '2017-02-16', '01:07:29', 432, '', 20000.00, -188800.00, -208800.00, 1),
(17, '2017-02-16', '01:08:12', 3452, '', 30000.00, -208800.00, -238800.00, 1),
(18, '2022-02-16', '09:29:50', 21, 'Paid Something', 213890.00, -238800.00, -452690.00, 1),
(19, '2022-02-16', '10:40:46', 44, '', 12200.00, -452690.00, -464890.00, 1);

-- --------------------------------------------------------

--
-- Table structure for table `invoiceitems_daily`
--

CREATE TABLE IF NOT EXISTS `invoiceitems_daily` (
  `item_id` int(11) NOT NULL AUTO_INCREMENT,
  `cost_price` double(16,2) NOT NULL DEFAULT '0.00',
  `selling_price` double(16,2) NOT NULL DEFAULT '0.00',
  `quantity` int(11) NOT NULL,
  `charge` double(16,2) NOT NULL DEFAULT '0.00',
  `trans_date` date NOT NULL,
  `stock_id` bigint(20) NOT NULL,
  `invoice_num` int(11) NOT NULL,
  `discount` double(16,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`item_id`),
  KEY `fk_invoice_num` (`invoice_num`),
  KEY `fk_stock_id_` (`stock_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1067 ;

--
-- Dumping data for table `invoiceitems_daily`
--

INSERT INTO `invoiceitems_daily` (`item_id`, `cost_price`, `selling_price`, `quantity`, `charge`, `trans_date`, `stock_id`, `invoice_num`, `discount`) VALUES
(959, 0.00, 76.00, 122, 9272.00, '2016-02-17', 9, 625, 0.00),
(960, 0.00, 45.00, 12, 540.00, '2016-02-17', 13, 567, 0.00),
(961, 0.00, 45.00, 33, 1485.00, '2016-02-18', 14, 625, 0.00),
(962, 0.00, 45.00, 11, 495.00, '2016-02-19', 13, 625, 0.00),
(963, 0.00, 56.00, 22, 1232.00, '2016-02-19', 1, 626, 0.00),
(964, 0.00, 45.00, 45, 2025.00, '2016-02-19', 14, 626, 0.00),
(965, 0.00, 76.00, 11, 836.00, '2016-02-19', 15, 626, 0.00),
(966, 0.00, 76.00, 11, 836.00, '2016-02-19', 1, 627, 0.00),
(967, 0.00, 54.00, 22, 1188.00, '2016-02-19', 11, 627, 0.00),
(968, 0.00, 45.00, 54, 2430.00, '2016-02-19', 13, 569, 0.00),
(969, 0.00, 76.00, 11, 836.00, '2016-02-19', 9, 628, 0.00),
(970, 0.00, 45.00, 12, 540.00, '2016-02-19', 13, 628, 0.00),
(971, 0.00, 45.00, 11, 495.00, '2016-02-19', 13, 555, 0.00),
(972, 0.00, 45.00, 23, 1035.00, '2016-02-19', 13, 556, 0.00),
(973, 0.00, 54.00, 11, 594.00, '2016-02-19', 11, 628, 0.00),
(974, 0.00, 76.00, 12, 912.00, '2016-02-19', 15, 628, 0.00),
(975, 0.00, 76.00, 1233, 93708.00, '2016-02-22', 9, 562, 0.00),
(976, 0.00, 67.00, 21333, 1429311.00, '2016-02-22', 11, 567, 0.00),
(977, 0.00, 45.00, 213, 9585.00, '2016-02-22', 11, 568, 0.00),
(978, 0.00, 76.00, 11, 836.00, '2016-02-24', 1, 646, 0.00),
(979, 0.00, 76.00, 22, 1672.00, '2016-02-24', 15, 646, 0.00),
(980, 0.00, 89.00, 9, 801.00, '2016-02-24', 9, 646, 0.00),
(981, 0.00, 45.00, 23, 1035.00, '2016-02-24', 13, 646, 0.00),
(982, 0.00, 54.00, 43, 2322.00, '2016-02-24', 11, 646, 0.00),
(983, 0.00, 76.00, 11, 836.00, '2016-02-24', 15, 647, 0.00),
(984, 0.00, 45.00, 12, 540.00, '2016-02-24', 14, 647, 0.00),
(985, 0.00, 56.00, 13, 728.00, '2016-02-24', 1, 647, 0.00),
(986, 0.00, 76.00, 16, 1216.00, '2016-02-24', 9, 647, 0.00),
(987, 0.00, 45.00, 15, 675.00, '2016-02-24', 13, 647, 0.00),
(988, 0.00, 54.00, 12, 648.00, '2016-02-24', 11, 647, 0.00),
(989, 0.00, 76.00, 11, 836.00, '2016-02-24', 1, 647, 0.00),
(990, 0.00, 45.00, 12, 540.00, '2016-02-24', 14, 647, 0.00),
(991, 0.00, 45.00, 11, 495.00, '2016-02-24', 14, 649, 0.00),
(992, 0.00, 56.00, 21, 1176.00, '2016-02-24', 1, 649, 0.00),
(993, 0.00, 45.00, 12, 540.00, '2016-02-24', 13, 649, 0.00),
(994, 0.00, 54.00, 33, 1782.00, '2016-02-24', 11, 649, 0.00),
(995, 0.00, 76.00, 54, 4104.00, '2016-02-24', 15, 649, 0.00),
(996, 0.00, 76.00, 12, 912.00, '2016-02-24', 15, 649, 0.00),
(997, 0.00, 54.00, 11, 594.00, '2016-02-24', 11, 649, 0.00),
(998, 0.00, 76.00, 11, 836.00, '2016-02-24', 15, 649, 0.00),
(999, 0.00, 76.00, 11, 836.00, '2016-02-24', 15, 649, 0.00),
(1000, 0.00, 76.00, 11, 836.00, '2016-02-24', 15, 649, 0.00),
(1001, 0.00, 56.00, 90, 5040.00, '2016-02-24', 1, 649, 0.00),
(1002, 0.00, 45.00, 18, 810.00, '2016-02-24', 13, 649, 0.00),
(1003, 0.00, 76.00, 20, 1520.00, '2016-02-25', 15, 650, 0.00),
(1004, 0.00, 76.00, 10, 760.00, '2016-02-25', 15, 650, 0.00),
(1005, 0.00, 54.00, 12, 648.00, '2016-02-25', 11, 650, 0.00),
(1006, 0.00, 45.00, 12, 540.00, '2016-02-25', 13, 650, 0.00),
(1009, 0.00, 67.00, 150, 10050.00, '2016-02-25', 11, 651, 0.00),
(1010, 0.00, 45.00, 100, 4500.00, '2016-02-25', 13, 651, 0.00),
(1011, 0.00, 67.00, 176, 11792.00, '2016-02-25', 11, 651, 0.00),
(1012, 0.00, 76.00, 10, 760.00, '2016-02-26', 1, 652, 0.00),
(1013, 0.00, 76.00, 54, 4104.00, '2016-03-04', 9, 653, 0.00),
(1014, 0.00, 54.00, 21, 1134.00, '2016-03-04', 11, 651, 0.00),
(1015, 0.00, 56.00, 334, 18704.00, '2016-03-04', 1, 656, 0.00),
(1016, 0.00, 54.00, 45, 2430.00, '2016-03-04', 11, 656, 0.00),
(1017, 0.00, 54.00, 11, 594.00, '2016-03-04', 11, 656, 0.00),
(1018, 0.00, 76.00, 33, 2508.00, '2016-03-04', 9, 659, 0.00),
(1019, 0.00, 54.00, 12, 648.00, '2016-03-04', 11, 659, 0.00),
(1020, 0.00, 45.00, 33, 1485.00, '2016-03-04', 13, 659, 0.00),
(1021, 0.00, 76.00, 11, 836.00, '2016-03-04', 1, 660, 0.00),
(1022, 0.00, 76.00, 23, 1748.00, '2016-03-04', 9, 660, 0.00),
(1023, 0.00, 76.00, 11, 836.00, '2016-03-04', 1, 661, 0.00),
(1024, 0.00, 54.00, 23, 1242.00, '2016-03-04', 11, 661, 0.00),
(1025, 0.00, 45.00, 12, 540.00, '2016-03-04', 14, 661, 0.00),
(1026, 0.00, 56.00, 332, 18592.00, '2016-03-04', 1, 662, 0.00),
(1027, 0.00, 56.00, 22, 1232.00, '2016-03-04', 1, 663, 0.00),
(1028, 0.00, 45.00, 44, 1980.00, '2016-03-04', 13, 663, 0.00),
(1029, 0.00, 56.00, 22, 1232.00, '2016-03-04', 1, 664, 0.00),
(1030, 0.00, 76.00, 11, 836.00, '2016-03-04', 1, 665, 0.00),
(1031, 0.00, 76.00, 11, 836.00, '2016-03-04', 1, 666, 0.00),
(1032, 0.00, 56.00, 65, 3640.00, '2016-03-04', 1, 667, 0.00),
(1033, 0.00, 56.00, 44, 2464.00, '2016-03-04', 1, 667, 0.00),
(1034, 0.00, 76.00, 66, 5016.00, '2016-03-04', 9, 668, 0.00),
(1035, 0.00, 67.00, 6767, 453389.00, '2016-03-04', 11, 669, 0.00),
(1036, 0.00, 54.00, 56, 3024.00, '2016-03-04', 11, 672, 0.00),
(1037, 0.00, 76.00, 34, 2584.00, '2016-03-04', 9, 674, 0.00),
(1038, 0.00, 54.00, 34, 1836.00, '2016-03-04', 11, 676, 0.00),
(1039, 0.00, 76.00, 11, 836.00, '2016-03-04', 1, 677, 0.00),
(1040, 0.00, 54.00, 11, 594.00, '2016-03-04', 11, 678, 0.00),
(1041, 0.00, 56.00, 22, 1232.00, '2016-03-07', 1, 687, 0.00),
(1042, 0.00, 76.00, 11, 836.00, '2016-03-07', 9, 687, 0.00),
(1043, 0.00, 76.00, 22, 1672.00, '2016-03-07', 9, 687, 0.00),
(1044, 0.00, 76.00, 12, 912.00, '2016-03-08', 9, 690, 0.00),
(1045, 0.00, 45.00, 11, 495.00, '2016-03-08', 14, 690, 0.00),
(1046, 0.00, 56.00, 33, 1848.00, '2016-03-08', 1, 695, 0.00),
(1047, 0.00, 54.00, 23, 1242.00, '2016-03-08', 11, 695, 0.00),
(1048, 0.00, 76.00, 123, 9348.00, '2016-03-08', 9, 696, 0.00),
(1049, 0.00, 76.00, 33, 2508.00, '2016-03-08', 9, 697, 0.00),
(1050, 0.00, 76.00, 11, 836.00, '2016-03-08', 9, 698, 0.00),
(1051, 0.00, 45.00, 55, 2475.00, '2016-03-08', 13, 699, 0.00),
(1052, 0.00, 76.00, 33, 2508.00, '2016-03-08', 9, 700, 0.00),
(1053, 0.00, 76.00, 22, 1672.00, '2016-03-08', 9, 701, 0.00),
(1054, 0.00, 76.00, 11, 836.00, '2016-03-08', 1, 702, 0.00),
(1055, 0.00, 76.00, 11, 836.00, '2016-03-08', 9, 703, 0.00),
(1056, 0.00, 76.00, 11, 836.00, '2016-03-08', 1, 705, 0.00),
(1057, 0.00, 54.00, 44, 2376.00, '2016-03-08', 11, 706, 0.00),
(1058, 0.00, 76.00, 11, 836.00, '2016-03-08', 9, 707, 0.00),
(1059, 0.00, 56.00, 55, 3080.00, '2016-03-08', 1, 708, 0.00),
(1060, 0.00, 76.00, 11, 836.00, '2016-03-08', 9, 704, 0.00),
(1061, 0.00, 54.00, 22, 1188.00, '2016-03-08', 11, 704, 0.00),
(1062, 0.00, 76.00, 11, 836.00, '2016-03-08', 9, 707, 0.00),
(1063, 0.00, 67.00, 8, 536.00, '2016-03-08', 13, 707, 0.00),
(1064, 0.00, 54.00, 22, 1188.00, '2016-03-08', 11, 709, 0.00),
(1065, 0.00, 54.00, 11, 594.00, '2016-03-08', 11, 709, 0.00),
(1066, 0.00, 76.00, 22, 1672.00, '2016-03-08', 9, 709, 0.00);

-- --------------------------------------------------------

--
-- Table structure for table `openingbalance`
--

CREATE TABLE IF NOT EXISTS `openingbalance` (
  `openingbal_id` int(11) NOT NULL AUTO_INCREMENT,
  `amount` double(16,2) NOT NULL DEFAULT '0.00',
  `date` date NOT NULL,
  PRIMARY KEY (`openingbal_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `openingbalance`
--

INSERT INTO `openingbalance` (`openingbal_id`, `amount`, `date`) VALUES
(1, 20000.00, '2016-01-22'),
(2, 12320060.00, '2016-01-28'),
(3, 234567.00, '2016-02-22'),
(4, 10000.00, '2016-02-26');

-- --------------------------------------------------------

--
-- Table structure for table `promo`
--

CREATE TABLE IF NOT EXISTS `promo` (
  `promo_id` int(11) NOT NULL AUTO_INCREMENT,
  `stock_code` varchar(100) NOT NULL,
  `purchase_qty` int(11) NOT NULL,
  `giveaway_stock` varchar(100) NOT NULL,
  `giveaway_qty` int(11) NOT NULL,
  `stock_code2` varchar(100) NOT NULL DEFAULT '',
  `purchase_qty2` int(11) NOT NULL DEFAULT '0',
  `promo_status` varchar(50) NOT NULL DEFAULT 'active',
  `tracker` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`promo_id`),
  KEY `stock_id` (`stock_code`,`stock_code2`),
  KEY `stock_id2` (`stock_code2`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `promo`
--

INSERT INTO `promo` (`promo_id`, `stock_code`, `purchase_qty`, `giveaway_stock`, `giveaway_qty`, `stock_code2`, `purchase_qty2`, `promo_status`, `tracker`) VALUES
(10, 'MLK-202', 2, 'MLK-202', 1, '', 0, 'inactive', 1),
(11, 'PROV-50', 21, 'ONS-111', 10, 'SUG-2749', 13, 'active', 2),
(12, 'PROV-25', 21, 'PROV-50', 2, '', 0, 'active', 1),
(13, 'ONS-111', 21, 'PROV-25', 11, '', 0, 'active', 1);

-- --------------------------------------------------------

--
-- Table structure for table `promoaccount`
--

CREATE TABLE IF NOT EXISTS `promoaccount` (
  `promoacct_id` int(11) NOT NULL AUTO_INCREMENT,
  `quantity` int(11) NOT NULL,
  `trans_date` date NOT NULL,
  `stock_code` varchar(50) NOT NULL,
  `promo_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  PRIMARY KEY (`promoacct_id`),
  KEY `fk_promoid` (`promo_id`),
  KEY `fk_item_id` (`item_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=513 ;

--
-- Dumping data for table `promoaccount`
--

INSERT INTO `promoaccount` (`promoacct_id`, `quantity`, `trans_date`, `stock_code`, `promo_id`, `item_id`) VALUES
(492, 11165, '2016-02-22', 'PROV-25', 13, 976),
(493, 100, '2016-02-18', 'ONS-111', 11, 977),
(494, 20, '2016-02-23', 'ONS-111', 10, 972),
(495, 2, '2016-02-24', 'PROV-50', 12, 979),
(496, 22, '2016-02-24', 'PROV-25', 13, 982),
(497, 11, '2016-02-24', 'PROV-25', 13, 994),
(498, 4, '2016-02-24', 'PROV-50', 12, 995),
(500, 77, '2016-02-25', 'PROV-25', 13, 1009),
(501, 88, '2016-02-25', 'PROV-25', 13, 1011),
(502, 11, '2016-03-04', 'PROV-25', 13, 1014),
(503, 22, '2016-03-04', 'PROV-25', 13, 1016),
(504, 10, '2016-03-04', 'ONS-111', 11, 1020),
(505, 11, '2016-03-04', 'PROV-25', 13, 1024),
(506, 3542, '2016-03-04', 'PROV-25', 13, 1035),
(507, 22, '2016-03-04', 'PROV-25', 13, 1036),
(508, 11, '2016-03-04', 'PROV-25', 13, 1038),
(509, 11, '2016-03-08', 'PROV-25', 13, 1047),
(510, 22, '2016-03-08', 'PROV-25', 13, 1057),
(511, 11, '2016-03-08', 'PROV-25', 13, 1061),
(512, 11, '2016-03-08', 'PROV-25', 13, 1064);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE IF NOT EXISTS `roles` (
  `role_id` int(11) NOT NULL AUTO_INCREMENT,
  `role_name` varchar(50) NOT NULL,
  `menu_invoice` int(1) NOT NULL DEFAULT '0',
  `menu_supplier` int(1) NOT NULL DEFAULT '0',
  `menu_customer` int(1) NOT NULL DEFAULT '0',
  `menu_cashstock` int(1) NOT NULL DEFAULT '0',
  `menu_stock` int(1) NOT NULL DEFAULT '0',
  `menu_haulage` int(1) NOT NULL DEFAULT '0',
  `menu_setup` int(1) NOT NULL DEFAULT '0',
  `menu_report` int(1) NOT NULL DEFAULT '0',
  `acceptcustomerpayment` int(1) NOT NULL DEFAULT '0',
  `raisecreditinvoice` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`role_id`),
  UNIQUE KEY `role_id` (`role_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`role_id`, `role_name`, `menu_invoice`, `menu_supplier`, `menu_customer`, `menu_cashstock`, `menu_stock`, `menu_haulage`, `menu_setup`, `menu_report`, `acceptcustomerpayment`, `raisecreditinvoice`) VALUES
(13, 'admin', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1),
(14, 'operator', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(15, 'manager', 1, 0, 0, 0, 1, 1, 1, 0, 0, 0),
(16, 'invoice_tracker', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(17, 'invoice_confirmer', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `salesinvoice`
--

CREATE TABLE IF NOT EXISTS `salesinvoice` (
  `invoice_num` int(11) NOT NULL,
  `sales_date` date NOT NULL,
  `sales_time` time NOT NULL,
  `purchase_amount` double(16,2) NOT NULL DEFAULT '0.00',
  `store` varchar(50) NOT NULL,
  `payment_type` varchar(50) NOT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'OPEN',
  `cashier` varchar(100) NOT NULL,
  `store_confirmation` varchar(100) NOT NULL DEFAULT 'NOT SUPPLIED',
  `user_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  PRIMARY KEY (`invoice_num`),
  KEY `fk_user_trans` (`user_id`),
  KEY `fk_customer_id` (`customer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `salesinvoice`
--

INSERT INTO `salesinvoice` (`invoice_num`, `sales_date`, `sales_time`, `purchase_amount`, `store`, `payment_type`, `status`, `cashier`, `store_confirmation`, `user_id`, `customer_id`) VALUES
(553, '2016-02-09', '03:37:50', 4101.00, '1', 'CASH', 'OPEN', '', 'NOT SUPPLIED', 26, 4),
(554, '2016-02-11', '11:15:25', 6863.00, '1', 'CASH', 'CLOSED', '', 'NOT SUPPLIED', 26, 4),
(555, '2016-02-09', '04:33:11', 1848.00, '1', 'CASH', 'CLOSED', '', 'SUPPLIED', 26, 4),
(556, '2016-02-10', '09:47:39', 3344.00, '1', 'CASH', 'CLOSED', '', 'SUPPLIED', 26, 6),
(558, '2016-02-10', '10:06:08', 0.00, '1', 'CASH', 'OPEN', '', 'NOT SUPPLIED', 26, 4),
(559, '2016-02-11', '07:52:09', 0.00, '1', 'CASH', 'OPEN', '', 'NOT SUPPLIED', 26, 5),
(560, '2016-02-11', '01:46:49', 0.00, '1', 'CASH', 'OPEN', '', 'NOT SUPPLIED', 26, 5),
(561, '2016-02-12', '07:41:57', 2432.00, '1', 'CASH', 'CLOSED', '', 'NOT SUPPLIED', 26, 5),
(562, '2016-02-12', '08:30:39', 0.00, '1', 'CASH', 'OPEN', '', 'NOT SUPPLIED', 26, 4),
(563, '2016-02-12', '12:20:22', 0.00, '1', 'CASH', 'OPEN', '', 'NOT SUPPLIED', 26, 4),
(565, '2016-02-12', '01:59:51', 4596.00, '1', 'CASH', 'CLOSED', '', 'NOT SUPPLIED', 26, 5),
(566, '2016-02-12', '02:04:36', 0.00, '1', 'CASH', 'OPEN', '', 'NOT SUPPLIED', 26, 4),
(567, '2016-02-12', '02:06:01', 0.00, '1', 'CASH', 'OPEN', '', 'NOT SUPPLIED', 26, 5),
(568, '2016-02-12', '02:22:53', 0.00, '1', 'CASH', 'OPEN', '', 'NOT SUPPLIED', 26, 4),
(569, '2016-02-12', '02:52:47', 0.00, '1', 'CASH', 'OPEN', '', 'NOT SUPPLIED', 26, 4),
(646, '2016-02-24', '03:29:27', 6666.00, '1', 'CASH', 'CLOSED', '', 'NOT SUPPLIED', 26, 4),
(649, '2016-02-24', '05:07:14', 0.00, '1', 'CASH', 'OPEN', '', 'NOT SUPPLIED', 26, 4),
(651, '2016-02-25', '08:23:05', 33082.00, '1', 'CASH', 'CLOSED', '', 'NOT SUPPLIED', 26, 8);

-- --------------------------------------------------------

--
-- Table structure for table `salesinvoice_daily`
--

CREATE TABLE IF NOT EXISTS `salesinvoice_daily` (
  `invoice_num` int(11) NOT NULL AUTO_INCREMENT,
  `sales_date` date NOT NULL,
  `sales_time` time NOT NULL,
  `purchase_amount` double(16,2) NOT NULL DEFAULT '0.00',
  `store` varchar(50) NOT NULL,
  `payment_type` varchar(50) NOT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'OPEN',
  `cashier` varchar(100) NOT NULL,
  `store_confirmation` varchar(100) NOT NULL DEFAULT 'NOT SUPPLIED',
  `user_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  PRIMARY KEY (`invoice_num`),
  KEY `fk_user_trans` (`user_id`),
  KEY `fk_customer_id` (`customer_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=710 ;

--
-- Dumping data for table `salesinvoice_daily`
--

INSERT INTO `salesinvoice_daily` (`invoice_num`, `sales_date`, `sales_time`, `purchase_amount`, `store`, `payment_type`, `status`, `cashier`, `store_confirmation`, `user_id`, `customer_id`) VALUES
(625, '2016-02-19', '10:05:35', 0.00, '1', 'CASH', 'OPEN', '', 'NOT SUPPLIED', 26, 4),
(626, '2016-02-19', '10:18:50', 0.00, '1', 'CASH', 'OPEN', '', 'NOT SUPPLIED', 26, 5),
(627, '2016-02-19', '10:24:09', 4454.00, '1', 'CASH', 'OPEN', '', 'NOT SUPPLIED', 26, 6),
(628, '2016-02-22', '10:38:05', 4412.00, '1', 'CASH', 'CLOSED', '', 'NOT SUPPLIED', 26, 7),
(629, '2016-02-22', '10:36:03', 1532604.00, '1', 'CREDIT', 'OPEN', 'charles', 'NOT SUPPLIED', 26, 5),
(630, '2016-02-22', '12:29:19', 0.00, '1', 'CASH', 'OPEN', '', 'NOT SUPPLIED', 26, 4),
(632, '2016-02-22', '01:00:22', 0.00, '', '', 'OPEN', '', 'NOT SUPPLIED', 26, 0),
(634, '2016-02-22', '01:03:09', 0.00, '', '', 'OPEN', '', 'NOT SUPPLIED', 26, 0),
(636, '2016-02-22', '01:03:36', 0.00, '', '', 'OPEN', '', 'NOT SUPPLIED', 26, 0),
(638, '2016-02-22', '01:05:29', 0.00, '', '', 'OPEN', '', 'NOT SUPPLIED', 26, 0),
(639, '2016-02-22', '01:07:35', 0.00, '1', 'CASH', 'OPEN', '', 'NOT SUPPLIED', 26, 4),
(640, '2016-02-22', '01:08:07', 0.00, '1', 'CASH', 'OPEN', '', 'NOT SUPPLIED', 26, 6),
(641, '2016-02-22', '01:08:39', 0.00, '1', 'CASH', 'OPEN', '', 'NOT SUPPLIED', 26, 4),
(642, '2016-02-22', '01:13:39', 0.00, '1', 'CASH', 'OPEN', '', 'NOT SUPPLIED', 26, 6),
(643, '2016-02-22', '01:15:16', 0.00, '1', 'CASH', 'OPEN', '', 'NOT SUPPLIED', 26, 4),
(645, '2016-02-22', '01:23:22', 0.00, '1', 'CASH', 'OPEN', '', 'NOT SUPPLIED', 26, 4),
(646, '2016-02-24', '03:29:27', 6666.00, '1', 'CASH', 'CLOSED', '', 'NOT SUPPLIED', 26, 4),
(647, '2016-02-24', '05:03:58', 0.00, '1', 'CASH', 'OPEN', '', 'NOT SUPPLIED', 26, 6),
(648, '2016-02-24', '05:03:58', 0.00, '1', 'CASH', 'OPEN', '', 'NOT SUPPLIED', 26, 6),
(649, '2016-02-24', '05:07:14', 0.00, '1', 'CASH', 'OPEN', '', 'NOT SUPPLIED', 26, 4),
(651, '2016-03-04', '11:13:56', 27476.00, '1', 'CASH', 'CLOSED', '', 'NOT SUPPLIED', 26, 8),
(652, '2016-02-26', '02:17:04', 760.00, '1', 'CASH', 'OPEN', '', 'NOT SUPPLIED', 26, 4),
(653, '2016-03-04', '10:20:03', 0.00, '1', 'CASH', 'OPEN', '', 'NOT SUPPLIED', 26, 4),
(654, '2016-03-04', '10:50:25', 0.00, '3', 'CASH', 'OPEN', '', 'NOT SUPPLIED', 26, 4),
(655, '2016-03-04', '11:41:01', 0.00, '10', 'CASH', 'OPEN', '', 'NOT SUPPLIED', 26, 4),
(656, '2016-03-04', '11:44:18', 21728.00, '1', 'CASH', 'CLOSED', '', 'NOT SUPPLIED', 26, 5),
(658, '2016-03-04', '11:58:40', 0.00, '10', 'CASH', 'OPEN', '', 'NOT SUPPLIED', 26, 5),
(659, '2016-03-04', '12:01:09', 4641.00, '1', 'CASH', 'CLOSED', '', 'NOT SUPPLIED', 26, 5),
(660, '2016-03-04', '12:04:17', 2584.00, '1', 'CASH', 'CLOSED', '', 'NOT SUPPLIED', 26, 4),
(661, '2016-03-04', '12:10:26', 2618.00, '1', 'CASH', 'CLOSED', '', 'NOT SUPPLIED', 26, 4),
(662, '2016-03-04', '12:11:43', 18592.00, '1', 'CASH', 'CLOSED', '', 'NOT SUPPLIED', 26, 5),
(663, '2016-03-04', '02:14:44', 3212.00, '1', 'CASH', 'CLOSED', '', 'NOT SUPPLIED', 26, 4),
(664, '2016-03-04', '02:17:11', 1232.00, '1', 'CASH', 'CLOSED', '', 'NOT SUPPLIED', 26, 4),
(665, '2016-03-04', '02:25:40', 836.00, '1', 'CASH', 'CLOSED', '', 'NOT SUPPLIED', 26, 4),
(666, '2016-03-04', '02:48:27', 836.00, '1', 'CASH', 'CLOSED', '', 'NOT SUPPLIED', 26, 4),
(667, '2016-03-04', '02:50:56', 6104.00, '1', 'CASH', 'CLOSED', '', 'NOT SUPPLIED', 26, 4),
(669, '2016-03-04', '02:57:10', 453389.00, '3', 'CASH', 'CLOSED', '', 'NOT SUPPLIED', 26, 5),
(672, '2016-03-04', '02:59:08', 3024.00, '1', 'CASH', 'CLOSED', '', 'NOT SUPPLIED', 26, 5),
(673, '2016-03-04', '02:59:48', 0.00, '1', 'CASH', 'OPEN', '', 'NOT SUPPLIED', 26, 6),
(674, '2016-03-04', '03:00:38', 2584.00, '1', 'CASH', 'CLOSED', '', 'NOT SUPPLIED', 26, 5),
(675, '2016-03-04', '03:01:03', 0.00, '11', 'CASH', 'OPEN', '', 'NOT SUPPLIED', 26, 5),
(676, '2016-03-04', '03:01:47', 1836.00, '1', 'CASH', 'CLOSED', '', 'NOT SUPPLIED', 26, 5),
(677, '2016-03-04', '03:14:35', 836.00, '1', 'CASH', 'CLOSED', '', 'NOT SUPPLIED', 26, 4),
(678, '2016-03-04', '03:15:14', 594.00, '1', 'CASH', 'CLOSED', '', 'NOT SUPPLIED', 26, 5),
(679, '2016-03-04', '03:25:07', 0.00, '1', 'CASH', 'OPEN', '', 'NOT SUPPLIED', 26, 4),
(680, '2016-03-04', '03:27:29', 0.00, '1', 'CASH', 'OPEN', '', 'NOT SUPPLIED', 26, 5),
(681, '2016-03-04', '03:28:24', 0.00, '11', 'CASH', 'OPEN', '', 'NOT SUPPLIED', 26, 5),
(682, '2016-03-04', '03:30:35', 0.00, '11', 'CASH', 'OPEN', '', 'NOT SUPPLIED', 26, 4),
(683, '2016-03-04', '03:31:31', 0.00, '1', 'CASH', 'OPEN', '', 'NOT SUPPLIED', 26, 4),
(684, '2016-03-04', '03:32:13', 0.00, '1', 'CASH', 'OPEN', '', 'NOT SUPPLIED', 26, 4),
(685, '2016-03-04', '03:32:47', 0.00, '1', 'CASH', 'OPEN', '', 'NOT SUPPLIED', 26, 4),
(687, '2016-03-07', '02:57:45', 2068.00, '1', 'CASH', 'OPEN', '', 'NOT SUPPLIED', 26, 5),
(688, '2016-03-08', '12:25:27', 0.00, '1', 'CASH', 'OPEN', '', 'NOT SUPPLIED', 26, 4),
(691, '2016-03-08', '12:43:59', 0.00, '1', 'CASH', 'OPEN', '', 'NOT SUPPLIED', 26, 4),
(693, '2016-03-08', '12:52:31', 0.00, '1', 'CASH', 'OPEN', '', 'NOT SUPPLIED', 26, 4),
(695, '2016-03-08', '01:13:22', 3090.00, '1', 'CASH', 'CLOSED', '', 'NOT SUPPLIED', 26, 4),
(696, '2016-03-08', '01:16:44', 9348.00, '1', 'CASH', 'CLOSED', '', 'NOT SUPPLIED', 26, 5),
(697, '2016-03-08', '01:19:47', 0.00, '1', 'CASH', 'OPEN', '', 'NOT SUPPLIED', 26, 4),
(698, '2016-03-08', '01:38:35', 836.00, '1', 'CASH', 'CLOSED', '', 'NOT SUPPLIED', 26, 4),
(699, '2016-03-08', '01:45:51', 2475.00, '1', 'CASH', 'CLOSED', '', 'NOT SUPPLIED', 26, 5),
(700, '2016-03-08', '01:48:21', 2508.00, '1', 'CASH', 'CLOSED', '', 'NOT SUPPLIED', 26, 7),
(701, '2016-03-08', '01:50:36', 1672.00, '1', 'CASH', 'CLOSED', '', 'NOT SUPPLIED', 26, 4),
(702, '2016-03-08', '01:51:57', 836.00, '1', 'CASH', 'CLOSED', '', 'NOT SUPPLIED', 26, 5),
(703, '2016-03-08', '01:52:58', 836.00, '1', 'CASH', 'CLOSED', '', 'NOT SUPPLIED', 26, 4),
(704, '2016-03-08', '03:37:58', 2024.00, '1', 'CASH', 'CLOSED', '', 'NOT SUPPLIED', 26, 4),
(705, '2016-03-08', '02:36:49', 836.00, '1', 'CASH', 'CLOSED', '', 'NOT SUPPLIED', 26, 4),
(706, '2016-03-08', '02:40:25', 2376.00, '1', 'CASH', 'CLOSED', '', 'NOT SUPPLIED', 26, 4),
(707, '2016-03-08', '04:03:31', 2208.00, '1', 'CASH', 'CLOSED', '', 'NOT SUPPLIED', 26, 4),
(708, '2016-03-08', '03:17:05', 3080.00, '1', 'CASH', 'CLOSED', '', 'NOT SUPPLIED', 26, 5),
(709, '2016-03-08', '04:15:57', 3454.00, '1', 'CASH', 'CLOSED', '', 'NOT SUPPLIED', 26, 5);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE IF NOT EXISTS `settings` (
  `check_` int(11) NOT NULL DEFAULT '1',
  `company_id` int(11) NOT NULL DEFAULT '0',
  `company_name` varchar(255) NOT NULL,
  `company_address` varchar(255) NOT NULL,
  `company_phone` varchar(50) NOT NULL,
  `company_phone2` varchar(50) DEFAULT NULL,
  `company_email` varchar(50) NOT NULL,
  `accounting_year_start` date NOT NULL,
  `accounting_year_end` date NOT NULL,
  `retail_store` varchar(100) NOT NULL,
  `upload_url` varchar(255) NOT NULL,
  `ftp_server_name` varchar(255) NOT NULL,
  `ftp_server_user` varchar(255) NOT NULL,
  `ftp_server_password` varchar(255) NOT NULL,
  `sms_username` varchar(255) NOT NULL,
  `sms_password` varchar(255) NOT NULL,
  PRIMARY KEY (`check_`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`check_`, `company_id`, `company_name`, `company_address`, `company_phone`, `company_phone2`, `company_email`, `accounting_year_start`, `accounting_year_end`, `retail_store`, `upload_url`, `ftp_server_name`, `ftp_server_user`, `ftp_server_password`, `sms_username`, `sms_password`) VALUES
(1, 7, 'Derty', '20 Abuja Mataima', '08075649462', NULL, 'folaazeez@digitalquestng.com', '2016-03-01', '2016-12-31', '11', 'http://ijeoma.dqdemos.com', 'ijeoma.dqdemos.com', 'ijeoma@dqdemos.com', 'Ijeoma*123#', 'something', 'something');

-- --------------------------------------------------------

--
-- Table structure for table `stock`
--

CREATE TABLE IF NOT EXISTS `stock` (
  `stock_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `stock_code` varchar(100) NOT NULL,
  `stock_name` varchar(100) NOT NULL,
  `costprice` double(16,2) NOT NULL,
  `sales_person_price` double(16,2) NOT NULL DEFAULT '0.00',
  `high_purchase` double(16,2) NOT NULL DEFAULT '0.00',
  `low_purchase` double(16,2) NOT NULL DEFAULT '0.00',
  `slab` double(16,0) NOT NULL DEFAULT '0',
  `sprice` double(16,2) NOT NULL,
  `block` int(1) NOT NULL DEFAULT '0',
  `reorder_level` bigint(20) NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  PRIMARY KEY (`stock_id`),
  UNIQUE KEY `stock_id` (`stock_id`),
  UNIQUE KEY `stock_code` (`stock_code`),
  KEY `fk_supplier` (`supplier_id`),
  KEY `fk_category` (`category_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `stock`
--

INSERT INTO `stock` (`stock_id`, `stock_code`, `stock_name`, `costprice`, `sales_person_price`, `high_purchase`, `low_purchase`, `slab`, `sprice`, `block`, `reorder_level`, `supplier_id`, `category_id`) VALUES
(1, 'PROV-200', 'rice', 24.00, 45.00, 56.00, 76.00, 12, 0.00, 1, 23000000, 5, 4),
(9, 'SUG-2749', 'dangote sugar', 34.00, 56.00, 76.00, 89.00, 10, 0.00, 0, 47437548, 4, 2),
(11, 'ONS-111', 'Titus Sardine', 23.00, 45.00, 67.00, 54.00, 67, 0.00, 1, 11, 8, 3),
(13, 'PROV-50', 'Laser Oil', 12.00, 13.00, 45.00, 67.00, 9, 0.00, 0, 20, 10, 4),
(14, 'ONS-023', 'Nothern fresh onions', 32.00, 45.00, 45.00, 65.00, 10, 0.00, 0, 9940466, 4, 3),
(15, 'PROV-25', 'Dangote Spagetti', 23.00, 25.00, 56.00, 76.00, 89, 0.00, 1, 21, 5, 4);

-- --------------------------------------------------------

--
-- Table structure for table `stockledger`
--

CREATE TABLE IF NOT EXISTS `stockledger` (
  `stock_ledger_id` int(11) NOT NULL AUTO_INCREMENT,
  `opening_bal` int(11) NOT NULL,
  `task` varchar(50) NOT NULL,
  `quantity` int(11) NOT NULL,
  `remarks` varchar(100) NOT NULL,
  `closing_bal` double(16,2) NOT NULL DEFAULT '0.00',
  `update_date` date NOT NULL,
  `stock_id` bigint(20) NOT NULL,
  `store_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `update_time` time NOT NULL,
  PRIMARY KEY (`stock_ledger_id`),
  KEY `fk_stockid_ledger` (`stock_id`),
  KEY `fk_storeidledger2` (`store_id`),
  KEY `fkuserid_ledger` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=116 ;

--
-- Dumping data for table `stockledger`
--

INSERT INTO `stockledger` (`stock_ledger_id`, `opening_bal`, `task`, `quantity`, `remarks`, `closing_bal`, `update_date`, `stock_id`, `store_id`, `user_id`, `update_time`) VALUES
(111, 3456, 'reset', 32455555, 'No Remark', 32455555.00, '2016-02-05', 11, 1, 26, '12:40:49'),
(112, 23456, 'receipt', 2145666, 'No Remark', 2169122.00, '2016-02-05', 15, 2, 26, '12:41:08'),
(113, 3445509, 'stock_transfer', 234, 'No Remark', 3445275.00, '2016-02-05', 9, 1, 26, '12:41:25'),
(114, 3445275, 'sales_out', 2345, 'sold out', 3442930.00, '2016-02-05', 9, 1, 26, '12:41:44'),
(115, 2169122, 'stock_transfer', 2345, 'No Remark', 2166777.00, '2016-02-05', 15, 2, 26, '12:42:11');

-- --------------------------------------------------------

--
-- Table structure for table `stockposition`
--

CREATE TABLE IF NOT EXISTS `stockposition` (
  `stockposition_id` int(3) NOT NULL AUTO_INCREMENT,
  `stock_id` bigint(20) NOT NULL,
  `store_id` int(11) NOT NULL,
  `unit` int(11) NOT NULL,
  `stock_count` bigint(20) NOT NULL,
  `reorder_level_store` bigint(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`stockposition_id`),
  UNIQUE KEY `stockposition_id` (`stockposition_id`),
  KEY `fk_stock` (`stock_id`),
  KEY `fk_storeid` (`store_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=49 ;

--
-- Dumping data for table `stockposition`
--

INSERT INTO `stockposition` (`stockposition_id`, `stock_id`, `store_id`, `unit`, `stock_count`, `reorder_level_store`) VALUES
(24, 13, 1, 1, 342474, 0),
(25, 1, 1, 1, 2341230, 10),
(26, 11, 1, 1, 32429583, 0),
(27, 13, 2, 1, 5, 0),
(28, 9, 1, 1, 3435298, 0),
(29, 9, 2, 1, 3, 0),
(31, 14, 1, 1, 21782, 0),
(32, 11, 3, 1, 16688, 0),
(33, 11, 2, 1, 23455186, 0),
(35, 13, 3, 1, 7, 0),
(37, 15, 2, 1, 2166777, 0),
(38, 14, 2, 1, 324319, 0),
(39, 15, 1, 1, 10927, 0),
(40, 1, 3, 0, 0, 5),
(41, 1, 4, 0, 0, 10),
(42, 1, 5, 0, 0, 2),
(43, 9, 3, 0, 0, 0),
(44, 9, 4, 0, 0, 0),
(45, 9, 5, 0, 0, 0),
(46, 14, 3, 0, 0, 0),
(47, 14, 4, 0, 0, 0),
(48, 14, 5, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `store`
--

CREATE TABLE IF NOT EXISTS `store` (
  `store_id` int(11) NOT NULL AUTO_INCREMENT,
  `store_name` varchar(50) NOT NULL,
  `location` varchar(255) NOT NULL,
  `useinreorder` int(1) NOT NULL DEFAULT '0',
  `includeingeneral` int(1) NOT NULL DEFAULT '0',
  `indicatemainstore` int(1) NOT NULL DEFAULT '0',
  `retailoutlet` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`store_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `store`
--

INSERT INTO `store` (`store_id`, `store_name`, `location`, `useinreorder`, `includeingeneral`, `indicatemainstore`, `retailoutlet`) VALUES
(1, 'Store 1', 'Jos', 1, 1, 0, 1),
(2, 'Store 2', 'Lagos', 0, 1, 1, 0),
(3, 'Store 3', 'Abuja', 1, 0, 1, 1),
(4, 'Store 4', 'Nasarawa', 1, 1, 1, 0),
(5, 'Store 5', 'Kogi', 1, 1, 0, 1),
(9, 'store 14', '', 0, 0, 0, 0),
(10, 'store 20', '', 0, 0, 0, 1),
(11, 'store 11', '', 0, 0, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `store_test`
--

CREATE TABLE IF NOT EXISTS `store_test` (
  `store_id` int(11) NOT NULL AUTO_INCREMENT,
  `store_name` int(11) NOT NULL,
  PRIMARY KEY (`store_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE IF NOT EXISTS `supplier` (
  `supplier_id` int(4) NOT NULL AUTO_INCREMENT,
  `supplier_name` varchar(255) NOT NULL,
  `supplier_email` varchar(255) DEFAULT NULL,
  `supplier_phone` varchar(255) NOT NULL,
  `supplier_address` varchar(255) NOT NULL,
  `supplier_city` varchar(50) DEFAULT NULL,
  `supplier_state` varchar(50) DEFAULT NULL,
  `supplier_country` varchar(50) DEFAULT NULL,
  `dateregistered` date NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`supplier_id`),
  UNIQUE KEY `supplier_id` (`supplier_id`),
  KEY `fk_username` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`supplier_id`, `supplier_name`, `supplier_email`, `supplier_phone`, `supplier_address`, `supplier_city`, `supplier_state`, `supplier_country`, `dateregistered`, `user_id`) VALUES
(4, 'Mutiu', 'freejeomi@yahoo.com', '07039690487', 'dffdfdf', 'dfdfdf', 'ddddde', 'Nigeria', '2016-02-22', 26),
(5, 'Charles', 'errdr@yahoo.com', '08096768676', 'gdgdg', 'gdgdgd', 'gdgdg', 'Andorra', '2016-02-22', 26),
(8, 'Bassey', '', '07089576773', 'freeggdg', 'gdgdgdgd', 'dgdgdgd', 'Andorra', '2016-02-22', 26),
(10, 'Victoria', 'charles@yahoo.com', '0807969695', 'fefef', 'fefdf', 'fefe', 'Nigeria', '2016-02-22', 29),
(11, 'Eloho', '1234@234.com', '123456789', 'abcd efg hijk', 'werty', 'lagos', 'Nigeria', '2016-02-22', 29),
(12, 'Ijeoma', 'hjvhghkjkl', '987654356789', 'ljfgdgh ugfodgodb dghvdnej', 'lagos', 'lagos', 'Nigeria', '2016-02-22', 26);

-- --------------------------------------------------------

--
-- Table structure for table `supplier_account`
--

CREATE TABLE IF NOT EXISTS `supplier_account` (
  `suppliertrans_Id` int(11) NOT NULL AUTO_INCREMENT,
  `amount` double(16,2) NOT NULL DEFAULT '0.00',
  `payment_date` date NOT NULL,
  `payment_time` time NOT NULL,
  `payment_type` varchar(50) NOT NULL,
  `transaction_type` varchar(100) NOT NULL,
  `ref` varchar(50) NOT NULL,
  `remark` varchar(255) DEFAULT NULL,
  `supplier_Id` int(11) NOT NULL,
  `user_Id` int(11) NOT NULL,
  PRIMARY KEY (`suppliertrans_Id`),
  KEY `fk_supplierId` (`supplier_Id`),
  KEY `fk_usernameId` (`user_Id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=32 ;

--
-- Dumping data for table `supplier_account`
--

INSERT INTO `supplier_account` (`suppliertrans_Id`, `amount`, `payment_date`, `payment_time`, `payment_type`, `transaction_type`, `ref`, `remark`, `supplier_Id`, `user_Id`) VALUES
(1, 32430.00, '2016-01-26', '02:09:09', 'delivery', 'supplier payment', '353423', '2vc', 4, 26),
(2, 56780.00, '2016-01-26', '02:12:35', 'payment', 'supplier_payment', '13243', 'vcf', 5, 26),
(5, 10000.00, '2016-01-27', '02:09:09', 'payment', 'supplier payment', '123411', 'hello ', 4, 28),
(6, 29000.00, '2016-01-27', '02:12:35', 'delivery', 'supplier payment', '2324333', 'bkoj hnk', 4, 28),
(8, 57689.00, '2016-01-27', '01:22:27', 'delivery', 'supplier payment', '58787', '												\n											', 4, 26),
(9, 7890.00, '2016-01-27', '01:25:06', 'delivery', 'supplier payment', 'fghjkl', '												\n											', 4, 26),
(10, 7890.00, '2016-01-27', '01:29:02', 'payment', 'supplier payment', 'fghjkl', '												\n											', 4, 26),
(11, 6890.00, '2016-01-27', '01:33:57', 'payment', 'supplier payment', 'tf9876', '												\n											', 4, 26),
(12, -10000.00, '2016-01-28', '03:18:22', 'delivery', 'supplier payment', '12345', 'just trying it out											\n											', 4, 26),
(13, -10000.00, '2016-01-28', '03:18:56', 'delivery', 'supplier payment', '12345', 'just trying it out											\n											', 4, 26),
(14, -10000.00, '2016-01-28', '03:18:59', 'delivery', 'supplier payment', '12345', 'just trying it out											\n											', 4, 26),
(15, -20000.00, '2016-01-28', '03:20:47', 'delivery', 'supplier payment', '2334', 'dgff kfkk k												\n											', 4, 26),
(16, 56000.00, '2016-01-28', '03:22:36', 'delivery', 'supplier payment', '435465', '												\n											', 4, 26),
(17, -200000.00, '2016-01-28', '03:24:44', 'delivery', 'supplier payment', '435645', '												\n											', 4, 26),
(18, -4455866.00, '2016-01-28', '03:26:36', 'delivery', 'supplier payment', '677888', '												\n											', 4, 26),
(19, -34000.00, '2016-01-28', '03:29:18', 'delivery', 'supplier payment', '657796', '												\n											', 4, 26),
(20, 43564.00, '2016-01-28', '03:30:54', 'delivery', 'supplier payment', '54646', '												\n											', 4, 26),
(21, -1209390.00, '2016-01-28', '03:33:36', 'delivery', 'supplier payment', '54544', '												\n											', 4, 26),
(22, -465789.00, '2016-01-28', '03:34:35', 'delivery', 'supplier payment', '567890', '												\n											', 4, 26),
(23, -78000.00, '2016-01-28', '04:11:29', 'delivery', 'supplier payment', '765', '												\n											', 5, 26),
(24, -879000.00, '2016-01-28', '04:13:52', 'delivery', 'supplier payment', '987654', '												\n											', 5, 26),
(25, -56789.00, '2016-01-28', '04:14:32', 'delivery', 'supplier payment', '5467', '												\n											', 4, 26),
(26, -576700.00, '2016-01-28', '04:15:28', 'delivery', 'supplier payment', '9876776', '												\n											', 4, 26),
(27, -56000.00, '2016-01-28', '04:16:33', 'delivery', 'supplier payment', '8765', '												\n											', 4, 26),
(28, 450000.00, '2016-01-29', '09:40:49', 'payment', 'supplier payment', '1234567', '												\n											', 4, 26),
(29, -23000.00, '2016-01-29', '09:41:44', 'delivery', 'supplier payment', '353454', '												\n											', 4, 26),
(30, 569033.00, '2016-01-29', '09:49:07', 'payment', 'supplier payment', '46757', '												\n											', 4, 26),
(31, -340000.00, '2016-01-29', '09:57:08', 'delivery', 'supplier payment', '235688', '												\n											', 5, 26);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(3) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `role_id` int(11) NOT NULL,
  `active` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `user_id` (`user_id`),
  KEY `FK_users` (`role_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=35 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `role_id`, `active`) VALUES
(26, 'admin', '21232f297a57a5a743894a0e4a801fc3', 13, 1),
(28, 'manager', '1d0258c2440a8d19e716292b231e3190', 15, 0),
(29, 'operator', '4b583376b2767b923c3e1da60d10de59', 14, 1),
(30, 'invoice_tracker', 'cee0fe0c963fa7c07967acf9defaceb1', 16, 0),
(31, 'invoice_confirmer', 'a8ed8437c46f1672fd55bba00473ff0b', 17, 0),
(33, 'bad_guy', '5eb660f8d6c70bd816988d004fddb6b0', 13, 1),
(34, 'superadmin', '7d3bbfcb3215260c0430a0c0bd8fd0fa', 13, 1);

-- --------------------------------------------------------

--
-- Table structure for table `vehicle`
--

CREATE TABLE IF NOT EXISTS `vehicle` (
  `vehicle_id` int(11) NOT NULL AUTO_INCREMENT,
  `vehicle_number` varchar(20) NOT NULL,
  `vehicle_name` varchar(50) NOT NULL,
  `balance` double(16,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`vehicle_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `vehicle`
--

INSERT INTO `vehicle` (`vehicle_id`, `vehicle_number`, `vehicle_name`, `balance`) VALUES
(1, '123456', 'toyota bus', 23440.00),
(2, '23546', 'benz', 768900.00);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cashstock`
--
ALTER TABLE `cashstock`
  ADD CONSTRAINT `fk_user_name` FOREIGN KEY (`user_Id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `customer_transaction`
--
ALTER TABLE `customer_transaction`
  ADD CONSTRAINT `fkcusId` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`customer_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fkusername` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `invoiceitems_daily`
--
ALTER TABLE `invoiceitems_daily`
  ADD CONSTRAINT `fk_stock_id_` FOREIGN KEY (`stock_id`) REFERENCES `stock` (`stock_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `promoaccount`
--
ALTER TABLE `promoaccount`
  ADD CONSTRAINT `fk_item_id` FOREIGN KEY (`item_id`) REFERENCES `invoiceitems_daily` (`item_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_promoid` FOREIGN KEY (`promo_id`) REFERENCES `promo` (`promo_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `stock`
--
ALTER TABLE `stock`
  ADD CONSTRAINT `fk_category` FOREIGN KEY (`category_id`) REFERENCES `category` (`category_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_supplier` FOREIGN KEY (`supplier_id`) REFERENCES `supplier` (`supplier_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `stockledger`
--
ALTER TABLE `stockledger`
  ADD CONSTRAINT `fkuserid_ledger` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_stockid_ledger` FOREIGN KEY (`stock_id`) REFERENCES `stock` (`stock_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_storeidledger2` FOREIGN KEY (`store_id`) REFERENCES `store` (`store_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `stockposition`
--
ALTER TABLE `stockposition`
  ADD CONSTRAINT `fk_stock` FOREIGN KEY (`stock_id`) REFERENCES `stock` (`stock_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_storeid` FOREIGN KEY (`store_id`) REFERENCES `store` (`store_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `supplier`
--
ALTER TABLE `supplier`
  ADD CONSTRAINT `fk_username` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `supplier_account`
--
ALTER TABLE `supplier_account`
  ADD CONSTRAINT `fk_supplierId` FOREIGN KEY (`supplier_Id`) REFERENCES `supplier` (`supplier_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_usernameId` FOREIGN KEY (`user_Id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
