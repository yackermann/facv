-- phpMyAdmin SQL Dump
-- version 4.1.6
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 30, 2014 at 05:29 AM
-- Server version: 5.6.16
-- PHP Version: 5.5.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `dev`
--

-- --------------------------------------------------------

--
-- Table structure for table `activities`
--

CREATE TABLE IF NOT EXISTS `activities` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `activity` varchar(30) NOT NULL,
  `theme` varchar(30) NOT NULL,
  `description` text NOT NULL,
  `website` varchar(50) NOT NULL,
  `image` varchar(30) NOT NULL,
  `tourguide_id` int(2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `tourguide_id` (`tourguide_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=26 ;

--
-- Dumping data for table `activities`
--

INSERT INTO `activities` (`id`, `activity`, `theme`, `description`, `website`, `image`, `tourguide_id`) VALUES
(1, 'Tasting Tour', 'relax', 'Tauranga Tasting Tours specialise in personally customised wine-tasting tours for small groups (up to 19 people), of various winemaking regions. Relax in air-conditioned comfort and enjoy wines and sightseeing with the personal service of a guide who is still professionally involved in the wine industry. Enjoy the countryside, talk to the winemakers and sample their wines.', 'http://www.tastingtours.co.nz', 'tasting.jpg', 1),
(2, 'Baywave', 'in the water', 'Aquatic activities in one of the many pools: swimming lessons,  a lap pool, wave pool, learners pool, spa, sauna, steam room, hydroslide. Also available is; gym equipment, personal training, a swim shop for adult and childrens swimwear, Waves cafe for breakfast, lunch and dinner, and a childcare centre. The place to go for fun, fitness and water confidence.', 'http://www.baywave.co.nz', 'baywave.jpg', 3),
(3, 'Mount Main Beach', 'in the water', 'Awesome surf beach, beautiful sand. Surfing, body boarding, swimming, sunbathing and relaxing on the beach. Watch surf lifesaving events and beach volleyball. Relax at the hot pools or in one of the many beachside cafes. ', 'http://www.bestoftauranga.com/mount-maunganui-main', 'main.jpg', 3),
(4, 'Diving', 'in the water', 'Explore the clear waters of the beautiful Bay of Plenty. Snorkel or scuba dive the  waters around the active marine volcano, White Island, or the inshore islands of Whale and the Rurimas in the Eastern Bay of Plenty. ', 'http://www.diveplanet.co.nz/divecharterbop%2Findex', 'diving.jpg', 3),
(5, 'Swim with dolphins', 'in the water', ' The Tauranga dolphin company offers a unique and totally natural experience with wild dolphins. Gemini Galaxsea is sixty feet long and very comfortable. She is a sailing boat, a very dolphin friendly vessel and this voyage is ecotourism at its very best.', 'www.swimwithdolphins.co.nz', 'dolphins.jpg', 3),
(6, 'Surfing Museum', 'on the water', ' Visit the Mount Surf Shop to grasp the history of surfing. The museum houses the most extensive surfing collection in the Southern Hemisphere. See hundreds of vintage surfboards and memorabilla.', 'http://www.mountsurfshop.co.nz', 'surf.jpg', 2),
(7, 'Cruising', 'on the water', ' Harbour and off-shore cruising in ‘Spirit of Tauranga’ - Mayor, Karewa, Motiti, Matakana Islands. Kiwi Coast Cruises specialise in harbour, BBQ and party cruises.', 'http://www.kiwicoastcruises.co.nz', 'cruise.jpg', 2),
(8, 'Kayaking', 'on the water', 'Glow Worms. Visit McLaren Falls Park, Tauranga.  Kayak on a calm, safe waters of the lake before entering the river, shrouded in native bush. As it gets dark hear the haunting call of our own native owl the Ru Ru (Morepork) and watch the speckles of the glow worms amongst the bush.  Brace yourself as we enter the canyon and witness the spectacle of the glow worms covering the steep cliffs of the canyon.', 'http://www.adventurebop.co.nz', 'kayak.jpg', 2),
(9, 'Mount Hot Pools', 'relax', 'Swimming, aqua aerobics, private heated pools, kids pool with waterslide, massage. Something for everyone ', 'http://www.mounthotpools.co.nz', 'pool.jpg', 1),
(10, 'Fishing', 'on the water', 'Catch a big snapper or some fat tarakihi at Motiti or Mayor Islands, fish the deepwater knolls around Mayor Island for hapuka, bass, bluenose, gemfish and kingfish, troll in the clear waters around the Aldermans for that elusive marlin, dive for crayfish or scallops, spend a week relaxing at Great Barrier Island, the choice is yours. ', 'http://www.blueocean.co.nz', 'fishing.jpg', 2),
(11, 'Restaurants', 'relax', 'Enjoy a relaxing meal in one of the many restaurants and bars along "The Strand" and in the CBD ', 'http://www.eatout.co.nz/bop_tga.html', 'dining.jpg', 1),
(12, 'Blowkarts', 'on land', 'Blowkarts or land yachts. Visit the home of blokart …the original fun, fast, compact land sailor taking the world by storm!\r\nWhether for fun with the whole family, the adrenalin rush when sailing in strong wind or the action of competition, blokart offers it all…a one stop shop and one of the most interactive adrenalin sports on the planet! ', 'http://www.blokart.com', 'blokart.jpg', 6),
(13, 'Outdoor Centre', 'on land', ' The Valley. Something to challenge everyone. Low and high rope courses, paintball, teambuilding programmes. FUN and food!', 'http://www.outdoorcentre.co.nz', 'valley.png', 6),
(14, 'Golf', 'on land', 'A picturesque course in the heart of Tauranga (Adjacent to the Racecourse). Tauranga boasts a modern clubhouse with a fully equipped pro shop, catering and bar service and friendly professional staff. Visit and enjoy!', 'http://www.taurangagolf.co.nz', 'golf.jpg', 6),
(15, 'Horse Trek', 'on land', ' Our Horse Trek is right beside the Seaside in Maketu, Bay of Plenty, New Zealand.\r\nVisions abound as you ride in this horse heaven environment. We have access to hundreds of acres of horse riding trails all boasting amazing coastal scenic views. We take pride in our journey options available, all of which cater for horse riding groups  small and large, riders experienced and inexperienced. A once in a life time, unforgettable horse trek experience. ', 'http://www.briarshorsetrek.co.nz', 'trek.jpg', 6),
(16, 'Tandem Sky Dive', 'in the sky', 'Tauranga Tandem Skydiving operates from the Tauranga Airport located five minutes from the port and main beach at Mount Maunganui. Situated on the Pacific Coast Highway this location offers views ranging from Mount Ruapehu to White Island and East Cape. You are introduced to the thrill of Skydiving with one of our experienced Tandem Masters all who have completed over 2000 jumps.\r\nTauranga Tandem Skydiving hosts a smaller dropzone that has been operating over 14 years. We are proud to offer you an enjoyable experience with a personal touch.', 'http://www.tandemskydive.co.nz', 'skydive.jpg', 4),
(17, 'Flights', 'in the sky', 'Feel the wind in your face as you fly over Tauranga in an open cockpit reliving the true excitement of flight. We have two open cockpit biplanes, the Boeing Stearman and the Grumman Ag-Cat.\r\n\r\nThese aircraft are based at Classic Flyers and can be booked any day of the week weather permitting.', 'http://www.classicflyersnz.com', 'classic.jpg', 4),
(18, 'Jazz Festival', 'culture', 'You can always count on the Bay of Plenty to host a good party, and the Easter National Jazz Festival is no exception. This is the time when New Zealand’s best jazz musicians converge to serenade thousands of jazz lovers in various venues, from intimate performances in the Tauranga Art Gallery to open-air concerts down by the waterfront. ', 'http://www.jazz.org.nz', 'kokomo.jpg', 5),
(19, 'Maori Tourism', 'culture', 'The Bay of Plenty has a strong Maori culture, which you can learn more about on a guided tour or marae visit. \r\nExperience Maori culture of New Zealand first hand by visiting a marae (village).\r\nWitness the traditional welcome, the wero (challenge), the welcoming speeches and the hongi (traditional greeting).\r\n\r\nLearn of the rich Maori history, explanations of the marae and carvings and you will see that the oral traditions of storytelling are very much alive today. Dine on a traditional hangi (Maori method of cooking under ground) and be entertained by our local cultural group.\r\n\r\nVisit and meet the whanau (family) of Paparoa Marae.', 'http://www.bayofplentynz.com/Tauranga/', 'paparoa.jpg', 5),
(20, 'Art', 'culture', 'Tauranga Art Gallery is the first public art gallery in the western Bay of Plenty.\r\nThe Gallery delivers exhibitions of historical, modern and contemporary art. Exhibitions are developed in house by Gallery staff with the balance being a mix of touring exhibitions from other institutions and artist projects. ', 'http://www.artgallery.org.nz', 'gallery.jpg', 5),
(21, 'Heritage', 'culture', 'The Elms historic house museum, the oldest European heritage site in the Bay of Plenty, is an essential stop for all visitors to Tauranga. From this traditional English home, Maori were given the opportunity to learn about Christianity, and were educated in reading and writing, as well as agricultural and domestic skills.', 'http://www.theelms.org.nz', 'elms.jpg', 5);

-- --------------------------------------------------------

--
-- Table structure for table `information`
--

CREATE TABLE IF NOT EXISTS `information` (
  `id` int(2) NOT NULL AUTO_INCREMENT,
  `heading` varchar(50) NOT NULL,
  `text` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `information`
--

INSERT INTO `information` (`id`, `heading`, `text`) VALUES
(1, 'Early History of Tauranga and Mauao', '<p>The name Tauranga can be translated as meaning ''place of rest'' or ''anchorage''. The earliest people known to have resided in the Tauranga area are the Purukupenga, whose name alone survives, and the Ngamarama, who inhabited all the land from the Waimapu Stream to the Kaimai ranges.</p>\r\n			<p>Many people of different waka passed through and some stayed. This included those of the Tainui canoe, which made only a brief stay, although evidence of their visit can be linked to &quot;nga pehi o Tainui&quot;, the ballast of Tainui, now known as Ratahi Rock.\r\n			Another was the Te Arawa canoe which made landfall at Maketu, with some of her crew occupying the land between the Tauranga harbour and the Kaituna River. After the departure of Tainui the Takitimu canoe then entered the Tauranga harbour. Its captain, Tamatea Arikinui or Tamatea Pokaiwhenua, climbed to the summit of Mauao (Mount Maunganui) to offer karakia (prayers) and to bury there the mauri (life force) of his people.\r\n			Tamatea built a pa (stockaded village) on the hill known as Maungatawa, where his people settled. Ngati Ranginui all descended from Tamatea&rsquo;s son, Ranginui. In later years Ngaiterangi after many failed attempts of looking to settle themselves in a permanent area led a massive raid on the Ngati Ranginui pa site on top of Mauao (around 1700). This attack resulted in the pa falling to Ngaiterangi, and is known as the ''Battle of the Kokowai''.</p>\r\n			<p>According to archaeologist there has been evidence of three pa sites recorded on top of and around Mauao. The final encounter of warfare ended at the cliffs of Mauao between Ngaiterangi and Ngapuhi. Armed with muskets Ngapuhi decided to intimidate and force their way through under the command of Te Morenga in 1820, the large pa site was not re-occupied after this battle. A peace was made with Ngapuhi shortly afterwards by Te Waru of Ngaiterangi.</p>'),
(2, 'European Timeline', '<p>1769 Captain James Cook sails across the Bay of Plenty in the Endeavour.</p>\r\n<p>1820 Rev.Samuel Marsden sees the Tauranga Harbour from the top of Mount Hikurangi near Waihi</p>\r\n<p>1834 Site for Mission Station at Te Papa (Tauranga) chosen by A.N.Brown and William Williams</p>\r\n<p>1835 Mission Station at Te Papa opened by William Wade\r\nSeveral flax traders operating in the area: Tapsell, Dillon, Farrow.</p><p>\r\n1836 Continued fighting amongst Maori tribes. Mission Station evacuated.</p><p>\r\n1837 Rev J.A.Wilson to Te Papa Mission Station</p><p>\r\n1838 Rev A.N.Brown and family arrive at Te Papa Mission Station.<br/>\r\nPurchase of first block of land by Brown for CMS</p><p>\r\n1839 Second land purchase (3000 acres).</p><p>\r\n1840 John Lees Faulkner, trader, settles at Otumoetai\r\nTreaty signed at Maungatapu Pa by Nuka, but Tupaea (Otumoetai) refuses to sign\r\nRoman Catholic Mission established at Otumoetai.</p><p>\r\n1841 Ernst Dieffenbach visits Te Papa.</p><p>\r\n1842 Trouble over a stolen boat. Troops on Mount Drury (Hopukiore) for 4 months.</p><p>\r\n1845 Death of Marsh Brown, son of Rev. A.N.Brown.<br/>\r\nPeace treaty between Te Arawa and Ngaiterangi. Peace stones set up at Maketu and Otumoetai.</p><p>\r\n1852 HMS Pandora’s survey of Tauranga Harbour.</p><p>\r\n1855 Death of Charlotte Brown, wife of A.N.Brown, in Auckland.</p><p>\r\n1857 First steamship enters Tauranga harbour. Name unknown.</p><p>\r\n1859 Visit of Dr Ferdinand von Hochstetter, geologist.\r\nCelia Brown marries Rev John Kinder.</p><p>\r\n1860 Henry Tacy Clarke appointed Resident Magistrate at Tauranga.\r\nArchdeacon Brown marries Christina Johnston.</p><p>\r\n1864 Military occupation of Tauranga\r\nBattle of Gate Pa.<br/>\r\nBattle of Te Ranga.<br/>\r\nGov. George Grey takes part in formal peacemaking with Maori.<br/>\r\nLand west of Waimapu River confiscated.</p><p>\r\n1865 Rev C. Volkner murdered at Opotiki.V\r\n1866 Military settlers taking up farm and town lots.</p><p>\r\n1867 Tauranga District Lands Act legalises the confiscation.</p><p>\r\n1868 School opened in Durham Redoubt.</p><p>\r\n1869 Fear of attack by Te Kooti’s followers.<br/>\r\nOpepe massacre – 9 Tauranga men killed.</p><p>\r\n1870 Tauranga Highways District and Tauranga North Highways District Boards established.<br/>\r\nTelegraphic communication with Wellington established.</p><p>\r\n1871 Town Wharf built</p>'),
(3, 'Port of Tauranga', '<p>The origins of today''s world-class port at Tauranga can be traced to the 1860s when the first pilot, Captain T S Carmichael, fixed leading buoys and marks in position to define the navigable channel.</p><p>\r\n\r\nBefore this time the Port did not have a wharf, and it was common practice to load and unload cargo on the wooden trading vessels at low tide using ox carts.</p><br/>\r\nThe 1800s<br/><p>\r\n1828 - The visit of the missionary schooner Herald, probably the first European vessel to enter the harbour.</p><p>\r\n1853 - Captain Drury in HMS Pandora surveyed and charted the coast and harbour.</p><p>\r\n1873 - The Port of Tauranga was officially established by order of the Governor of New Zealand.</p><p>\r\n1882 - The Lady Jocelyn of 2,138 tonnes was the first large sailing vessel to enter the harbour.</p><p>\r\nThe 1900''s<br/><p>\r\n1912 - A Tauranga Harbour Board was constituted to administer the affairs of the harbour.</p><p>\r\n1913 - First meeting of the Tauranga Harbour Board.</p><p>\r\n1927 - Railway Wharf at Tauranga was completed and used almost exclusively for coastal shipping until the visit of the James Cook in 1948 to load timber for Australia.</p><p>\r\n1953 - First pile driven for Mount Maunganui wharf. The first ship, the MV Korowai berthed at the new wharf on 5 December 1954.</p><p>\r\n1957 - First log shipment to Japan - 158 tonnes.</p><p>\r\n1960 - First tug Mount Maunganui was commissioned at the Port.</p><p>\r\n1967 - First container unloaded.</p><p>\r\n1972 - Port Caroline, the world''s largest conventional refrigerated cargo liner, visits the Port for the first time.</p><p>\r\n1978 - Kaimai rail tunnel opened by Sir Robert Muldoon, substantially reducing travelling times between the Port and Hamilton/Rotorua areas.</p><p>\r\n1979 - $3.9 million heavy lift multi-purpose gantry crane operational.</p><p>\r\n1985 - New Zealand Steel announce decision to use Tauranga for import/export trade.</p><p>\r\n1985 - Establishment of Port of Tauranga Limited.</p><p>\r\n1988 - As a consequence of Government port reform, the Bay of Plenty Harbour Board is disestablished and Port of Tauranga Limited begins operations.</p><p>\r\n1988 - The Tauranga Harbour Bridge is completed, significantly joining the communities of Tauranga and Mount Maunganui.</p><p>\r\n1990 - Record annual cargo throughput of 5.1 million tonnes.</p><p>\r\n1992 - $100 million Tauranga Terminal development completed and wharves opened for shipping.</p><p>\r\n1996 - Formation of The Cargo Company Limited, a joint-venture with Owens Services BOP Limited for on-wharf cargo consolidation.</p><p>\r\n1998 - Tauranga Container Terminal buys fleet of 10 straddle carriers from Hong Kong. Navis information system commissioned.</p><p>\r\n1999 - Port of Tauranga establishes New Zealand''s first fully integrated inland port service - MetroPort Auckland.</p><p>\r\n1999 - Australia-New Zealand Direct Line (ANZDL) becomes the first shipping line to use MetroPort Auckland.</p>');

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE IF NOT EXISTS `login` (
  `id` int(2) NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL,
  `password` varchar(64) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`id`, `username`, `password`) VALUES
(4, 'test', '$2a$12$ecc3871e38be86d2cc3b1eqRJVxMsB7u7jhT97D3H1t.WlYXojAka'),
(10, 'martin', '$2a$12$ac7fcc4d737e3037aa899uV5Vl837jo1sLIkMzCbqZQQ0A1cZv.d2');

-- --------------------------------------------------------

--
-- Table structure for table `tourguide`
--

CREATE TABLE IF NOT EXISTS `tourguide` (
  `id` int(2) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(30) NOT NULL,
  `lastname` varchar(30) NOT NULL,
  `address1` varchar(30) NOT NULL,
  `town_city` varchar(30) NOT NULL,
  `mobile` varchar(12) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `tourguide`
--

INSERT INTO `tourguide` (`id`, `firstname`, `lastname`, `address1`, `town_city`, `mobile`) VALUES
(1, 'Troy', 'Man', '56 Papamoa Rd', 'Papamoa', '0213344599'),
(2, 'Sam', 'Skater', '2 Crash Lane', 'Mount Maunganui', '0276666666'),
(3, 'George', 'Diver', '56 Waterford Cres', 'Mount Maunganui', '0224532187'),
(4, 'Yurii', 'Tandemjump', '25 Jump St', 'Mount Maunganui', '0218877665'),
(5, 'Haylem', 'Ocker', '89 Tangata Whenua Drive', 'Mount Maunganui', '0213334448'),
(6, 'Kate', 'Earth', '90 Island Place', 'Papamoa', '0213334448'),
(14, 'John', 'Little', '23 Youst ST', 'Tauranga', '0215767069');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `activities`
--
ALTER TABLE `activities`
  ADD CONSTRAINT `activities_ibfk_2` FOREIGN KEY (`tourguide_id`) REFERENCES `tourguide` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
