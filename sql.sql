CREATE TABLE `users` (
  `users_id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(50) DEFAULT NULL,
  `token` varchar(50) DEFAULT NULL,
  `isVerified` boolean default false,
  
  PRIMARY KEY (`users_id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
);