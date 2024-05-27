DROP TABLE IF EXISTS `loans`;

CREATE TABLE `loans` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `book_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `borrow_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `return_date` datetime NOT NULL,
  `status` enum('BORROWED', 'RETURNED') DEFAULT 'BORROWED',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `book_id_index` (`book_id`),
  KEY `user_id_index` (`user_id`),
  CONSTRAINT `FK_book_id` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8;

;