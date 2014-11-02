--
-- Database: `visitlog`
--

-- --------------------------------------------------------

--
-- Table structure for table `buildings`
--

CREATE TABLE IF NOT EXISTS `buildings` (
  `id` int(2) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `buildings`
--

INSERT INTO `buildings` (`id`, `name`) VALUES
(1, 'High School'),
(2, 'Middle School');

-- --------------------------------------------------------

--
-- Table structure for table `log`
--

CREATE TABLE IF NOT EXISTS `log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sid` int(11) NOT NULL,
  `place` varchar(255) NOT NULL,
  `dateTimeIn` varchar(255) DEFAULT NULL,
  `dateTimeOut` varchar(255) DEFAULT NULL,
  `ePassTime` varchar(255) DEFAULT NULL,
  `signinlocation` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12535 ;

-- --------------------------------------------------------

--
-- Table structure for table `places`
--

CREATE TABLE IF NOT EXISTS `places` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `place` varchar(255) NOT NULL,
  `building` int(3) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `places`
--

INSERT INTO `places` (`id`, `place`, `building`) VALUES
(1, 'Runners', 1),
(2, 'ePass', 1),
(3, 'Main Office/Guidance Office', 1),
(4, 'Off Block', 1),
(5, 'Lunch', 1),
(6, 'Passing Time', 1),
(7, 'PE', 1),
(8, 'Runners', 2),
(9, 'ePass', 2),
(10, 'Main Office/Guidance Office', 2),
(11, 'Off Block', 2),
(12, 'Lunch', 2),
(13, 'Passing Time', 2),
(14, 'PE', 2);

-- --------------------------------------------------------

--
-- Table structure for table `signinlocations`
--

CREATE TABLE IF NOT EXISTS `signinlocations` (
  `id` int(2) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `building` varchar(3) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `signinlocations`
--

INSERT INTO `signinlocations` (`id`, `name`, `building`) VALUES
(1, 'HS Library', '1'),
(2, 'HS Student Services', '1'),
(3, 'MS Library', '2'),
(4, 'HS Nurses Office', '1');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE IF NOT EXISTS `students` (
  `sid` varchar(255) NOT NULL,
  `first` varchar(255) NOT NULL,
  `last` varchar(255) NOT NULL,
  `grade` varchar(3) NOT NULL,
  `building` varchar(255) NOT NULL,
  `campusID` varchar(255) NOT NULL,
  UNIQUE KEY `sid` (`sid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
--
-- Dumping data for table `students`
--

INSERT INTO `students` (`sid`, `first`, `last`, `grade`, `building`, `campusID`) VALUES
('123456', 'Jeffery', 'Smith', '6', '2', '123456'),
('654321', 'Anna', 'Home', '6', '2', '654321');
