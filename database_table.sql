CREATE TABLE `users` (
  `userId` int(4) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `fName` varchar(50) NOT NULL,
  `lName` varchar(50) NOT NULL,
  `dispName` varchar(50) NOT NULL,
  `addr` varchar(255) NOT NULL,
  `telNum` varchar(12) NOT NULL,
  `nic` varchar(12) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(32) NOT NULL,
  `proImg` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL,
  `regDate` datetime DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE `section` (
  `id` int(4) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `name` varchar(50) NOT NULL,
  `desc` varchar(50) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `regDate` datetime DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE `device` (
  `id` int(4) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `sid` int(4) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL,
  `desc` varchar(50) NOT NULL,
  `powerState` tinyint(1) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `regDate` datetime DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (sid) REFERENCES section(id)
);

SELECT `section`.name AS sn,device.name AS dn FROM device JOIN `section` ON device.sid = `section`.id WHERE device.powerState='1';