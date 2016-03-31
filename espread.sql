-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 16, 2016 at 10:22 AM
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `cashier`
--

CREATE TABLE IF NOT EXISTS `cashier` (
  `cashier_id` int(3) NOT NULL AUTO_INCREMENT,
  `cashier_name` varchar(50) NOT NULL,
  PRIMARY KEY (`cashier_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`category_id`, `category_name`, `cat_code`) VALUES
(1, 'MILK', 'MLK'),
(2, 'NOODLES', 'NDL'),
(3, 'SUGAR', 'SUG'),
(4, 'BEVERAGE', 'BVG'),
(5, 'JUICE', 'JUI'),
(6, 'SPAGHETTI', 'SPG');

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
  `email` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`customer_id`),
  UNIQUE KEY `customer_id` (`customer_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`customer_id`, `customer_name`, `customer_type`, `phone`, `email`) VALUES
(1, 'GENERAL', 'NORMAL', '', NULL),
(2, 'Mr Mike Chandler', 'CREDIT', '8172314323', NULL),
(3, 'Oseni Yusuf', 'CREDIT', '8173314323', NULL),
(4, 'Magdalene Chinda', 'CREDIT', '8174314323', NULL),
(5, 'Kelechi Emekalam', 'CREDIT', '8175314323', NULL),
(6, 'Ayotunde Adeyemi', 'CREDIT', '8176314323', NULL),
(7, 'Alhassan Mohammed', 'CREDIT', '8177314323', NULL),
(8, 'Nasiru Negedu', 'CREDIT', '8178314323', NULL),
(9, 'Nsikan Effiong', 'CREDIT', '8179314323', NULL),
(10, 'Jude Obiakor', 'CREDIT', '8179914323', NULL),
(11, 'Sales Man Jack', 'SALESREP', '8178814323', NULL);

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `openingbalance`
--

CREATE TABLE IF NOT EXISTS `openingbalance` (
  `openingbal_id` int(11) NOT NULL AUTO_INCREMENT,
  `amount` double(16,2) NOT NULL DEFAULT '0.00',
  `date` date NOT NULL,
  PRIMARY KEY (`openingbal_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`role_id`, `role_name`, `menu_invoice`, `menu_supplier`, `menu_customer`, `menu_cashstock`, `menu_stock`, `menu_haulage`, `menu_setup`, `menu_report`, `acceptcustomerpayment`, `raisecreditinvoice`) VALUES
(1, 'admin', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE IF NOT EXISTS `settings` (
  `company_name` varchar(255) NOT NULL,
  `company_address` varchar(255) NOT NULL,
  `company_phone` varchar(50) NOT NULL,
  `company_phone2` varchar(50) DEFAULT NULL,
  `company_email` varchar(50) NOT NULL,
  `accounting_year_start` date NOT NULL,
  `accounting_year_end` date NOT NULL,
  `retail_store` varchar(100) NOT NULL,
  `upload_url` varchar(255) NOT NULL,
  `check_` int(11) NOT NULL DEFAULT '1',
  `company_id` int(11) NOT NULL DEFAULT '0',
  `ftp_server_name` varchar(255) NOT NULL,
  `ftp_server_user` varchar(255) NOT NULL,
  `ftp_server_password` varchar(255) NOT NULL,
  `sms_username` varchar(255) NOT NULL,
  `sms_password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=22 ;

--
-- Dumping data for table `stock`
--

INSERT INTO `stock` (`stock_id`, `stock_code`, `stock_name`, `costprice`, `sales_person_price`, `high_purchase`, `low_purchase`, `slab`, `sprice`, `block`, `reorder_level`, `supplier_id`, `category_id`) VALUES
(1, 'MLK-001', 'PEAK SMALL', 12000.00, 12100.00, 12075.00, 12150.00, 10, 0.00, 1, 100, 16, 1),
(2, 'MLK-002', 'PEAK BIG', 23500.00, 23700.00, 23600.00, 23850.00, 15, 0.00, 0, 100, 1, 1),
(3, 'MLK-003', 'COWBELL SMALL', 11000.00, 11100.00, 11075.00, 11200.00, 10, 0.00, 0, 100, 2, 1),
(4, 'MLK-004', 'COWBELL BIG', 21500.00, 21700.00, 21600.00, 21850.00, 15, 0.00, 0, 100, 2, 1),
(5, 'MLK-005', 'COAST BIG', 24500.00, 24700.00, 24600.00, 24850.00, 15, 0.00, 0, 100, 3, 1),
(6, 'NDL-001', 'INDOMIE', 3500.00, 3700.00, 3600.00, 3800.00, 20, 0.00, 0, 500, 4, 2),
(7, 'NDL-002', 'O NOODLES', 3200.00, 3400.00, 3300.00, 3500.00, 20, 0.00, 0, 200, 5, 2),
(8, 'SGR-001', 'DANGOTE SUGAR', 9500.00, 9700.00, 9500.00, 9850.00, 15, 0.00, 0, 500, 6, 3),
(9, 'SGR-002', 'STLOUIS', 11500.00, 11700.00, 11600.00, 11800.00, 15, 0.00, 0, 300, 7, 3),
(10, 'BVG-001', 'MILO SMALL', 8000.00, 8200.00, 8150.00, 8300.00, 10, 0.00, 0, 300, 5, 4),
(11, 'BVG-002', 'MILO BIG', 15500.00, 15700.00, 15600.00, 15900.00, 10, 0.00, 0, 200, 5, 4),
(12, 'BVG-003', 'BOURNVITA SMALL', 7000.00, 7200.00, 7150.00, 7300.00, 10, 0.00, 0, 300, 8, 4),
(13, 'BVG-004', 'BOURNVITA BIG', 14500.00, 14700.00, 14600.00, 14900.00, 10, 0.00, 0, 200, 8, 4),
(14, 'BVG-005', 'OVALTINE SMALL', 10000.00, 10200.00, 10150.00, 10300.00, 10, 0.00, 0, 300, 9, 4),
(15, 'BVG-006', 'OVALTINE BIG', 16500.00, 16700.00, 16600.00, 16900.00, 10, 0.00, 0, 200, 9, 4),
(16, 'JUI-001', 'CHIVITA', 2200.00, 2400.00, 2350.00, 2450.00, 10, 0.00, 0, 200, 10, 5),
(17, 'JUI-002', 'FUMAN', 2200.00, 2400.00, 2350.00, 2450.00, 10, 0.00, 0, 200, 11, 5),
(18, 'JUI-003', 'CERES', 2500.00, 2700.00, 2550.00, 2850.00, 10, 0.00, 0, 200, 12, 5),
(19, 'SPG-001', 'DANGOTE SPAGHETTI', 15000.00, 15200.00, 15100.00, 15400.00, 10, 0.00, 0, 100, 6, 6),
(20, 'SPG-002', 'GOLDEN PENNY SPAGHETTI', 17000.00, 17200.00, 17100.00, 17400.00, 10, 0.00, 0, 100, 13, 6),
(21, 'JUI-004', 'CHI SMALL', 4.00, 0.00, 5.00, 4.00, 10, 0.00, 0, 100, 10, 5);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `stockposition`
--

CREATE TABLE IF NOT EXISTS `stockposition` (
  `stockposition_id` int(3) NOT NULL AUTO_INCREMENT,
  `stock_id` bigint(20) NOT NULL,
  `store_id` int(11) NOT NULL,
  `stock_count` bigint(20) NOT NULL,
  `unit` bigint(20) NOT NULL DEFAULT '0',
  `reorder_level_store` bigint(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`stock_id`,`store_id`),
  UNIQUE KEY `stockposition_id` (`stockposition_id`),
  KEY `fk_stock` (`stock_id`),
  KEY `fk_storeid` (`store_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=40 ;

--
-- Dumping data for table `stockposition`
--

INSERT INTO `stockposition` (`stockposition_id`, `stock_id`, `store_id`, `stock_count`, `unit`, `reorder_level_store`) VALUES
(1, 1, 1, 792, 0, 100),
(2, 2, 1, 1696, 0, 100),
(21, 2, 2, 20000, 0, 100),
(3, 3, 1, 406, 0, 100),
(22, 3, 2, 4988, 0, 100),
(4, 4, 1, 5, 0, 100),
(23, 4, 2, 1000, 0, 100),
(5, 5, 1, 1105, 0, 100),
(24, 5, 2, 10706, 0, 100),
(6, 6, 1, 3046, 0, 500),
(25, 6, 2, 30182, 0, 500),
(7, 7, 1, 1414, 0, 200),
(26, 7, 2, 10427, 0, 200),
(8, 8, 1, 4966, 0, 500),
(27, 8, 2, 49978, 0, 500),
(9, 9, 1, 17, 0, 300),
(28, 9, 2, 7977, 0, 300),
(10, 10, 1, 12300, 0, 300),
(29, 10, 2, 20300, 0, 300),
(11, 11, 1, 4978, 0, 200),
(30, 11, 2, 34978, 0, 200),
(12, 12, 1, 670, 0, 300),
(31, 12, 2, 1658, 0, 300),
(13, 13, 1, 600, 0, 200),
(32, 13, 2, 6788, 0, 200),
(14, 14, 1, 1340, 0, 300),
(33, 14, 2, 11340, 0, 300),
(15, 15, 1, 50, 0, 200),
(34, 15, 2, 7950, 0, 200),
(16, 16, 1, 2458, 0, 200),
(35, 16, 2, 20478, 0, 200),
(17, 17, 1, 1700, 0, 200),
(36, 17, 2, 10657, 0, 200),
(18, 18, 1, 23567890, 0, 200),
(37, 18, 2, 10100, 0, 200),
(19, 19, 1, 8800, 0, 100),
(38, 19, 2, 80756, 0, 100),
(20, 20, 1, 6500, 0, 100),
(39, 20, 2, 60500, 0, 100);

-- --------------------------------------------------------

--
-- Table structure for table `store`
--

CREATE TABLE IF NOT EXISTS `store` (
  `store_id` int(11) NOT NULL AUTO_INCREMENT,
  `store_name` varchar(50) NOT NULL,
  `location` varchar(255) DEFAULT NULL,
  `useinreorder` int(1) NOT NULL DEFAULT '0',
  `includeingeneral` int(1) NOT NULL DEFAULT '0',
  `indicatemainstore` int(1) NOT NULL DEFAULT '0',
  `retailoutlet` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`store_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `store`
--

INSERT INTO `store` (`store_id`, `store_name`, `location`, `useinreorder`, `includeingeneral`, `indicatemainstore`, `retailoutlet`) VALUES
(1, 'Main', '', 1, 0, 0, 1),
(2, 'Trans', '', 1, 0, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE IF NOT EXISTS `supplier` (
  `supplier_id` int(4) NOT NULL AUTO_INCREMENT,
  `supplier_name` varchar(255) NOT NULL,
  `supplier_email` varchar(255) DEFAULT NULL,
  `supplier_phone` varchar(255) DEFAULT NULL,
  `supplier_address` varchar(255) DEFAULT NULL,
  `supplier_city` varchar(50) DEFAULT NULL,
  `supplier_state` varchar(50) DEFAULT NULL,
  `supplier_country` varchar(50) DEFAULT NULL,
  `dateregistered` date NOT NULL DEFAULT '0000-00-00',
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`supplier_id`),
  UNIQUE KEY `supplier_id` (`supplier_id`),
  KEY `fk_username` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`supplier_id`, `supplier_name`, `supplier_email`, `supplier_phone`, `supplier_address`, `supplier_city`, `supplier_state`, `supplier_country`, `dateregistered`, `user_id`) VALUES
(1, 'FRIESLAND', NULL, NULL, NULL, NULL, NULL, NULL, '0000-00-00', 1),
(2, 'PROMASIDOR', NULL, NULL, NULL, NULL, NULL, NULL, '0000-00-00', 1),
(3, 'CASTOR', NULL, NULL, NULL, NULL, NULL, NULL, '0000-00-00', 1),
(4, 'DUFIL PRIMA FOODS', NULL, NULL, NULL, NULL, NULL, NULL, '0000-00-00', 1),
(5, 'NESTLE', NULL, NULL, NULL, NULL, NULL, NULL, '0000-00-00', 1),
(6, 'DANGOTE', NULL, NULL, NULL, NULL, NULL, NULL, '0000-00-00', 1),
(7, 'MAKANTILE', NULL, NULL, NULL, NULL, NULL, NULL, '0000-00-00', 1),
(8, 'CADBURY', NULL, NULL, NULL, NULL, NULL, NULL, '0000-00-00', 1),
(9, 'CABLINA', NULL, NULL, NULL, NULL, NULL, NULL, '0000-00-00', 1),
(10, 'CHI FOODS', NULL, NULL, NULL, NULL, NULL, NULL, '0000-00-00', 1),
(11, 'FUMAN', NULL, NULL, NULL, NULL, NULL, NULL, '0000-00-00', 1),
(12, 'CERES', NULL, NULL, NULL, NULL, NULL, NULL, '0000-00-00', 1),
(13, 'GOLDEN PENNY', NULL, NULL, NULL, NULL, NULL, NULL, '0000-00-00', 1),
(14, 'Honeywell Group', 'info@honeywellgroup.com', '08188373898', '6B Mekunwen Road , Off Oyinkan Abayomi Drive, Ikoyi , Lagos , Nigeria.', 'Lagos', 'Lagos', 'Nigeria', '2016-03-10', 1),
(16, 'Friesland', 'Friesland@yahoo.com', '08188373898', '6B Mekunwen Road , Off Oyinkan Abayomi Drive, Ikoyi , Lagos , Nigeria.', 'Lagos', 'Lagos', 'Nigeria', '2016-03-10', 1),
(17, 'Vijumilk company', 'viju@company', '08188373898', '23, Abeokuta way, Ogun state', 'Lagos', 'Lagos', 'Nigeria', '2016-03-10', 1),
(18, 'VIJUMILK', 'Methyl2007@yahoo.com', '234-3442567', '20 broad way road lagos', 'Lagos', 'Lagos', 'Andorra', '2016-03-10', 1);

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `role_id`, `active`) VALUES
(1, 'superadmin', '7d3bbfcb3215260c0430a0c0bd8fd0fa', 1, 0);

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
  ADD CONSTRAINT `fk_inv_num` FOREIGN KEY (`invoice_num`) REFERENCES `salesinvoice_daily` (`invoice_num`) ON DELETE CASCADE ON UPDATE CASCADE,
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
