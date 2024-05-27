DROP TABLE IF EXISTS `books`;

CREATE TABLE `books` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(50) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` varchar(200) DEFAULT NULL,
  `author` varchar(100) NOT NULL,
  `isbn` varchar(500) DEFAULT NULL,
  `genre` varchar(50) NOT NULL,
  `language` varchar(50) NOT NULL,
  `publisher` varchar(100) DEFAULT NULL,
  `published_date` date DEFAULT NULL,
  `cover` varchar(255) DEFAULT NULL,
  `available` int(11) NOT NULL,
  `loan_count` int(11) DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8;