-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 18, 2022 at 12:55 PM
-- Server version: 10.4.20-MariaDB
-- PHP Version: 7.3.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ezbikerental`
--

-- --------------------------------------------------------

--
-- Table structure for table `lessor_bicycle`
--

CREATE TABLE `lessor_bicycle` (
  `lessor_id` int(11) NOT NULL,
  `bike_id` int(11) NOT NULL,
  `bike_name` varchar(45) NOT NULL,
  `bike_type` varchar(45) NOT NULL,
  `bike_brand` varchar(75) NOT NULL,
  `bike_img` varchar(150) NOT NULL,
  `bike_condition` varchar(45) NOT NULL,
  `date_uploaded` varchar(75) NOT NULL,
  `status` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `lessor_bicycle`
--

INSERT INTO `lessor_bicycle` (`lessor_id`, `bike_id`, `bike_name`, `bike_type`, `bike_brand`, `bike_img`, `bike_condition`, `date_uploaded`, `status`) VALUES
(1, 1, 'Émonda SLR 9', 'Mountain', 'TREK', 'bike-2.png', 'Good', 'November 23, 2021, 8:39 pm', 'active'),
(1, 2, 'TREK EMONDA SLR 6 ETAP', 'Mountain', 'TREK', 'bike-3.png', '420', 'November 23, 2021, 8:42 pm', 'active'),
(1, 3, 'WILIER 0 SLR DURA-ACE DI2', 'Road', 'WILIER', 'bike-4.png', 'Good', 'November 23, 2021, 8:43 pm', 'active'),
(1, 4, 'WILIER 0 SLR DURA-ACE DI2', 'Road', 'WILIER', 'bike-5.png', 'Slightly Scratched', 'November 23, 2021, 8:45 pm', 'active'),
(1, 5, 'WILIER JENA RIVAL XPLR ETAP AXS', 'Road', 'WILIER', 'bike-6.png', 'Brand New', 'November 23, 2021, 8:58 pm', 'active'),
(2, 6, 'WILIER JENA RIVAL XPLR ETAP AXS', 'Road', 'WILIER', 'orbea.png', 'Brand New', 'November 23, 2021, 9:02 pm', 'active'),
(2, 7, 'GIANT TCR ADVANCED 1 DISC KOM 2021', 'Road', 'GIANT', 'bike-18.png', 'No Scatch', 'November 23, 2021, 9:03 pm', 'active'),
(7, 8, 'GIANT ESCAPE 2 CITY DISC 2021', 'Road', 'GIANT', 'bike-18.png', 'Good', 'November 23, 2021, 9:33 pm', 'active'),
(7, 9, 'GIANT XTC ADVANCED 29 2 2021', 'Mountain', 'GIANT', 'bike-49.png', 'Brand New', 'November 23, 2021, 9:35 pm', 'in-used'),
(7, 10, 'GIANT XTC ADVANCED 29 2 2021', 'Mountain', 'GIANT', 'bike-49.png', 'Brand New', 'November 23, 2021, 9:35 pm', 'active'),
(4, 11, 'Émonda SLR 9', 'Mountain', 'TREK', 'bike-2.png', 'Brand New', 'November 23, 2021, 9:42 pm', 'booked'),
(4, 12, 'TREK EMONDA SLR 6 ETAP', 'Mountain', 'TREK', 'bike-3.png', 'Brand New', 'November 23, 2021, 9:44 pm', 'booked'),
(4, 13, 'WILIER 0 SLR DURA-ACE DI2', 'Road', 'WILIER', 'bike-4.png', 'Brand New', 'November 23, 2021, 9:46 pm', 'active'),
(4, 14, 'WILIER 0 SLR DURA-ACE DI2', 'Road', 'WILIER', 'bike-5.png', 'Brand New', 'November 23, 2021, 9:49 pm', 'booked'),
(4, 15, 'WILIER JENA RIVAL XPLR ETAP AXS', 'Road', 'WILIER', 'bike-6.png', 'Brand New', 'November 23, 2021, 9:50 pm', 'active'),
(5, 16, 'WILIER JENA RIVAL XPLR ETAP AXS', 'Road', 'WILIER', 'bike-7.png', 'Brand New', 'November 23, 2021, 9:53 pm', 'active'),
(5, 17, 'WILIER FILANTE SLR DURA-ACE DI2', 'Road', 'WILIER', 'bike-8.png', 'Brand New', 'November 23, 2021, 9:53 pm', 'active'),
(5, 18, 'PARLEE CHEBACCO XD GRX 815 DI2', 'Road', 'PARLEE', 'bike-9.png', 'Brand New', 'November 23, 2021, 9:55 pm', 'active'),
(5, 19, 'GIANT ESCAPE DISC 2 2022', 'Road', 'GIANT', 'bike-10.png', 'Brand New', 'November 23, 2021, 9:56 pm', 'active'),
(5, 20, 'GIANT ESCAPE DISC 2 2021', 'Road', 'GIANT', 'bike-11.png', 'Brand New', 'November 23, 2021, 9:57 pm', 'booked'),
(9, 21, 'GIANT FATHOM 29 2 2021', 'Mountain', 'GIANT', 'bike-22.png', 'Good', 'November 23, 2021, 10:03 pm', 'booked'),
(15, 22, 'GIANT TCR ADVANCED 2 DISC PRO COMPACT 2022', 'Road', 'GIANT', 'bike-12.png', 'Brand New', 'November 23, 2021, 10:13 pm', 'active'),
(15, 23, 'GIANT TCR ADVANCED 2 DISC PRO COMPACT 2022', 'Road', 'GIANT', 'bike-13.png', 'Brand New', 'November 23, 2021, 10:14 pm', 'active'),
(15, 24, 'GIANT PROPEL ADVANCED 2 DISC 2021', 'Road', 'GIANT', 'bike-14.png', 'Brand New', 'November 23, 2021, 10:15 pm', 'active'),
(15, 25, 'GIANT PROPEL ADVANCED 2 DISC 2021', 'Road', 'GIANT', 'bike-15.png', 'Brand New', 'November 23, 2021, 10:16 pm', 'active'),
(15, 26, 'GIANT DEFY ADVANCED 1 2021', 'Road', 'GIANT', 'bike-16.png', 'Brand New', 'November 23, 2021, 10:17 pm', 'active'),
(16, 27, 'GIANT TALON 0 2021', 'Mountain', 'GIANT', 'bike-40.png', 'Excellent', 'November 23, 2021, 10:21 pm', 'active'),
(10, 28, 'STRADA TEAM EKAR 1X13', 'Road', 'STRADA', 'image_2021-11-23_222142.png', 'Brand New', 'November 23, 2021, 10:24 pm', 'active'),
(10, 29, 'EXPLORO RACE GRX 1X', 'Road', 'EXPLORO', 'image_2021-11-23_223021.png', 'Slightly Used', 'November 23, 2021, 10:33 pm', 'active'),
(13, 30, 'STRADA TEAM EKAR 1X13', 'Road', 'STRADA', 'strada-ekar-1x13-campagnolo-edition.jpg', 'brand new', 'November 23, 2021, 10:36 pm', 'booked'),
(10, 31, 'Exploro RaceMax', 'Mountain', 'EXPLORO', 'image_2021-11-23_224215.png', 'Brand New', 'November 23, 2021, 10:44 pm', 'active'),
(12, 32, 'Magna', 'Mountain', 'Dynacraft BSC', '59b5e97aNfb5f6e05.jpg', 'New', 'November 23, 2021, 10:53 pm', 'active'),
(10, 33, 'TCR ADVANCED 1+ DISC', 'Mountain', 'GIANT', 'image_2021-11-23_225347.png', 'Slightly Used', 'November 23, 2021, 10:56 pm', 'active'),
(1, 34, 'Bike 2', 'Mountain', 'GIANT', 'bike-6.png', 'Good', 'November 30, 2021, 12:52 pm', 'rejected'),
(1, 35, 'GIANT CONTEND 2 2021', 'Road', 'GIANT', 'bike-22.png', 'Good', 'December 3, 2021, 1:27 pm', 'active'),
(1, 36, 'GIANT ANTHEM 29 1 2021', 'Mountain', 'GIANT', 'bike-44.png', 'Brand New', 'December 3, 2021, 1:30 pm', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `lessor_bicyclecomponents`
--

CREATE TABLE `lessor_bicyclecomponents` (
  `lessor_id` int(11) NOT NULL,
  `bike_id` int(11) NOT NULL,
  `color` varchar(45) NOT NULL,
  `frame` varchar(75) NOT NULL,
  `front_suspension` varchar(100) NOT NULL DEFAULT 'none',
  `rear_derailleur` varchar(100) NOT NULL DEFAULT 'none',
  `brake_levers` varchar(100) NOT NULL DEFAULT 'none',
  `brake_set` varchar(100) NOT NULL DEFAULT 'none',
  `crankset` varchar(100) NOT NULL DEFAULT 'none',
  `cassette` varchar(100) NOT NULL DEFAULT 'none',
  `wheelset` varchar(100) NOT NULL DEFAULT 'none'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `lessor_bicyclecomponents`
--

INSERT INTO `lessor_bicyclecomponents` (`lessor_id`, `bike_id`, `color`, `frame`, `front_suspension`, `rear_derailleur`, `brake_levers`, `brake_set`, `crankset`, `cassette`, `wheelset`) VALUES
(1, 1, 'black', 'Trek Émonda SLR 9 eTap', 'Sram Red eTap AXS', 'Sram Red eTap AXS', 'Sram Red eTap AXS', 'Sram Red eTap AXS', 'Sram Red eTap AXS', 'Sram Red eTap AXS', 'Bontrager Aeolus RSL 37, Bontrager R4 25mm tyres'),
(1, 2, 'red', 'Ultralight 800 Series OCLV Carbon, Ride Tuned performance tube optimisation', 'SRAM Rival eTap AXS, braze-on', 'SRAM Rival eTap AXS', 'Sram Red eTap AXS', 'SRAM Paceline, rounded, CenterLock, 160 mm', 'SRAM Rival AXS Power Meter, 48/35, DUB spindle', 'SRAM XG-1250, 10-36, 12-speed', 'Bontrager Aeolus Pro 37, OCLV Carbon, Tubeless Ready, 37 mm rim depth, 100x12 mm thru axle, Bontrage'),
(1, 3, 'orange', 'WILIER 0 SLR - CARBON MONOCOQUE HUS MOD + CRYSTAL LIQUID POLYMER', 'SHIMANO DURA ACE FD-R9250 DI2', 'SHIMANO DURA ACE RD-R9250 DI2', 'SHIMANO DURA ACE BR-R9270', 'SHIMANO DURA ACE BR-R9270', 'SHIMANO DURA ACE FC-R9200 50-34T', 'SHIMANO DURA ACE CS-R9200 12S 11-30T', 'VITTORIA CORSA SPEED 700x25'),
(1, 4, 'white', 'WILIER 0 SLR - CARBON MONOCOQUE HUS MOD + CRYSTAL LIQUID POLYMER', 'SHIMANO DURA ACE FD-R9250 DI2', 'SHIMANO DURA ACE FD-R9250 DI2', 'SHIMANO DURA ACE BR-R9270', 'SHIMANO DURA ACE BR-R9270', 'SHIMANO DURA ACE FC-R9200 50-34T', 'SHIMANO DURA ACE CS-R9200 12S 11-30T', 'VITTORIA CORSA SPEED 700x25'),
(1, 5, 'silver/gray', 'JENA - CARBON MONOCOQUE 60TON', 'SRAM RIVAL ETAP AXS D1 BRAZE', 'SRAM RIVAL XPLR ETAP AXS D1 MAX 44T', 'SRAM RIVAL ETAP AXS', 'SRAM RIVAL ETAP AXS', 'SRAM RIVAL 1 D1 DUB WIDE 40T', 'SRAM XG 1251 D1 XPLR 10-44T', 'VITTORIA TERRENO MIX 700 x 33C (33-622) RIGID BLK'),
(2, 6, 'black', 'JENA - CARBON MONOCOQUE 60TON', 'SRAM RIVAL ETAP AXS D1 BRAZE', 'SRAM RIVAL XPLR ETAP AXS D1 MAX 44T', 'SRAM RIVAL ETAP AXS', 'SRAM RIVAL ETAP AXS', 'SRAM RIVAL 1 D1 DUB WIDE 40T', 'SRAM XG 1251 D1 XPLR 10-44T', 'VITTORIA TERRENO MIX 700 x 33C (33-622) RIGID BLK'),
(2, 7, 'black', 'Advanced-Grade Composite, disc', 'Shimano Ultegra', 'Shimano Ultegra', 'Shimano Ultegra hydraulic', 'Shimano Ultegra hydraulic', 'Shimano Ultegra, 34/50', 'Shimano 105, 11x34', 'Giant PR-2 Disc wheelset, Giant Gavia Course 1, tubeless, 700x28mm (25c), folding'),
(7, 8, 'silver/gray', 'ALUXX-Grade Aluminum, disc', 'Shimano FD-TY710', 'Shimano Altus', 'Tektro', 'Tektro HD-R280', 'forged alloy, 30/46', 'Shimano CS-HG31, 11x34', 'Giant GX wheelset, Giant S-X2, puncture protect, 700x38c'),
(7, 9, 'blue', 'Advanced-Grade Composite', 'N/A', 'Shimano SLX', 'Shimano MT501', 'Shimano MT500', 'Shimano SLX, 32t', 'Shimano SLX, 10x51', 'Maxxis Recon Race 29x2.25, foldable, TLR, EXO, tubeless, Giant XCT 29” alloy'),
(7, 10, 'blue', 'Advanced-Grade Composite', 'N/A', 'Shimano SLX', 'Shimano MT501', 'Shimano MT500', 'Shimano SLX, 32t', 'Shimano SLX, 10x51', 'Maxxis Recon Race 29x2.25, foldable, TLR, EXO, tubeless, Giant XCT 29” alloy'),
(4, 11, 'silver/gray', 'Trek Émonda SLR 9 eTap', 'Sram Red eTap AXS', 'Sram Red eTap AXS', 'Sram Red eTap AXS', 'Sram Red eTap AXS', 'Sram Red eTap AXS', 'Sram Red eTap AXS', 'Bontrager Aeolus RSL 37, Bontrager R4 25mm tyres'),
(4, 12, 'red', 'Ultralight 800 Series OCLV Carbon, Ride Tuned performance tube optimisation', 'SRAM Rival eTap AXS, braze-on', 'SRAM Rival eTap AXS', 'Sram Red eTap AXS', 'SRAM Paceline, rounded, CenterLock, 160 mm', 'SRAM Rival AXS Power Meter, 48/35, DUB spindle', 'SRAM XG-1250, 10-36, 12-speed', 'Bontrager Aeolus Pro 37, OCLV Carbon, Tubeless Ready, 37 mm rim depth, 100x12 mm thru axle, Bontrage'),
(4, 13, 'orange', 'WILIER 0 SLR - CARBON MONOCOQUE HUS MOD + CRYSTAL LIQUID POLYMER', 'SHIMANO DURA ACE FD-R9250 DI2', 'SHIMANO DURA ACE RD-R9250 DI2', 'SHIMANO DURA ACE BR-R9270', 'SHIMANO DURA ACE BR-R9270', 'SHIMANO DURA ACE FC-R9200 50-34T', 'SHIMANO DURA ACE CS-R9200 12S 11-30T', 'VITTORIA CORSA SPEED 700x25'),
(4, 14, 'orange', 'WILIER 0 SLR - CARBON MONOCOQUE HUS MOD + CRYSTAL LIQUID POLYMER', 'SHIMANO DURA ACE FD-R9250 DI2', 'SHIMANO DURA ACE RD-R9250 DI2', 'SHIMANO DURA ACE BR-R9270', 'SHIMANO DURA ACE BR-R9270', 'SHIMANO DURA ACE FC-R9200 50-34T', 'SHIMANO DURA ACE CS-R9200 12S 11-30T', 'VITTORIA CORSA SPEED 700x25'),
(4, 15, 'silver/gray', 'JENA - CARBON MONOCOQUE 60TON', 'SRAM RIVAL ETAP AXS D1 BRAZE', 'SRAM RIVAL XPLR ETAP AXS D1 MAX 44T', 'SRAM RIVAL ETAP AXS', 'SRAM RIVAL ETAP AXS', 'SRAM RIVAL 1 D1 DUB WIDE 40T', 'SRAM XG 1251 D1 XPLR 10-44T', 'VITTORIA TERRENO MIX 700 x 33C (33-622) RIGID BLK'),
(5, 16, 'silver/gray', 'JENA - CARBON MONOCOQUE 60TON', 'SRAM RIVAL ETAP AXS D1 BRAZE', 'SRAM RIVAL XPLR ETAP AXS D1 MAX 44T', 'SRAM RIVAL ETAP AXS', 'SRAM RIVAL ETAP AXS', 'SRAM RIVAL 1 D1 DUB WIDE 40T', 'SRAM XG 1251 D1 XPLR 10-44T', 'VITTORIA TERRENO MIX 700 x 33C (33-622) RIGID BLK'),
(5, 17, 'red', 'FILANTE 0 SLR - CARBON MONOCOQUE HUS MOD + CRYSTAL LIQUID POLYMER', 'SHIMANO DURA ACE FD-R9250 DI2', 'SHIMANO DURA ACE RD-R9250 DI2', 'SHIMANO DURA ACE BR-R9270', 'SHIMANO DURA ACE BR-R9270', 'SHIMANO DURA ACE FC-R9200 50-34T', 'SHIMANO DURA ACE CS-R9200 12S 11-30T', 'VITTORIA CORSA SPEED 700x28'),
(5, 18, 'red', 'Shimano GRX 815 Di2 groupset, with electronic shifting', 'SHIMANO DURA ACE FD-R9250 DI2', 'SHIMANO DURA ACE RD-R9250 DI2', 'SHIMANO DURA ACE BR-R9270', 'Disc, flat mount front and rear, 140 or 160mm rotors, internally routed', 'SHIMANO DURA ACE FC-R9200 50-34T', 'SHIMANO DURA ACE CS-R9200 12S 11-30T', 'DT SWISS alloy 1800 wheelset'),
(5, 19, 'silver/gray', 'ALUXX-Grade Aluminum, disc', 'N/A', 'SHIMANO DURA ACE RD-R9250 DI2', 'Shimano', 'ektro HD-R280, Giant MPH rotors [F]160mm, [R]160mm', 'forged alloy, 30/46 XS:170mm, S:170mm, M:170mm, L:175mm, XL:175mm', 'Shimano CS-HG31, 11x34', 'Giant S-X2, puncture protect, 700x38c, Giant double wall aluminum'),
(5, 20, 'silver/gray', 'ALUXX-Grade Aluminum, disc', 'N/A', 'Shimano Altus', 'Tektro', 'Tektro HD-R280, Giant MPH rotors [F]160mm, [R]160mm', 'forged alloy, 30/46', 'Shimano CS-HG31, 11x34', 'Giant S-X2, puncture protect, 700x38c, Giant GX wheelset'),
(9, 21, 'black', 'ALUXX SL-Grade Aluminum', 'N/A', 'Shimano Deore', 'Tektro TKD143', 'Tektro TKD143', 'Praxis Cadet Boost, 30t', 'Shimano Deore', '[F] Maxxis Minion DHF, 29x2.5 WT, EXO/TR [R] Maxxis Aggressor, 29x2.5 WT, foldable, EXO/T, Giant AM '),
(15, 22, 'black', 'Advanced-Grade Composite, disc', 'N/A', 'Shimano 105', 'Shimano 105 hydraulic', 'Tektro Shimano 105 hydraulic, Giant MPH rotors [F]160mm, [R]140mm', 'Shimano 105, 36/52 XS:170mm, S:170mm, M:172.5mm, M/L:172.5mm, L:175mm, XL:175mm', 'Shimano 105, 11-speed, 11x30', 'Giant Course 1, tubeless, 700x25c (28mm), folding, Giant P-R2 Disc wheelset'),
(15, 23, 'black', 'Advanced-Grade Composite, disc', 'N/A', 'Shimano 105', 'Shimano 105 hydraulic', 'Tektro Shimano 105 hydraulic, Giant MPH rotors [F]160mm, [R]140mm', 'Shimano 105, 36/52 XS:170mm, S:170mm, M:172.5mm, M/L:172.5mm, L:175mm, XL:175mm', 'Shimano 105, 11-speed, 11x30', 'Giant Course 1, tubeless, 700x25c (28mm), folding, Giant P-R2 Disc wheelset'),
(15, 24, 'black', 'Advanced-Grade Composite, disc', 'N/A', 'Shimano 105', 'Shimano 105 hydraulic', 'Shimano 105 hydraulic', 'Shimano 105, 36/52', 'Shimano 105, 11x30', 'Giant Gavia Course AC 1, tubeless, 700x25c, folding, Giant P-A2 Disc wheelset'),
(15, 25, 'black', 'Advanced-Grade Composite, disc', 'N/A', 'Shimano 105', 'Shimano 105 hydraulic', 'Shimano 105 hydraulic', 'Shimano 105, 36/52', 'Shimano 105, 11x30', 'Giant Gavia Course AC 1, tubeless, 700x25c, folding, Giant P-A2 Disc wheelset'),
(15, 26, 'black', 'Advanced-Grade Composite, disc', 'N/A', 'Shimano Ultegra', 'Shimano Ultegra hydraulic', 'Shimano Ultegra hydraulic', 'Shimano FC-RS510, 34/50', 'Shimano Ultegra, 11x34', 'Giant Gavia Fondo 1, tubeless, 700x32c, folding, Giant P-R2 Disc wheelset'),
(16, 27, 'white', 'ALUXX-Grade Aluminum, disc', 'N/A', 'Shimano Deore', 'Tektro TKD143, hydraulic', 'Tektro TKD143, hydraulic', 'ProWheel MPX, 30t or 32t', 'Shimano Deore, 10x51', 'Giant GX03V 29 or 27.5, alloy, double wall, 21mm inner width, Maxxis Rekon 27.5x2.4, wire bead'),
(10, 28, 'black', 'Strada TEAM', '3T Fundi TEAM', 'Campagnolo EKAR 1x13', 'Campagnolo EKAR 1x13', 'Campagnolo EKAR hydraulic disc w/ 160mm Campagnolo rotor', 'Campagnolo EKAR carbon, 40T chainring (to match 9T smallest cog) (XS: 165mm - S: 170mm - M: 172,5mm ', 'Campagnolo EKAR 13-speed, 9-36T', 'Campagnolo Shamal Carbon, 700c, 21mm internal width, tubeless-ready (no tape required)'),
(10, 29, 'orange', 'Exploro RaceMax', 'Fango RaceMax w/ compact crown', 'Shimano GRX - long cage mechanical (RX-812)', 'Shimano GRX', 'Shimano GRX, 40T chainring (XXS: 165mm - 51: 170mm - 54&amp;56: 172,5mm - 58&amp;61: 175mm)', 'Shimano GRX, 40T chainring (XXS: 165mm - 51: 170mm - 54&amp;56: 172,5mm - 58&amp;61: 175mm)', '11-speed Powerglide, 11-42T', 'WTB Serra, 700c, tubeless ready or Fulcrum Racing 700 700c'),
(13, 30, 'black', 'Strada TEAM', '3T Fundi TEAM', 'Campagnolo EKAR 1x13', 'Campagnolo EKAR 1x13', 'Campagnolo EKAR hydraulic disc w/ 160mm Campagnolo rotor', 'Campagnolo EKAR carbon, 40T chainring (to match 9T smallest cog) (XS: 165mm - S: 170mm - M: 172,5mm ', 'Campagnolo EKAR 13-speed, 9-36T', 'Campagnolo Shamal Carbon, 700c, 21mm internal width, tubeless-ready (no tape required)'),
(10, 31, 'white', 'Exploro RaceMax', 'Fango RaceMax w/ compact crown', 'Sram Force AXS eTap WIDE', 'Sram Force AXS eTap', 'Sram Force AXS Hydraulic Disc w/ Sram 160mm rotor', 'Sram Force AXS, 46-33T chainrings, narrow Q-factor (XXS: 165mm - 51: 170mm - 54&amp;56: 172,5mm - 58', '12-speed Force AXS, 10-36T', 'Fulcrum Rapid Red 900 700c'),
(12, 32, 'black', 'High Tensile Steel', 'Hossack suspension', 'Microshift', 'Alloy Diameter 22mm', 'Alloy Front Brake', '3 Piece Alloy', '23', 'Zipp 303S Carbon Tubeless Disc'),
(10, 33, 'black', 'Advanced-Grade Composite, disc', 'Advanced-Grade Composite, OverDrive steerer, disc', 'Shimano Ultegra', 'Shimano Ultegra hydraulic', 'Shimano Ultegra hydraulic', 'Shimano RS-510, 36/52', 'Shimano 105, 11x30', 'Giant Gavia Course 1, tubeless, 700x25mm (max tyre width possible: 32mm)'),
(1, 34, 'white', 'Shimando Models', 'Shimando Models', 'Shimando Models', 'Shimando Models', 'Shimando Models', 'Shimando Models', 'Shimando Models', 'Maxxis'),
(1, 35, 'black', 'ALUXX-Grade Aluminum', 'N/A', 'Shimano Claris', 'Shimano Claris', 'Tektro TK-B177', 'FSA Tempo, 34/50', 'CS-HG50-8, 11x34', 'Giant S-R3 wheelset, Giant S-R3 AC, 700x25c (28mm), folding'),
(1, 36, 'silver/gray', 'ALUXX SL-Grade Aluminum, 90mm Maestro suspension', 'Fox Float DPS Performance, 165/42.5, custom tuned for Giant', 'Shimano SLX', 'Shimano MT501', 'Shimano MT500', 'Shimano SLX, 32t', 'Shimano SLX, 10x51', '[F] Maxxis Recon Race 29x2.35, foldable, TLR, EXO, tubeless, [R] Maxxis Recon Race 29x2.25, foldable');

-- --------------------------------------------------------

--
-- Table structure for table `lessor_bicyclerate`
--

CREATE TABLE `lessor_bicyclerate` (
  `lessor_id` int(11) NOT NULL,
  `bike_id` int(11) NOT NULL,
  `bike_dayRate` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `lessor_bicyclerate`
--

INSERT INTO `lessor_bicyclerate` (`lessor_id`, `bike_id`, `bike_dayRate`) VALUES
(1, 1, 300),
(1, 2, 350),
(1, 3, 400),
(1, 4, 300),
(1, 5, 300),
(2, 6, 240),
(2, 7, 400),
(7, 8, 420),
(7, 9, 330),
(7, 10, 330),
(4, 11, 500),
(4, 12, 600),
(4, 13, 800),
(4, 14, 800),
(4, 15, 697),
(5, 16, 699),
(5, 17, 700),
(5, 18, 750),
(5, 19, 500),
(5, 20, 450),
(9, 21, 420),
(15, 22, 600),
(15, 23, 600),
(15, 24, 1000),
(15, 25, 1000),
(15, 26, 800),
(16, 27, 320),
(10, 28, 750),
(10, 29, 650),
(13, 30, 1000),
(10, 31, 535),
(12, 32, 60),
(10, 33, 625),
(1, 34, 200),
(1, 35, 330),
(1, 36, 350);

-- --------------------------------------------------------

--
-- Table structure for table `lessor_payment`
--

CREATE TABLE `lessor_payment` (
  `lessor_id` int(11) NOT NULL,
  `payment_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `bike_id` int(11) NOT NULL,
  `bike_description` varchar(45) NOT NULL,
  `bike_img` varchar(100) NOT NULL,
  `pickup_date` varchar(35) NOT NULL,
  `return_date` varchar(45) NOT NULL,
  `days` int(11) NOT NULL,
  `bike_rate` varchar(45) NOT NULL,
  `total_amt` int(11) NOT NULL,
  `date` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `lessor_payment`
