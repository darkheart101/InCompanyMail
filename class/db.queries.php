CREATE TABLE `users` (
  `idusers` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(45) DEFAULT NULL,
  `password` varchar(45) DEFAULT NULL,
  `usermail` varchar(50) NOT NULL,
  `lastname` varchar(45) DEFAULT NULL,
  `name` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idusers`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;


CREATE TABLE `receivedemails` (
  `idmail` int(11) NOT NULL AUTO_INCREMENT,
  `iduser` int(11) NOT NULL,
  `fromID` int(11) NOT NULL,
  `msg` varchar(255) DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `emailStatus` bit(1) DEFAULT NULL,
  PRIMARY KEY (`idmail`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

