CREATE TABLE IF NOT EXISTS `weather` (
  `icao` varchar(300) NOT NULL,
  `wx` varchar(300) NOT NULL,
  UNIQUE KEY `icao` (`icao`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
