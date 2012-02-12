DROP TABLE IF EXISTS `Items`;
CREATE TABLE `Items` (
  `ItemNo` int(11) NOT NULL auto_increment,
  `Descr` varchar(200) default NULL,
  `Price` double(16,9) default NULL,
  UNIQUE KEY `ItemNo` (`ItemNo`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `Orders`;
CREATE TABLE `Orders` (
  `OrderNo` int(11) NOT NULL auto_increment,
  `Date` timestamp NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `Account` varchar(100) default NULL,
  `BtcAddress` varchar(100) default NULL,
  `ItemNo` int(11) default NULL,
  `Count` decimal(9,3) default NULL,
  `UserNo` int(11) default NULL,
  `OutSum` decimal(16,9) default NULL,
  `Status` enum('New','Accepted','ParyPayed','Payed','Delivered') default 'New',
  `Confirmations` int(11) default '0',
  `SumConfirmed` decimal(16,9) default '0',
  `SumUnConfirmed` decimal(16,9) default '0',
  `Hash` varchar(8) default NULL,
  UNIQUE KEY `QueueNo` (`OrderNo`),
  KEY `ItemNo` (`ItemNo`),
  KEY `Hash` (`Hash`),
  KEY `Status` (`Status`),
  KEY `Account` (`Account`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `Users`;
CREATE TABLE `Users` (
  `UserNo` int(11) NOT NULL auto_increment,
  `Account` varchar(100) default NULL,
  `email` varchar(150) default NULL,
  `nickname` varchar(150) default NULL,
  `name` varchar(150) default NULL,
  `identity` varchar(150) default NULL,
  `provider` varchar(150) default NULL,
  UNIQUE KEY `UserNo` (`UserNo`),
  UNIQUE KEY `identity` (`identity`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

