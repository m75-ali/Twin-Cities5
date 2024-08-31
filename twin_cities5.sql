-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Mar 28, 2024 at 12:11 AM
-- Server version: 5.7.39
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `twin_cities5`
--

-- --------------------------------------------------------

--
-- Table structure for table `country`
--

CREATE TABLE `country` (
  `CountryID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `country`
--

INSERT INTO `country` (`CountryID`, `Name`) VALUES
(1, 'United Kingdom'),
(2, 'United States');

-- --------------------------------------------------------

--
-- Table structure for table `LocationDetails`
--

CREATE TABLE `LocationDetails` (
  `DetailID` int(11) NOT NULL,
  `PlaceID` int(11) NOT NULL,
  `HistoricalSignificance` text,
  `CulturalRelevance` text,
  `ArchitecturalStyle` varchar(255) DEFAULT NULL,
  `YearEstablished` varchar(255) DEFAULT NULL,
  `VisitorInfo` text,
  `AccessibilityOptions` varchar(255) DEFAULT NULL,
  `WebsiteURL` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `LocationDetails`
--

INSERT INTO `LocationDetails` (`DetailID`, `PlaceID`, `HistoricalSignificance`, `CulturalRelevance`, `ArchitecturalStyle`, `YearEstablished`, `VisitorInfo`, `AccessibilityOptions`, `WebsiteURL`) VALUES
(1, 1, 'One of the world\'s oldest museums, showcasing human history from across the globe.', 'A key cultural institution in London, hosting exhibitions from ancient to modern times.', 'Greek Revival', '1753', 'Free entry; special exhibitions may require tickets.', 'Wheelchair accessible entrances and facilities available.', 'https://www.britishmuseum.org'),
(2, 2, 'Official residence of the British monarch since 1837.', 'Hosts significant state occasions and royal hospitality.', 'Neoclassical', '1703', 'Public tours available in summer.', 'Wheelchair access to the State Rooms; step-free access available.', 'https://www.royal.uk/royal-residences-buckingham-palace'),
(3, 3, 'Designed as a public park in the 1850s, Central Park has been a national historic landmark since 1963.', 'Central Park is a sanctuary for New Yorkers and visitors alike, offering countless recreational activities.', 'Landscape Design', '1857', 'Open all year, offers guided tours and has several visitor centers.', 'Accessible to all visitors, with many paths wheelchair friendly.', 'https://www.centralparknyc.org'),
(4, 4, 'Gifted to the US by France in 1886 as a symbol of friendship and freedom.', 'An emblem of freedom and democracy.', 'Neoclassical', '1886', 'Access by ferry; tickets required for pedestal and crown.', 'Elevator access to the pedestal; the crown is accessible only via stairs.', 'https://www.nps.gov/stli/index.htm'),
(5, 5, 'One of the world\'s busiest pedestrian areas, it\'s also the hub of the Broadway Theater District.', 'Major center for entertainment, tourism, and shopping.', 'Modern', '1904', 'Highly visited at night for its bright lights.', 'Accessible public spaces and several subway stations with elevators.', 'https://www.timessquarenyc.org'),
(6, 6, 'Historical castle and former prison, showcasing over 1000 years of London\'s history.', 'A UNESCO World Heritage Site, known for the Crown Jewels.', 'Medieval', '1078', 'Tours available; it\'s recommended to buy tickets in advance.', 'Limited access to the Jewel House and White Tower due to stairs.', 'https://www.hrp.org.uk/tower-of-london'),
(7, 7, 'Offers panoramic views of London, standing as the tallest cantilevered observation wheel.', 'Symbolizes London\'s modernity and innovation in the 21st century.', 'Modern', '2000', 'Ticket purchase required; best to book in advance.', 'Fully accessible; offers dedicated capsules for wheelchair users.', 'https://www.londoneye.com'),
(8, 8, 'An iconic landmark of New York City, offering breathtaking views from its observatories.', 'Depicted in numerous films and art, symbolizing New York\'s architectural ambition.', 'Art Deco', '1931', 'Observatories open to visitors; tickets available online.', 'Main entrance, observatories, and restrooms are wheelchair accessible.', 'https://www.esbnyc.com'),
(9, 9, 'Site of numerous royal coronations, weddings, and burials.', 'Reflects over a thousand years of British history and architecture.', 'Gothic', '960', 'Open for daily services and visitor tours; photography restricted.', 'Mostly accessible, but some areas have steps.', 'https://www.westminster-abbey.org'),
(10, 10, 'One of the largest museums of modern and contemporary art in the world.', 'Reflects the dynamic nature of contemporary art and culture.', 'Postmodern', '2000', 'Free entry; special exhibitions may require tickets.', 'Wheelchair accessible, including lifts and restrooms.', 'https://www.tate.org.uk/visit/tate-modern'),
(11, 11, 'Historic bridge connecting Manhattan and Brooklyn, offering scenic views of New York\'s skyline.', 'Symbol of the technological achievement and industrial spirit of America.', 'Gothic Revival', '1883', 'Pedestrian and bike paths available; popular for walks and photography.', 'Accessible walkway; the pedestrian path is relatively flat.', 'https://www.nyc.gov'),
(12, 12, 'One of the largest and most prestigious art museums in the world.', 'Houses over two million works, spanning 5,000 years of world culture.', 'Beaux-Arts', '1870', 'Suggested admission; pay what you wish for NY State residents.', 'Facilities are accessible; wheelchairs available for use.', 'https://www.metmuseum.org');

-- --------------------------------------------------------

--
-- Table structure for table `placeofinterest`
--

CREATE TABLE `placeofinterest` (
  `PlaceID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Type` varchar(255) DEFAULT NULL,
  `Capacity` int(11) DEFAULT NULL,
  `Latitude` varchar(255) NOT NULL,
  `Longitude` varchar(255) NOT NULL,
  `Photo` varchar(255) DEFAULT NULL,
  `Description` text,
  `OpeningHours` varchar(255) DEFAULT NULL,
  `Rating` float DEFAULT NULL,
  `CityID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `placeofinterest`
--

INSERT INTO `placeofinterest` (`PlaceID`, `Name`, `Type`, `Capacity`, `Latitude`, `Longitude`, `Photo`, `Description`, `OpeningHours`, `Rating`, `CityID`) VALUES
(1, 'The British Museum', 'Museum', 6000, '51.5194', '-0.1270', 'https://cdn.londonandpartners.com/asset/british-museum_museum-frontage-image-courtesy-of-the-british-museum_f0b0a5a3c53f8fc1564868c561bd167c.jpg', '\"The British Museum is a museum dedicated to human history, art, and culture.The British Museum is unique in bringing together under one roof the cultures of the world, spanning continents and oceans.\"', '10:00 AM - 5:30 PM', 4.7, 1),
(2, 'Buckingham Palace', 'Palace', 6000, '51.5014', '-0.1419', 'https://cdn.londonandpartners.com/asset/buckingham-palace_image-courtesy-of-royal-collection-trust-his-majesty-king-charles-iii-2022-photo-andrew-holt_247a2afaed0312ad4e8fb6142fdcdd5a.jpg', 'Buckingham Palace is the London residence and administrative headquarters of the monarch of the United Kingdom. Buckingham Palace has 775 rooms. These include 19 State rooms, 52 Royal and guest bedrooms, 188 staff bedrooms, 92 offices and 78 bathrooms. In measurements, the building is 108 metres long across the front, 120 metres deep (including the central quadrangle) and 24 metres high.', '9:30 AM - 7:30 PM', 4.6, 1),
(3, 'Central Park', 'Park', NULL, '40.7856', '-73.9683', 'https://lik.com/cdn/shop/products/Peter-Lik-Central-Park-Spirit-Framed-Recess-Moun_1800x.jpg', 'Central Park is an urban park in New York City located between the Upper West and Upper East Sides of Manhattan. Central Park is full of attractions, from green meadows to sprawling waters, gardens and unique bridges, music and performance centres, educational facilities, classical architecture and more. Its picturesque beauty boasts natural green landscapes and vistas as far as the eye can see.', '6:00 AM - 1:00 AM', 4.8, 2),
(4, 'Statue of Liberty', 'Monument', NULL, '40.6892', '-74.0445', 'https://static.toiimg.com/thumb/77757963/Statue-of-Liberty.jpg?', 'The Statue of Liberty stands in Upper New York Bay, a universal symbol of freedom. Originally conceived as an emblem of the friendship between the people of France and the U.S. and a sign of their mutual desire for liberty, it was also meant to celebrate the abolition of slavery following the U.S. Civil War.', '8:30 AM - 4:00 PM', 4.7, 2),
(5, 'Times Square', 'Landmark', NULL, '40.7580', '-73.9855', 'https://cdn.britannica.com/66/154566-050-36E73C15/Times-Square-New-York-City.jpg', 'Times Square is a major commercial and entertainment hub in New York City. Together with adjacent Duffy Square, Times Square is a bowtie-shaped plaza five blocks long between 42nd and 47th Streets. Times Square is brightly lit by numerous digital billboards and advertisements as well as businesses offering 24/7 service.', 'Open all times of the day', 4.6, 2),
(6, 'Tower of London', 'Historical Site', 1000, '51.5081', '-0.0759', 'https://worldstrides.com/wp-content/uploads/2015/07/api201.jpg', 'Historic castle and prison with tours. As the most secure castle in the land, the Tower guarded royal possessions and even the royal family in times of war and rebellion. But for 500 years monarchs also used the Tower as a surprisingly luxurious palace. Throughout history, the Tower has also been a visible symbol of awe and fear.', '10AM - 5:30PM', 4.5, 1),
(7, 'London Eye', 'Tourist Attraction', 800, '51.5033', '-0.1195', 'https://upload.wikimedia.org/wikipedia/commons/thumb/d/d6/London-Eye-2009.JPG/1200px-London-Eye-2009.JPG', 'Ferris wheel with panoramic views. At 135m, The London Eye is the world\'s largest cantilevered observation wheel. It was conceived and designed by Marks Barfield Architects and was launched in 2000. It has won over 85 awards for national and international tourism, outstanding architectural quality and engineering achievement', '11AM - 6PM', 4.8, 1),
(8, 'Empire State Building', 'Skyscraper', 35000, '40.7488', '-73.9857', 'https://a.cdn-hotels.com/gdcs/production176/d304/45e7e95a-6f5d-4f19-9479-1d3ddfee7e99.jpg', 'Iconic skyscraper with observatories. At its top floor, the Empire State Building stands 1,250 feet (380 meters) tall. Counting the spire and antenna, the building clocks in at a mighty 1,454 feet (443 meters). It\'s currently the 4th tallest building in New York City, the 6th tallest in the United States, and the 43rd tallest tower in the world.', '9AM - 12AM', 4.7, 2),
(9, 'Westminster Abbey', 'Historical Site', 2000, '51.4994', '-0.1273', 'https://images.immediate.co.uk/production/volatile/sites/7/2019/12/GettyImages-541057288-74741cf.jpg', 'Historic church with coronations', NULL, 4.6, 1),
(10, 'Tate Modern', 'Art Museum', 3500, '51.5076', '-0.0994', 'https://media.tate.org.uk/aztate-prd-ew-dg-wgtail-st1-ctr-data/images/tate-modern-extension-herzog-de-meuron-london-.width-600_V6eqx5i.jpg', 'Contemporary art museum in former power station', NULL, 4.5, 1),
(11, 'Brooklyn Bridge', 'Bridge', NULL, '40.7061', '-73.9969', 'https://upload.wikimedia.org/wikipedia/commons/0/00/Brooklyn_Bridge_Manhattan.jpg', 'Iconic bridge connecting Manhattan and Brooklyn', NULL, 4.7, 2),
(12, 'Metropolitan Museum of Art', 'Art Museum', 7000, '40.7794', '-73.9632', 'https://media.cntraveler.com/photos/55d362f337284fb1079ccc4b/16:9/w_2560%2Cc_limit/metropolitan-museum-of-art-new-york-city.jpg', 'Major art museum with vast collections', NULL, 4.9, 2);

-- --------------------------------------------------------

--
-- Table structure for table `towncity`
--

CREATE TABLE `towncity` (
  `CityID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Country` varchar(255) NOT NULL,
  `Population` int(11) DEFAULT NULL,
  `Latitude` varchar(255) NOT NULL,
  `Longitude` varchar(255) NOT NULL,
  `Currency` varchar(255) DEFAULT NULL,
  `Timezone` varchar(255) DEFAULT NULL,
  `Area` float DEFAULT NULL,
  `OfficialLanguage` varchar(255) DEFAULT NULL,
  `CountryID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `towncity`
--

INSERT INTO `towncity` (`CityID`, `Name`, `Country`, `Population`, `Latitude`, `Longitude`, `Currency`, `Timezone`, `Area`, `OfficialLanguage`, `CountryID`) VALUES
(1, 'London', 'United Kingdom', 8900000, '51.5074', '0.1278', 'GBP', 'GMT', 1572, 'English', 1),
(2, 'New York City', 'United States', 8400000, '40.7128', '-74.0060', 'USD', 'EST', 783.8, 'English', 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `country`
--
ALTER TABLE `country`
  ADD PRIMARY KEY (`CountryID`);

--
-- Indexes for table `LocationDetails`
--
ALTER TABLE `LocationDetails`
  ADD PRIMARY KEY (`DetailID`),
  ADD KEY `fk_LocationDetails_Place` (`PlaceID`);

--
-- Indexes for table `placeofinterest`
--
ALTER TABLE `placeofinterest`
  ADD PRIMARY KEY (`PlaceID`),
  ADD KEY `CityID` (`CityID`);

--
-- Indexes for table `towncity`
--
ALTER TABLE `towncity`
  ADD PRIMARY KEY (`CityID`),
  ADD KEY `CountryID` (`CountryID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `country`
--
ALTER TABLE `country`
  MODIFY `CountryID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `LocationDetails`
--
ALTER TABLE `LocationDetails`
  MODIFY `DetailID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `placeofinterest`
--
ALTER TABLE `placeofinterest`
  MODIFY `PlaceID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `towncity`
--
ALTER TABLE `towncity`
  MODIFY `CityID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `LocationDetails`
--
ALTER TABLE `LocationDetails`
  ADD CONSTRAINT `fk_LocationDetails_Place` FOREIGN KEY (`PlaceID`) REFERENCES `placeofinterest` (`PlaceID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `placeofinterest`
--
ALTER TABLE `placeofinterest`
  ADD CONSTRAINT `placeofinterest_ibfk_1` FOREIGN KEY (`CityID`) REFERENCES `towncity` (`CityID`);

--
-- Constraints for table `towncity`
--
ALTER TABLE `towncity`
  ADD CONSTRAINT `towncity_ibfk_1` FOREIGN KEY (`CountryID`) REFERENCES `country` (`CountryID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
