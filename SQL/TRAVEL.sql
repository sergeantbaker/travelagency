-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 10, 2016 at 09:41 
-- Server version: 10.1.13-MariaDB
-- PHP Version: 5.6.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `TRAVEL`
--

-- --------------------------------------------------------

--
-- Table structure for table `BOEKING`
--

CREATE TABLE `BOEKING` (
  `ID` int(11) NOT NULL,
  `Startdatum` date NOT NULL,
  `Einddatum` date NOT NULL,
  `Prijs` int(255) NOT NULL,
  `GEBRUIKER_ID` int(255) NOT NULL,
  `KAMER_ID` int(255) NOT NULL,
  `STATUS_ID` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `BOEKING`
--

INSERT INTO `BOEKING` (`ID`, `Startdatum`, `Einddatum`, `Prijs`, `GEBRUIKER_ID`, `KAMER_ID`, `STATUS_ID`) VALUES
(1, '2016-11-10', '2016-11-20', 2000, 12, 81, 2),
(2, '2016-11-16', '2016-11-28', 200, 12, 56, 2),
(3, '2016-11-09', '2016-11-22', 300, 24, 74, 1),
(5, '2016-11-10', '2016-11-20', 800, 24, 87, 1);

-- --------------------------------------------------------

--
-- Table structure for table `BOEKING_STATUS`
--

CREATE TABLE `BOEKING_STATUS` (
  `ID` int(255) NOT NULL,
  `Naam` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `BOEKING_STATUS`
--

INSERT INTO `BOEKING_STATUS` (`ID`, `Naam`) VALUES
(1, 'Betaald'),
(2, 'Geannuleerd');

-- --------------------------------------------------------

--
-- Table structure for table `GEBRUIKER`
--

CREATE TABLE `GEBRUIKER` (
  `Gebruikersnaam` varchar(255) NOT NULL,
  `Wachtwoord` varchar(255) NOT NULL,
  `SOORT_ID` int(255) NOT NULL,
  `ID` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `GEBRUIKER`
--

INSERT INTO `GEBRUIKER` (`Gebruikersnaam`, `Wachtwoord`, `SOORT_ID`, `ID`) VALUES
('rene', '83878c91171338902e0fe0fb97a8c47a', 3, 11),
('test', '098f6bcd4621d373cade4e832627b4f6', 3, 12),
('Bakker', 'bakker', 1, 15),
('bakker', 'b', 1, 16),
('addba', 'd', 1, 17),
('Klant', '098f6bcd4621d373cade4e832627b4f6', 1, 24);

-- --------------------------------------------------------

--
-- Table structure for table `GEBRUIKER_SOORT`
--

CREATE TABLE `GEBRUIKER_SOORT` (
  `ID` int(255) NOT NULL,
  `Naam` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `GEBRUIKER_SOORT`
--

INSERT INTO `GEBRUIKER_SOORT` (`ID`, `Naam`) VALUES
(1, 'Klant'),
(2, 'Beheerder'),
(3, 'Administrator');

-- --------------------------------------------------------

--
-- Table structure for table `HOTEL`
--

CREATE TABLE `HOTEL` (
  `ID` int(255) NOT NULL,
  `Land` varchar(255) NOT NULL,
  `Stad` varchar(255) NOT NULL,
  `HotelNaam` varchar(255) NOT NULL,
  `Telefoon` int(255) NOT NULL,
  `manager` varchar(255) NOT NULL,
  `rating` int(10) NOT NULL,
  `centrum` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `HOTEL`
--

INSERT INTO `HOTEL` (`ID`, `Land`, `Stad`, `HotelNaam`, `Telefoon`, `manager`, `rating`, `centrum`) VALUES
(4, 'test', 'test', 'What', 1, 'test', 1, 2),
(5, 'Nederland', 'Groningen', 'mercure', 505340766, 'jack', 100, 3),
(6, 'test', 'stes', 'test', 1, 'test', 100, 1),
(7, 'Nederland', 'Groningen', 'test', 505340766, 'jack the ripper', 100, 3),
(8, 'test', 'test ', 'hal', 12, 'test', 100, 2),
(13, 'Spanje', 'Madrid', 'Palace Hotel', 444, 'rene', 100, 1),
(14, 'Italie', 'Rome', 'Al Viminale Hill Inn', 555, 'raymon', 100, 1),
(15, 'Portugal', 'Lissabon', 'The Vintage Lisboa', 666, 'Martijn', 100, 1),
(16, 'Nederland', 'Joure', 'Haje', 777, 'Jason', 100, 2),
(18, 'Nederland', 'Amserdam', 'De LEurope Amsterdam', 888, 'Jonnie', 100, 1);

-- --------------------------------------------------------

--
-- Table structure for table `HOTEL_IMG`
--

CREATE TABLE `HOTEL_IMG` (
  `HOTEL_ID` int(255) NOT NULL,
  `Img` varchar(255) NOT NULL,
  `head` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `HOTEL_IMG`
--

INSERT INTO `HOTEL_IMG` (`HOTEL_ID`, `Img`, `head`) VALUES
(1, 'http://www.drodd.com/images15/1-4.png', 1),
(2, 'http://www.drodd.com/images15/2-1.png', 0),
(7, 'https://s-media-cache-ak0.pinimg.com/originals/59/7c/be/597cbe921ed17869b437504775ba3d00.png', 1),
(5, 'http://r-ec.bstatic.com/images/hotel/840x460/468/46842895.jpg', 0),
(5, 'https://texasstation.sclv.com/~/media/Images/Page-Background-Images/Texas/TS_Hotel_King_lowrez.jpg?h=630&la=en&w=1080', 0),
(5, 'https://cache.carlsonhotels.com/ow-cms/rad/images/hotels/TXAUSTDT/NEW_PILOT/AUTX_67166509_Guest_Room_King_Bed_960x640_72dpi.jpg', 0),
(5, 'http://www.chaturmusafir.com/img/M-Resort-Hotel-Room-King-Suite.jpg', 0),
(5, 'https://auckland.crowneplaza.com/wp-content/uploads/sites/2/2016/02/IMG_0047-r.jpg', 0),
(5, 'https://media-cdn.tripadvisor.com/media/photo-s/01/9a/68/50/hotel-rooms.jpg', 0),
(5, 'https://encrypted-tbn3.gstatic.com/images?q=tbn:ANd9GcSOyyMN2qIdWpqLFYRCzD5HXCnezJYT6KAI72SySzq_6O67KACsJg', 0),
(5, 'https://encrypted-tbn1.gstatic.com/images?q=tbn:ANd9GcQ6_faIQ9SBe82XMOmfYES8GqbmLSBMEMplk41B9D4VQdnXsuTQ', 0),
(5, 'https://encrypted-tbn2.gstatic.com/images?q=tbn:ANd9GcQvV5Sgva-wCUzYfRMcpyolN7O2bKd4mj2zaNsA-GDJsPbY7UdDrA', 0),
(5, 'http://r-ec.bstatic.com/images/hotel/840x460/370/37024558.jpg', 0),
(5, 'https://dubai.grand.hyatt.com/content/dam/PropertyWebsites/grandhyatt/dxbgh/Media/All/Grand-Hyatt-Dubai-Royal-Suite-Bathroom-1280x427.jpg', 0),
(8, '', 1),
(9, '', 1),
(10, '', 1),
(11, '', 1),
(5, 'http://www.ma.com/wp-content/uploads/2013/10/morris-adjmi-architects-wythe-hotel-3.jpg', 1),
(13, 'https://upload.wikimedia.org/wikipedia/commons/4/44/Hotel_Palace_-_Madrid_(2011).JPG', 1),
(14, 'http://media.cntraveler.com/photos/53daef256dec627b14a0cbdf/master/w_775,c_limit/the-first-hotel-rome-italy-113737-4.jpg', 1),
(15, 'https://media-cdn.tripadvisor.com/media/photo-o/08/9e/49/4e/vintage-house-lisboa.jpg', 1),
(16, 'http://media.hotelspecials.nl/images/hotels/nederland/friesland/joure/3435/gr_jou_aanzicht-57ce835c67088.jpeg', 1),
(18, 'https://media-cdn.tripadvisor.com/media/photo-s/07/30/32/e2/de-l-europe-amsterdam.jpg', 1);

-- --------------------------------------------------------

--
-- Table structure for table `INCIDENT`
--

CREATE TABLE `INCIDENT` (
  `ID` int(255) NOT NULL,
  `Mail` varchar(255) NOT NULL,
  `Datum` date NOT NULL,
  `Beschrijving` varchar(255) NOT NULL,
  `Melding` longtext NOT NULL,
  `GEBRUIKER_ID` int(255) NOT NULL,
  `SOORT_ID` int(255) NOT NULL,
  `STATUS_ID` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `INCIDENT`
--

INSERT INTO `INCIDENT` (`ID`, `Mail`, `Datum`, `Beschrijving`, `Melding`, `GEBRUIKER_ID`, `SOORT_ID`, `STATUS_ID`) VALUES
(2, 'yo@gmail.com', '2016-11-16', 'kapot', 'Alles is kapot maar dat valt ook wel weer mee want als ik op iets klik dan laad hij de pagina wel maar als ie dan geladen is geeft hij een fout code die iets aangeeft wat ik niet weet wat dat is en dat wil ik graag weten het is iets met MSQL blblba bla bal en ik zou hier graag antwoord op willen want anders ben ik best wel teleurgesteld hiernaast heb ik ook een probleem met mijn computer waneer ik op de uitknop onder het beeldscherm druk gaat de computer niet uit. terwijl dit thuis wel gebeurt. mijn draadloze muis werkt ook niet op deze computer en dit wil ik ook graag werkend krijgen als dat kan.  ', 24, 1, 3),
(3, '', '2016-11-16', 'alles is gemaakt', 'thx', 24, 2, 3),
(4, '', '2016-11-10', 'test', 'u', 24, 1, 1),
(5, '', '2016-11-10', 'test', 'test', 24, 1, 1),
(6, '', '2016-11-10', '2', '2', 24, 1, 1),
(7, '', '2016-11-10', 'test', 'test', 24, 1, 1),
(8, '', '2016-11-10', 'test', 'test2', 24, 1, 1),
(9, '', '2016-11-10', 'what', '....', 24, 4, 1),
(10, '', '2016-11-10', 'yo', 'yo', 24, 4, 1),
(11, '', '2016-11-10', 'test', 'test', 24, 1, 3);

-- --------------------------------------------------------

--
-- Table structure for table `INCIDENT_MELDING`
--

CREATE TABLE `INCIDENT_MELDING` (
  `Melding` longtext NOT NULL,
  `datum` date NOT NULL,
  `INCIDENT_ID` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `INCIDENT_MELDING`
--

INSERT INTO `INCIDENT_MELDING` (`Melding`, `datum`, `INCIDENT_ID`) VALUES
('zou je dit kunnen opsplitsen in meerdere meldingen \r\ninvm de kennis bank', '2016-11-08', 2),
('dank je', '2016-11-09', 2),
('YOYOYO', '2016-11-08', 2),
('Opgelost: dit is geen vraag, probleem of incident', '2016-11-08', 3),
('test', '2016-11-09', 2),
('test', '2016-11-09', 2),
('oy', '2016-11-10', 10),
('is opgelost', '2016-11-10', 2);

-- --------------------------------------------------------

--
-- Table structure for table `INCIDENT_SOORT`
--

CREATE TABLE `INCIDENT_SOORT` (
  `ID` int(255) NOT NULL,
  `Naam` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `INCIDENT_SOORT`
--

INSERT INTO `INCIDENT_SOORT` (`ID`, `Naam`) VALUES
(1, 'VRAAG'),
(2, 'INCIDENT'),
(4, 'PROBLEEM');

-- --------------------------------------------------------

--
-- Table structure for table `INCIDENT_STATUS`
--

CREATE TABLE `INCIDENT_STATUS` (
  `ID` int(255) NOT NULL,
  `Naam` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `INCIDENT_STATUS`
--

INSERT INTO `INCIDENT_STATUS` (`ID`, `Naam`) VALUES
(1, 'NIEUW'),
(2, 'BEZIG'),
(3, 'OPGELOST');

-- --------------------------------------------------------

--
-- Table structure for table `KAMER`
--

CREATE TABLE `KAMER` (
  `ID` int(255) NOT NULL,
  `Kamers` int(255) NOT NULL,
  `Slaapplaatsen` int(255) NOT NULL,
  `Prijs` int(255) NOT NULL,
  `HOTEL_ID` int(255) NOT NULL,
  `STATUS_ID` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `KAMER`
--

INSERT INTO `KAMER` (`ID`, `Kamers`, `Slaapplaatsen`, `Prijs`, `HOTEL_ID`, `STATUS_ID`) VALUES
(81, 1, 2, 200, 5, 1),
(82, 1, 2, 200, 5, 2),
(87, 1, 2, 80, 5, 1),
(88, 1, 2, 80, 5, 2),
(89, 1, 2, 80, 5, 2),
(90, 1, 2, 80, 5, 2),
(91, 1, 2, 80, 5, 2),
(92, 1, 2, 80, 5, 2),
(93, 1, 2, 80, 5, 2),
(94, 1, 2, 80, 5, 2),
(95, 1, 2, 80, 5, 2),
(96, 1, 2, 80, 5, 2),
(100, 0, 0, 0, 13, 1),
(101, 0, 0, 0, 14, 1),
(102, 0, 0, 0, 15, 1),
(103, 1, 2, 80, 13, 2),
(104, 1, 2, 80, 13, 2),
(105, 1, 2, 80, 13, 2),
(106, 1, 2, 80, 13, 2),
(107, 1, 2, 80, 13, 2),
(108, 1, 2, 170, 14, 2),
(109, 1, 2, 170, 14, 2),
(110, 1, 2, 170, 14, 2),
(111, 1, 2, 170, 14, 2),
(112, 1, 2, 170, 14, 2),
(113, 1, 2, 170, 14, 2),
(114, 1, 2, 170, 14, 2),
(115, 1, 2, 170, 14, 2),
(116, 1, 2, 170, 14, 2),
(117, 1, 2, 170, 14, 2),
(118, 1, 2, 59, 15, 2),
(119, 1, 2, 59, 15, 2),
(120, 1, 2, 59, 15, 2),
(121, 1, 2, 59, 15, 2),
(122, 0, 0, 0, 16, 1),
(124, 0, 0, 0, 18, 1),
(125, 1, 2, 30, 16, 2),
(126, 1, 2, 30, 16, 2),
(127, 1, 2, 30, 16, 2),
(128, 1, 2, 30, 16, 2),
(129, 1, 2, 30, 16, 2),
(130, 2, 2, 100, 18, 2),
(131, 2, 2, 100, 18, 2),
(132, 2, 2, 100, 18, 2),
(133, 2, 2, 100, 18, 2),
(134, 2, 2, 100, 18, 2);

-- --------------------------------------------------------

--
-- Table structure for table `KAMER_STATUS`
--

CREATE TABLE `KAMER_STATUS` (
  `ID` int(255) NOT NULL,
  `Naam` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `KAMER_STATUS`
--

INSERT INTO `KAMER_STATUS` (`ID`, `Naam`) VALUES
(1, 'BEZET'),
(2, 'BESCHIKBAAR');

-- --------------------------------------------------------

--
-- Table structure for table `KLANT`
--

CREATE TABLE `KLANT` (
  `Voornaam` varchar(255) NOT NULL,
  `Achternaam` varchar(255) NOT NULL,
  `Geboortedatum` date NOT NULL,
  `Geslacht` varchar(255) NOT NULL,
  `Telefoon` bigint(255) NOT NULL,
  `Mail` varchar(255) NOT NULL,
  `Land` varchar(255) NOT NULL,
  `Stad` varchar(255) NOT NULL,
  `Straat` varchar(255) NOT NULL,
  `StraatNr` int(255) NOT NULL,
  `Postcode` varchar(255) NOT NULL,
  `GEBRUIKER_ID` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `KLANT`
--

INSERT INTO `KLANT` (`Voornaam`, `Achternaam`, `Geboortedatum`, `Geslacht`, `Telefoon`, `Mail`, `Land`, `Stad`, `Straat`, `StraatNr`, `Postcode`, `GEBRUIKER_ID`) VALUES
('Rene', 'Bakker', '1995-07-03', 'male', 630485304, 'renebakker150@gmail.com', 'data', 'stad', 'straat', 2, '9384DS', 11),
('Rene', 'Bakker', '2015-02-02', 'male', 0, 'renebakker150@gmai222l.com', 'Nederland', 'Gro', 'gor', 2, '3945DS', 12),
('rene', 'bakker', '2015-02-02', 'male', 2222222222, 'e@eee.nl', 'Ren', 'Ren', '3', 3, '333333', 13),
('Rene', 'Bakker', '2015-02-02', 'male', 2222222222, 'renebakkeasdfr150@gmail.com', 'd', 'd', 'd', 3, 'd', 14),
('Voornaam', 'Achternaam', '2015-02-02', 'Geslacht', 555, 'mail@mail.nl', 'Land', 'Stad', 'Straat', 2, 'Postcode', 5),
('rene', 'bakker', '2015-02-02', 'male', 5555555555, 'ren@rene.nl', 'Nederland', 'Stad', 'hm', 2, 'hm', 18),
('renea', 'Bakkera', '2015-03-03', 'male', 4, 'r@raa.nl', 'da', 'da', 'aad', 2, 'aad', 19),
('test', 'bakker', '2015-02-02', 'male', 3333333333, 're@re.nl', 'Nederland', 'Groningen', 'He', 2, 'He', 20),
('Rene', 'Bakker', '2015-03-03', 'female', 1111111111, 'ren@ren.nl', 'Nederland', 'adf', 'asdf', 3, 'asdf', 21),
('Klant', 'Mc Klantface', '2015-03-03', 'male', 3, 'McKlant@klant.nl', 'klantonia', 'klanvile', 'Klantstraat', 1, 'Klantstraat', 22),
('Klant', 'Mc Klantface', '2015-03-03', 'male', 34592, 'K_McKlant@klant.nl', 'Klantonia', 'KlantVile', 'Klantstraat', 2, 'Klantstraat', 23),
('Klant', 'Mc Klantface', '2015-03-03', 'Vrouw', 1293, 'KlantMcKlantface@Klantmail.com', 'Klantonia', 'Klantvile', 'Klantlane', 3, '8654SD', 24),
('datumtest', 'datumtest', '2016-11-16', 'male', 304, 'REN@YO.NL', 'suriname', 'amsterdam', 'julianaplein 1', 1, '9384SD', 25),
('test', 'Bakker', '2000-02-02', 'male', 243034, 'ddd@ddd.nl', 'test', 'test', 'test', 3, '3424SD', 26);

-- --------------------------------------------------------

--
-- Table structure for table `LAND`
--

CREATE TABLE `LAND` (
  `ID` int(255) NOT NULL,
  `LAND` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `LAND`
--

INSERT INTO `LAND` (`ID`, `LAND`) VALUES
(1, 'Spanje'),
(2, 'Griekenland'),
(3, 'Italie'),
(4, 'Frankrijk'),
(5, 'Belgie'),
(6, 'Duitsland'),
(7, 'Nederland'),
(8, 'Portugal');

-- --------------------------------------------------------

--
-- Table structure for table `REVIEW`
--

CREATE TABLE `REVIEW` (
  `Datum` date NOT NULL,
  `Review` longtext NOT NULL,
  `Rating` int(255) NOT NULL,
  `HOTEL_ID` int(255) NOT NULL,
  `GEBRUIKER_ID` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `REVIEW`
--

INSERT INTO `REVIEW` (`Datum`, `Review`, `Rating`, `HOTEL_ID`, `GEBRUIKER_ID`) VALUES
('2016-11-09', 'nice hotel!', 90, 5, 24),
('2016-11-10', '"But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I will give you a complete account of the system, and expound the actual teachings of the great explorer of the truth, the master-builder of human happiness. No one rejects, dislikes, or avoids pleasure itself, because it is pleasure, but because those who do not know how to pursue pleasure rationally encounter consequences that are extremely painful. Nor again is there anyone who loves or pursues or desires to obtain pain of itself, because it is pain, but because occasionally circumstances occur in which toil and pain can procure him some great pleasure. To take a trivial example, which of us ever undertakes laborious physical exercise, except to obtain some advantage from it? But who has any right to find fault with a man who chooses to enjoy a pleasure that has no annoying consequences, or one who avoids a pain that produces no resultant pleasure?"', 20, 5, 24),
('2016-11-07', 'nice vis', 100, 1, 24),
('2016-11-10', 'test', 20, 5, 24),
('2016-11-10', 'test', 20, 5, 24);

-- --------------------------------------------------------

--
-- Table structure for table `STAD`
--

CREATE TABLE `STAD` (
  `ID` int(255) NOT NULL,
  `Stad` varchar(255) NOT NULL,
  `LAND_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `STAD`
--

INSERT INTO `STAD` (`ID`, `Stad`, `LAND_ID`) VALUES
(1, 'Barcalona', 1),
(2, 'Rome', 3),
(3, 'Athene', 2),
(4, 'Berlijn', 6),
(5, 'Parijs', 4),
(6, 'Madrid', 1),
(7, 'Lisabon', 8),
(8, 'Munchen', 2),
(9, 'Groningen', 7),
(10, 'Amsterdam', 7);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `BOEKING`
--
ALTER TABLE `BOEKING`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `GEBRUIKER_ID` (`GEBRUIKER_ID`,`KAMER_ID`,`STATUS_ID`);

--
-- Indexes for table `BOEKING_STATUS`
--
ALTER TABLE `BOEKING_STATUS`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `GEBRUIKER`
--
ALTER TABLE `GEBRUIKER`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `SOORT_ID` (`SOORT_ID`);

--
-- Indexes for table `GEBRUIKER_SOORT`
--
ALTER TABLE `GEBRUIKER_SOORT`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `HOTEL`
--
ALTER TABLE `HOTEL`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `INCIDENT`
--
ALTER TABLE `INCIDENT`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `GEBRUIKER_ID` (`GEBRUIKER_ID`,`SOORT_ID`,`STATUS_ID`),
  ADD KEY `SOORT_ID` (`SOORT_ID`),
  ADD KEY `STATUS_ID` (`STATUS_ID`);

--
-- Indexes for table `INCIDENT_SOORT`
--
ALTER TABLE `INCIDENT_SOORT`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `INCIDENT_STATUS`
--
ALTER TABLE `INCIDENT_STATUS`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `KAMER`
--
ALTER TABLE `KAMER`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `HOTEL_ID` (`HOTEL_ID`,`STATUS_ID`);

--
-- Indexes for table `KAMER_STATUS`
--
ALTER TABLE `KAMER_STATUS`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `KLANT`
--
ALTER TABLE `KLANT`
  ADD KEY `GEBRUIKER_ID` (`GEBRUIKER_ID`);

--
-- Indexes for table `LAND`
--
ALTER TABLE `LAND`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `REVIEW`
--
ALTER TABLE `REVIEW`
  ADD KEY `HOTEL_ID` (`HOTEL_ID`,`GEBRUIKER_ID`),
  ADD KEY `GEBRUIKER_ID` (`GEBRUIKER_ID`);

--
-- Indexes for table `STAD`
--
ALTER TABLE `STAD`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `BOEKING`
--
ALTER TABLE `BOEKING`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `BOEKING_STATUS`
--
ALTER TABLE `BOEKING_STATUS`
  MODIFY `ID` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `GEBRUIKER`
--
ALTER TABLE `GEBRUIKER`
  MODIFY `ID` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
--
-- AUTO_INCREMENT for table `GEBRUIKER_SOORT`
--
ALTER TABLE `GEBRUIKER_SOORT`
  MODIFY `ID` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `HOTEL`
--
ALTER TABLE `HOTEL`
  MODIFY `ID` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `INCIDENT`
--
ALTER TABLE `INCIDENT`
  MODIFY `ID` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `INCIDENT_SOORT`
--
ALTER TABLE `INCIDENT_SOORT`
  MODIFY `ID` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `INCIDENT_STATUS`
--
ALTER TABLE `INCIDENT_STATUS`
  MODIFY `ID` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `KAMER`
--
ALTER TABLE `KAMER`
  MODIFY `ID` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=135;
--
-- AUTO_INCREMENT for table `KAMER_STATUS`
--
ALTER TABLE `KAMER_STATUS`
  MODIFY `ID` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `LAND`
--
ALTER TABLE `LAND`
  MODIFY `ID` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `STAD`
--
ALTER TABLE `STAD`
  MODIFY `ID` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `INCIDENT`
--
ALTER TABLE `INCIDENT`
  ADD CONSTRAINT `INCIDENT_ibfk_1` FOREIGN KEY (`SOORT_ID`) REFERENCES `INCIDENT_SOORT` (`ID`),
  ADD CONSTRAINT `INCIDENT_ibfk_2` FOREIGN KEY (`STATUS_ID`) REFERENCES `INCIDENT_STATUS` (`ID`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
