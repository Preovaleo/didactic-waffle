CREATE TABLE `minified` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `token` varchar(100) NOT NULL,
  `url` varchar(4000) NOT NULL,
  CONSTRAINT minified_PK PRIMARY KEY (`id`)
  CONSTRAINT minified_UN UNIQUE KEY (`token`)
)
ENGINE=InnoDB
DEFAULT CHARSET=utf8
COLLATE=utf8_general_ci ;

CREATE TABLE minifier_db.`user` (
	id INT UNSIGNED NULL AUTO_INCREMENT,
	username varchar(100) NOT NULL,
	hash varchar(60) NOT NULL,
	CONSTRAINT user_PK PRIMARY KEY (`id`),
	CONSTRAINT user_UN UNIQUE KEY (`username`)
)
ENGINE=InnoDB
DEFAULT CHARSET=utf8
COLLATE=utf8_general_ci ;