--

INSERT INTO `lessor_payment` (`lessor_id`, `payment_id`, `user_id`, `bike_id`, `bike_description`, `bike_img`, `pickup_date`, `return_date`, `days`, `bike_rate`, `total_amt`, `date`) VALUES
(7, 1, 1, 9, 'GIANT XTC ADVANCED 29 2 2021', 'bike-49.png', '2022-01-18', '2022-01-20', 2, '330', 660, 'January 18, 2022, 4:39 pm');

-- --------------------------------------------------------

--
-- Table structure for table `tbladmin`
--

CREATE TABLE `tbladmin` (
  `admin_id` int(11) NOT NULL,
  `admin_username` varchar(45) NOT NULL,
  `admin_password` varchar(200) NOT NULL,
  `security_code` varchar(45) NOT NULL,
  `logged_in` varchar(45) NOT NULL,
  `date_created` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbladmin`
--

INSERT INTO `tbladmin` (`admin_id`, `admin_username`, `admin_password`, `security_code`, `logged_in`, `date_created`) VALUES
(1, 'esports_rocye', '$2y$10$ZDBkNGQyZWY3ZjNjYzBkN.V6xDtzVGtDt2MpkUb.tgge7HoFHp5mi', 'rbI97f', 'December 4, 2021, 10:41 am', 'September 28, 2021, 3:15 pm'),
(2, 'admin', '$2y$10$YmFlNTNhMzk5MWM3YjRmMOz.RUyEELF/9v9TSz2.sQPY7NEgHY8sC', 'Z18RVZ', 'November 19, 2021, 9:41 pm', 'September 28, 2021, 3:17 pm'),
(4, 'admin_lloyd', '$2y$10$MTQyZjdjNjJkYmRkNWYxNuX6X6Su99SdoPJzI57f4xSvYCTR1S/g2', 'TRRYC5', 'November 21, 2021, 12:01 am', 'November 19, 2021, 7:41 am'),
(5, 'admin_lloyd', '$2y$10$ZjMyMmRiNjA4MzkxYmJiZ.1YLLGc7wvKz7IlkiqHllvrqPxhhlqLC', '8IDWSP', '', 'November 23, 2021, 2:38 pm'),
(8, 'myadmin', '$2y$10$N2U4ZmQ4YTNlYTMyZGJmO.pB/B.M.WB9jPpt2LD5DxdvhjcpQ2gsS', 'CFMW8G', '', 'December 3, 2021, 7:03 pm');

-- --------------------------------------------------------

--
-- Table structure for table `tblbusiness`
--

CREATE TABLE `tblbusiness` (
  `lessor_id` int(11) NOT NULL,
  `Name` varchar(75) NOT NULL,
  `Banner` varchar(75) NOT NULL,
  `Address_Line1` varchar(50) NOT NULL,
  `Address_Line2` varchar(50) NOT NULL,
  `Region` varchar(100) NOT NULL,
  `Province` varchar(45) NOT NULL,
  `City` varchar(45) NOT NULL,
  `Barangay` varchar(45) NOT NULL,
  `Zip_Code` varchar(10) NOT NULL,
  `lat` float DEFAULT NULL,
  `lng` float DEFAULT NULL,
  `Date_Updated` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tblbusiness`
--

INSERT INTO `tblbusiness` (`lessor_id`, `Name`, `Banner`, `Address_Line1`, `Address_Line2`, `Region`, `Province`, `City`, `Barangay`, `Zip_Code`, `lat`, `lng`, `Date_Updated`) VALUES
(1, 'Gold Speed Bike Shop', 'goldspeed.jpg', '285 Manila S Rd', 'Tunasan', '04', '0434', '043403', '043403021', '4023', 14.3018, 121.071, 'November 23, 2021, 8:34 pm'),
(2, 'Royce Bicycle Store', 'pexels-adrien-olichon-2817452.jpg', '34 Aguinaldo St. Phase', 'Bahayang Pag-asa Subdivision', '04', '0421', '042103', '042103048', '4103', 14.3993, 120.974, 'November 23, 2021, 9:00 pm'),
(4, 'AJ\'s Bicycle Shop', 'IMG_8827.jpg', 'B4 L6 INDIA ST.', 'BARCELONA PH4', '04', '0421', '042109', '042109053', '4103', 14.4097, 120.951, 'November 23, 2021, 9:20 pm'),
(7, 'Gyrocycle Marketing', 'gyrocycle_marketing.jfif', '383 B', 'Molino Road', '04', '0421', '042103', '042103046', '4102', 14.3958, 120.978, 'November 23, 2021, 9:31 pm'),
(3, 'GeForce Bikes', 'geforce_bikes.jpeg', 'Brookeside Lane', '', '04', '0421', '042108', '042108023', '4107', 14.323, 120.913, 'November 23, 2021, 9:39 pm'),
(9, 'LJ Bike Shop', 'ljbikes.jfif', '437', 'Molino Rd,', '04', '0421', '042103', '042103042', '4102', 14.3971, 120.978, 'November 23, 2021, 10:01 pm'),
(10, 'Queen\'s Bike Shop', '239587280_400249374794872_3039273260598723521_n.jpg', 'Block 1 Lot 1 ABC Street', '', '04', '0421', '042106', '042106011', '4114', 14.3491, 120.981, 'November 23, 2021, 10:16 pm'),
(16, 'iGirl Bike Shop', 'iGirl.jpg', 'Phase 2, B1 L12 Ninoy Aquino Annex Street', 'Addas Greenfields, Molino Blvd,', '04', '0421', '042103', '042103045', '4102', 14.4118, 120.968, 'November 23, 2021, 10:18 pm'),
(13, 'RIDE ME ROR', 'CrossCountry_Cat_mq5_16x9.jpg', 'Zalavarria St.', 'Mariveles', '03', '0308', '030807', '030807009', '2105', 14.4364, 120.489, 'November 23, 2021, 10:21 pm'),
(15, 'Arat Ride Bike Shop', 'IMG_8827sgsg.jpg', 'B19 L21 LAKANDULA ST.', 'Cherry Homes Subdivision 1', '04', '0421', '042103', '042103013', '4102', 14.4193, 120.952, 'November 23, 2021, 10:21 pm'),
(5, 'My Little Bike Shop', 'images.jfif', 'BLK 18 LOT 4', 'BLK 18 LOT 4 Westwood highlands subdivision', '04', '0421', '042106', '042106005', '4114.', 14.2821, 120.946, 'November 23, 2021, 10:28 pm'),
(12, 'Bicycle Habitat', 'bike-shop-in-nyc-2-600x400.jpg', 'B32 L37, Sampaguita St., Phase 2. Cherry Homes', '', '04', '0421', '042103', '042103013', '4102', 14.4053, 120.977, 'November 23, 2021, 10:36 pm');

-- --------------------------------------------------------

--
-- Table structure for table `tblfeedback`
--

CREATE TABLE `tblfeedback` (
  `id` int(11) NOT NULL,
  `lessor_id` int(11) NOT NULL,
  `User_id` int(11) NOT NULL,
  `Score` int(11) DEFAULT NULL,
  `Comment` text DEFAULT NULL,
  `Date_Reviewed` varchar(45) NOT NULL,
  `Token` text NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'OFF'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tblfeedback`
--

INSERT INTO `tblfeedback` (`id`, `lessor_id`, `User_id`, `Score`, `Comment`, `Date_Reviewed`, `Token`, `status`) VALUES
(1, 2, 1, 5, 'nice store', 'November 28, 2021, 8:40 pm', '3708ffcf07c5b52f7ac1447b338541979ee561626153903cfb4dbba620370fd3d31c526d54e6b6a7', 'ON'),
(2, 1, 1, 5, 'nice shop. very affordable bicycles\n', 'November 30, 2021, 3:08 am', '6e7062bc48f459aa5532fbea064a3a9582a19e6e3476d4f1d23530e4ff8449abd6fd520b137de361', 'ON'),
(3, 1, 1, NULL, NULL, '', 'd9358d71bf2eb704be534cb9c0013d6c36fd4d2dabcbcb7a70481ac2ed33c8fc5a33bc612183db80', 'OFF'),
(4, 1, 2, NULL, NULL, '', '75e05319e4e4e8a97ef6624c46e6d43ae1171e447ee6a2a5f7433530538210ca587d3f6c90514235', 'OFF'),
(5, 1, 2, NULL, NULL, '', '5fe9c9ac1a9cfde3d991a77150862c9fe6c9dcb775b976b5a98e4734d00cbee369b661ffac865d89', 'OFF'),
(6, 1, 2, NULL, NULL, '', '5cf66939f5ea80734a3fbf7c03d34d532c0a84ae2a9fbb9ee22f5e84cf533226ba2757d45f8441c2', 'OFF'),
(7, 1, 2, NULL, NULL, '', '9fcde2a5a52fe2291ae746b3bba0912dd63d7e3b5e14aa097b7401729ddad1121e03e687e677a10c', 'OFF'),
(8, 1, 1, NULL, NULL, '', 'fb34a4f7c5213a04beb26264b510c7c62485d1fab9d3a931b3634172298e7f30b12a5a8dc784cdd8', 'OFF'),
(9, 1, 1, NULL, NULL, '', 'dd720d69419c77e206b950d051002f14a4e43b9473d11c98ed9dc76918d2263771267a6180c88fa2', 'OFF'),
(10, 1, 2, NULL, NULL, '', '21081c7712c5de06b780be9ec5aef5cb81e02648b67556fa66640bc4002b67d8df1ae7e0af8ea61b', 'OFF');

-- --------------------------------------------------------

--
-- Table structure for table `tbllessor`
--

CREATE TABLE `tbllessor` (
  `lessor_id` int(11) NOT NULL,
  `first_name` varchar(45) NOT NULL,
  `last_name` varchar(45) NOT NULL,
  `lessor_email` varchar(75) NOT NULL,
  `lessor_password` varchar(200) NOT NULL,
  `lessor_phone` bigint(10) NOT NULL,
  `registered_date` varchar(45) NOT NULL,
  `token` varchar(200) NOT NULL,
  `status` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbllessor`
--

INSERT INTO `tbllessor` (`lessor_id`, `first_name`, `last_name`, `lessor_email`, `lessor_password`, `lessor_phone`, `registered_date`, `token`, `status`) VALUES
(1, 'Royce', 'Rodriguez', 'rrocyerodriguez@gmail.com', '$2y$10$MDgzNTljMmE4N2Y3YjQ1YuzWaPIRFl3pfq/ZRNsXQz30UbqXmVvY2', 9555672619, 'November 23, 2021, 12:30 pm', '34fc78badca84bc6f0a516aac32f0ee5d7ac0aa6cd7a47a405cfb6a26765b8746643a80131cd7751', 'ON'),
(2, 'Corleone', 'Rodriguez', 'rrocyerodriguez19@gmail.com', '$2y$10$Y2QyY2IzNmFhYzBkMjhkO.Xi0v/ICuDkuBY7iSrsxbKuNoEZCDJfS', 9555672612, 'November 23, 2021, 12:31 pm', 'e3b125b9c4b52faa06394373b5b3fba2a28e83075702ce7625853585e7d77d05138108211e99e628', 'ON'),
(3, 'Lloyd', 'Baliuag', 'Mrbaliuag5@gmail.com', '$2y$10$YzkwZTJlOWEyZDFmN2QwZO9wE3cFqmke/f43mTll3KRJjqUsYA5hK', 9179677185, 'November 23, 2021, 12:52 pm', '8afed26dd052dbed58771e8ed95fd25d51d8b76000372c7b98f6154b27a1b72a5b60ad2b8d4bc81b', 'ON'),
(4, 'Angela', 'Jimenez', 'xgelaaatiinx@gmail.com', '$2y$10$MmIwMzA5YmNjZGVkOGJiZOzJuBq9/jiKXRpZZ6S/DDEoWopr./jP2', 9278631360, 'November 23, 2021, 1:08 pm', '74de402e9e79e5d5c8348770881c22b5ebdc8265307e5beaf0b0d59f45904d4b03775ae78ad6f346', 'ON'),
(5, 'Gelay', 'Jimenez', 'angelaamorjj99@gmail.com', '$2y$10$YzFiZjg4YzAwMWIxZDEyNuO1Z0LJ05NU9Ld6qcgpPxCU9BW0jMNNa', 9278631361, 'November 23, 2021, 1:08 pm', '3896913b9b890137c66bb6179f2f8096d88331786ab0103375c80c17675f22088bde4643b9c8faff', 'ON'),
(6, 'Angela Amor', 'Jimenez', 'angela.jimenez@lpunetwork.edu.ph', '$2y$10$NGJiNmQwODE0MmUyM2YzN.i9Z2va5knUZjIyzbNkb4.E6RCEf.bEK', 9278631362, 'November 23, 2021, 1:09 pm', 'b42822f6b60bd501417f07ad99ca917652e863a4cbb7d74863b089fbed3454616e549d950d3f9278', 'OFF'),
(7, 'Royce', 'Rodriguez', 'rrocyerodriguez20@gmail.com', '$2y$10$OTBlMjg3ZDQ5YTY3MzYzMeSv9vzS0rzLggpivad/QvCbMgHlv1j1m', 9555672523, 'November 23, 2021, 1:27 pm', '8606f7e2343cb6e370867e3cb08ba5de3094271e343936f5c631c6e836d8b1a150fc6bc093346f76', 'ON'),
(8, 'Royce', 'Rodriguez', 'rrocyerodriguez21@gmail.com', '$2y$10$MDk5ZDM5ZTRiNTRiY2M1Ne052UiY5Azf.8gTmLGhztSlZhn2utrTa', 9215582337, 'November 23, 2021, 1:53 pm', 'ad00d71cc1b76df1302316bb3b0a30b483444b0308856940fdbdcd0fc0130b745b3128ce51ffeeb4', 'OFF'),
(9, 'Nelia', 'Rodriguez', 'rrocyerodriguez22@gmail.com', '$2y$10$NjMzMGU5M2ZmMzY2YTI2O.P6TZ3qoeT0HWgp4M/8l6S4rKHnzNr6y', 9215582338, 'November 23, 2021, 1:55 pm', 'a8088158e1cde6e1fb56034fba94220ce04526ba11f5292a3df14d0398a29e04e1288587ee4ae859', 'ON'),
(10, 'Champ', 'Dalumpines', 'champinoy23@gmail.com', '$2y$10$ZjU3ZmVmOTE1ODU0MTk4YOkGzu2.fUYnxcRyISW9Rzcd1eeBWMrfW', 9215582339, 'November 23, 2021, 1:58 pm', 'd79eebfa7c07b363326a0855f677a65ff2d69461f3f0fd50f59acf56d07369e187ab96fa94016c33', 'ON'),
(11, 'Ero', 'Sensei', 'erosensei5690@gmail.com', '$2y$10$OWE2YjkwOTdlZTg4NjJhNO7dX5YNR.fai3/JL5TiYgnXFmHHS70eu', 9214452338, 'November 23, 2021, 1:58 pm', 'b8ebd177786805bda02268cf1df709226c86c155c2eb666646f790617d59af6cd724999585afe813', 'OFF'),
(12, 'Shanez', 'Obrique', 'shanezobrique@gmail.com', '$2y$10$Yzc1OTkxZDVlNTM3MGMwYOjrofQ1EV10hVx4REazWVLmM30Pouami', 9215592337, 'November 23, 2021, 1:59 pm', 'f476dc7c2a2ed493aafd024fd803c0c348713d5eeba54ea71f1c090c6c9c7f91e078900245a9f9ad', 'ON'),
(13, 'Keesees', 'Marayag', 'keesesmarayag15@gmail.com', '$2y$10$MTU2ZmNhMzMyMzlhMjY5MuUTHEwGk1.HwYYR8Sp524T8rLQk9mvj.', 9219983942, 'November 23, 2021, 1:59 pm', '0b35ade5ad983cd0840aed5e176a832746d41e310c0ee5f5c3cb78d0c21c1171446e8cfd12233b8e', 'ON'),
(14, 'Nikee', 'Agcaoili', 'keesesagaoili@gmail.com', '$2y$10$NWVjZjI0NmE2OGMxZTI3NewyzH5YPlhMsgg32Uu7YaIAkzouODb/q', 9215592336, 'November 23, 2021, 2:00 pm', '341eef4b8e31faf2c407e8ad26102ef31c8a11b2e95e27a60c617cbe6f69b36e4604ec87504e2b88', 'OFF'),
(15, 'Angela Ganda', 'Jimenez', 'angelaamorjimenez@gmail.com', '$2y$10$NDYxY2Y4NmUxNjhmOWYyMu70BKXs00V/5Sba5YX5xbx.mXV5tEaW2', 9214482449, 'November 23, 2021, 2:10 pm', 'e10b2501d24832e21523788bbb71e2461996371eb040b8ee31d3141e0a69e7be351bb7d3a70dc7f2', 'ON'),
(16, 'Royce', 'Rodriguez', 'nocturnalmicro1@gmail.com', '$2y$10$Y2MzZTZlNTc3OTZjZThkYeR0..9x9VG1dj/80IjUw7RWR7PUsvrLi', 9215583447, 'November 23, 2021, 2:11 pm', '1eb29ca583a69ffb87a420ab28bccd1df702025a4bf259e3c9cfd87e50d32676c7dbdcd63c5de201', 'ON'),
(17, 'Keith', 'Bugayong', 'keithpmbugz@gmail.com', '$2y$10$NmJhMDVjYTMxZTM5MzdkMuDTi1xpV1NNyDuGVTIsKq0u8aOXX5EcG', 9615394394, 'November 23, 2021, 2:41 pm', '800b09cea333a855527fd55bd8f08fa8ae28dc4521554472a364f0dcc0dfb9b6449b5deb495bf8dd', 'ON');

-- --------------------------------------------------------

--
-- Table structure for table `tblreport`
--

CREATE TABLE `tblreport` (
  `id` int(11) NOT NULL,
  `lessor_id` int(11) NOT NULL,
  `User_id` int(11) NOT NULL,
  `CategoryReport` varchar(45) NOT NULL,
  `Comment` text NOT NULL,
  `Date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tblusers`
--

CREATE TABLE `tblusers` (
  `User_id` int(11) NOT NULL,
  `FirstName` varchar(45) NOT NULL,
  `LastName` varchar(45) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `MobileNos` bigint(10) NOT NULL,
  `Password` varchar(200) NOT NULL,
  `valid_id` varchar(150) NOT NULL,
  `Token` text NOT NULL,
  `Date_Created` varchar(35) NOT NULL,
  `Active` char(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tblusers`
--

INSERT INTO `tblusers` (`User_id`, `FirstName`, `LastName`, `Email`, `MobileNos`, `Password`, `valid_id`, `Token`, `Date_Created`, `Active`) VALUES
(1, 'Royce', 'Rodriguez', 'rrocyerodriguez@gmail.com', 9354355668, '$2y$10$ZWI3MDY3N2JkMjU3MDBkYuGJJopAedJGkBNjmSM3S3Lv7fPsBr.k2', 'Rodriguez_Royce.jpg', '8a79c7f2769ca5605e5f73ea6f42afe3f04348060cebecacdb795e60c04b37c8f02be1f56b6b204c', 'November 23, 2021, 7:55 pm', 'ON'),
(2, 'Ellie', 'Rodriguez', 'rrocyerodriguez19@gmail.com', 9555672619, '$2y$10$ZTUwYTQyMDhjYjkzNmIxM.TEckUalbm3Hq9tCbgbCcWXwKwBlx7E2', 'Rodriguez_Royce.jpg', '5f767281feb869fbfd1fea39c5767718674a0e3f956850e98640acced9a39a85af1e8a34613919a3', 'November 23, 2021, 8:25 pm', 'ON');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `lessor_bicycle`
--
ALTER TABLE `lessor_bicycle`
  ADD PRIMARY KEY (`bike_id`) USING BTREE;

--
-- Indexes for table `lessor_bicyclecomponents`
--
ALTER TABLE `lessor_bicyclecomponents`
  ADD UNIQUE KEY `bike_id` (`bike_id`);

--
-- Indexes for table `lessor_bicyclerate`
--
ALTER TABLE `lessor_bicyclerate`
  ADD UNIQUE KEY `bike_id` (`bike_id`);

--
-- Indexes for table `lessor_payment`
--
ALTER TABLE `lessor_payment`
  ADD PRIMARY KEY (`payment_id`);

--
-- Indexes for table `tbladmin`
--
ALTER TABLE `tbladmin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `tblfeedback`
--
ALTER TABLE `tblfeedback`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbllessor`
--
ALTER TABLE `tbllessor`
  ADD PRIMARY KEY (`lessor_id`),
  ADD UNIQUE KEY `lessor_email` (`lessor_email`),
  ADD UNIQUE KEY `lessor_phone` (`lessor_phone`);

--
-- Indexes for table `tblreport`
--
ALTER TABLE `tblreport`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblusers`
--
ALTER TABLE `tblusers`
  ADD PRIMARY KEY (`User_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `lessor_bicycle`
--
ALTER TABLE `lessor_bicycle`
  MODIFY `bike_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `lessor_bicyclecomponents`
--
ALTER TABLE `lessor_bicyclecomponents`
  MODIFY `bike_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `lessor_bicyclerate`
--
ALTER TABLE `lessor_bicyclerate`
  MODIFY `bike_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `lessor_payment`
--
ALTER TABLE `lessor_payment`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbladmin`
--
ALTER TABLE `tbladmin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tblfeedback`
--
ALTER TABLE `tblfeedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tbllessor`
--
ALTER TABLE `tbllessor`
  MODIFY `lessor_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `tblreport`
--
ALTER TABLE `tblreport`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblusers`
--
ALTER TABLE `tblusers`
  MODIFY `User_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
