CREATE TABLE `users`
(
    `id`       int(11) NOT NULL AUTO_INCREMENT,
    `username` varchar(100) NOT NULL,
    `password` varchar(100) NOT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

