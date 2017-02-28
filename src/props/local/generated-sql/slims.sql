
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

-- ---------------------------------------------------------------------
-- biblio
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `biblio`;

CREATE TABLE `biblio`
(
    `biblio_id` INTEGER NOT NULL AUTO_INCREMENT,
    `title` TEXT NOT NULL,
    `sor` VARCHAR(200),
    `edition` VARCHAR(50),
    `isbn_issn` VARCHAR(20),
    `publisher_id` INTEGER,
    `publish_year` VARCHAR(20),
    `collation` VARCHAR(50),
    `series_title` VARCHAR(200),
    `call_number` VARCHAR(50),
    `language_id` CHAR(5),
    `source` VARCHAR(3),
    `publish_place_id` INTEGER,
    `classification` VARCHAR(40),
    `notes` TEXT,
    `image` VARCHAR(100),
    `file_att` VARCHAR(255),
    `opac_hide` SMALLINT(3),
    `promoted` SMALLINT(3),
    `labels` TEXT,
    `frequency_id` INTEGER,
    `spec_detail_info` TEXT,
    `input_date` DATETIME,
    `last_update` DATETIME,
    `uid` INTEGER,
    PRIMARY KEY (`biblio_id`),
    INDEX `biblio_fi_c8508e` (`publisher_id`),
    INDEX `biblio_fi_74bf54` (`language_id`),
    INDEX `biblio_fi_02e321` (`publish_place_id`),
    INDEX `biblio_fi_6d5f46` (`frequency_id`),
    INDEX `biblio_fi_a09038` (`uid`),
    CONSTRAINT `biblio_fk_c8508e`
        FOREIGN KEY (`publisher_id`)
        REFERENCES `mst_publisher` (`publisher_id`),
    CONSTRAINT `biblio_fk_74bf54`
        FOREIGN KEY (`language_id`)
        REFERENCES `mst_language` (`language_id`),
    CONSTRAINT `biblio_fk_02e321`
        FOREIGN KEY (`publish_place_id`)
        REFERENCES `mst_place` (`place_id`),
    CONSTRAINT `biblio_fk_6d5f46`
        FOREIGN KEY (`frequency_id`)
        REFERENCES `mst_frequency` (`frequency_id`),
    CONSTRAINT `biblio_fk_a09038`
        FOREIGN KEY (`uid`)
        REFERENCES `user` (`user_id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- mst_publisher
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `mst_publisher`;

CREATE TABLE `mst_publisher`
(
    `publisher_id` INTEGER NOT NULL AUTO_INCREMENT,
    `publisher_name` VARCHAR(100) NOT NULL,
    PRIMARY KEY (`publisher_id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- mst_language
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `mst_language`;

CREATE TABLE `mst_language`
(
    `language_id` CHAR(5) NOT NULL,
    `language_name` VARCHAR(20) NOT NULL,
    PRIMARY KEY (`language_id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- mst_place
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `mst_place`;

CREATE TABLE `mst_place`
(
    `place_id` INTEGER NOT NULL AUTO_INCREMENT,
    `place_name` VARCHAR(30) NOT NULL,
    PRIMARY KEY (`place_id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- mst_frequency
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `mst_frequency`;

CREATE TABLE `mst_frequency`
(
    `frequency_id` INTEGER NOT NULL AUTO_INCREMENT,
    `frequency` VARCHAR(25) NOT NULL,
    `language_prefix` VARCHAR(5),
    `time_increment` SMALLINT(6),
    `time_unit` VARCHAR(25),
    `input_date` DATETIME,
    `last_update` DATETIME,
    PRIMARY KEY (`frequency_id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- user
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `user`;

CREATE TABLE `user`
(
    `user_id` INTEGER NOT NULL AUTO_INCREMENT,
    `username` VARCHAR(50) NOT NULL,
    `realname` VARCHAR(100) NOT NULL,
    `password` VARCHAR(35) NOT NULL,
    `email` VARCHAR(200),
    `user_type` SMALLINT(2),
    `user_image` VARCHAR(250),
    `social_media` TEXT,
    `last_login` DATETIME,
    `last_login_ip` VARCHAR(15),
    `groups` VARCHAR(200),
    `api_key` VARCHAR(255),
    `input_date` DATETIME,
    `last_update` DATETIME,
    PRIMARY KEY (`user_id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- mst_author
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `mst_author`;

CREATE TABLE `mst_author`
(
    `author_id` INTEGER NOT NULL AUTO_INCREMENT,
    `author_name` VARCHAR(100) NOT NULL,
    PRIMARY KEY (`author_id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- biblio_author
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `biblio_author`;

CREATE TABLE `biblio_author`
(
    `biblio_id` INTEGER NOT NULL,
    `author_id` INTEGER NOT NULL,
    PRIMARY KEY (`biblio_id`,`author_id`),
    INDEX `biblio_author_fi_6b460f` (`author_id`),
    CONSTRAINT `biblio_author_fk_ea58a3`
        FOREIGN KEY (`biblio_id`)
        REFERENCES `biblio` (`biblio_id`),
    CONSTRAINT `biblio_author_fk_6b460f`
        FOREIGN KEY (`author_id`)
        REFERENCES `mst_author` (`author_id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- mst_topic
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `mst_topic`;

CREATE TABLE `mst_topic`
(
    `topic_id` INTEGER NOT NULL AUTO_INCREMENT,
    `topic` VARCHAR(50) NOT NULL,
    PRIMARY KEY (`topic_id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- biblio_topic
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `biblio_topic`;

CREATE TABLE `biblio_topic`
(
    `biblio_id` INTEGER NOT NULL,
    `topic_id` INTEGER NOT NULL,
    `level` INTEGER(1),
    PRIMARY KEY (`biblio_id`,`topic_id`),
    INDEX `biblio_topic_fi_fcb4f0` (`topic_id`),
    CONSTRAINT `biblio_topic_fk_ea58a3`
        FOREIGN KEY (`biblio_id`)
        REFERENCES `biblio` (`biblio_id`),
    CONSTRAINT `biblio_topic_fk_fcb4f0`
        FOREIGN KEY (`topic_id`)
        REFERENCES `mst_topic` (`topic_id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- item
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `item`;

CREATE TABLE `item`
(
    `item_id` INTEGER NOT NULL AUTO_INCREMENT,
    `item_code` VARCHAR(20) NOT NULL,
    `biblio_id` INTEGER NOT NULL,
    `call_number` VARCHAR(50),
    `coll_type_id` INTEGER(3),
    `inventory_code` VARCHAR(200),
    `received_date` DATE,
    `supplier_id` INTEGER,
    `order_no` VARCHAR(20),
    `location_id` VARCHAR(3),
    `order_date` DATE,
    `item_status_id` CHAR(3),
    `site` VARCHAR(50),
    `source` INTEGER(1),
    `invoice` VARCHAR(20),
    `price` INTEGER,
    `price_currency` VARCHAR(10),
    `invoice_date` DATE,
    `input_date` DATETIME,
    `last_update` DATETIME,
    `uid` INTEGER,
    PRIMARY KEY (`item_id`),
    UNIQUE INDEX `item_u_50194d` (`item_code`),
    INDEX `item_fi_ea58a3` (`biblio_id`),
    INDEX `item_fi_a09038` (`uid`),
    INDEX `item_fi_4cb78e` (`coll_type_id`),
    CONSTRAINT `item_fk_ea58a3`
        FOREIGN KEY (`biblio_id`)
        REFERENCES `biblio` (`biblio_id`),
    CONSTRAINT `item_fk_a09038`
        FOREIGN KEY (`uid`)
        REFERENCES `user` (`user_id`),
    CONSTRAINT `item_fk_4cb78e`
        FOREIGN KEY (`coll_type_id`)
        REFERENCES `mst_coll_type` (`coll_type_id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- mst_coll_type
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `mst_coll_type`;

CREATE TABLE `mst_coll_type`
(
    `coll_type_id` INTEGER NOT NULL AUTO_INCREMENT,
    `coll_type_name` VARCHAR(30) NOT NULL,
    `input_date` DATETIME,
    `last_update` DATETIME,
    PRIMARY KEY (`coll_type_id`)
) ENGINE=InnoDB;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
