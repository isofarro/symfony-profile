
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

#-----------------------------------------------------------------------------
#-- site
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `site`;


CREATE TABLE `site`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`title` VARCHAR(255),
	`baseurl` VARCHAR(255)  NOT NULL,
	PRIMARY KEY (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- feed
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `feed`;


CREATE TABLE `feed`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`title` VARCHAR(255),
	`link` VARCHAR(255)  NOT NULL,
	`website` VARCHAR(255)  NOT NULL,
	`type` VARCHAR(32),
	PRIMARY KEY (`id`),
	UNIQUE KEY `feed_U_1` (`link`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- sitefeed
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `sitefeed`;


CREATE TABLE `sitefeed`
(
	`site_id` INTEGER  NOT NULL,
	`feed_id` INTEGER  NOT NULL,
	`collection` VARCHAR(32),
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	PRIMARY KEY (`id`),
	INDEX `sitefeed_FI_1` (`site_id`),
	CONSTRAINT `sitefeed_FK_1`
		FOREIGN KEY (`site_id`)
		REFERENCES `site` (`id`),
	INDEX `sitefeed_FI_2` (`feed_id`),
	CONSTRAINT `sitefeed_FK_2`
		FOREIGN KEY (`feed_id`)
		REFERENCES `feed` (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- item
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `item`;


CREATE TABLE `item`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`feed_id` INTEGER  NOT NULL,
	`atomid` VARCHAR(255)  NOT NULL,
	`title` TEXT  NOT NULL,
	`link` VARCHAR(255)  NOT NULL,
	`description` TEXT  NOT NULL,
	`published` DATETIME  NOT NULL,
	PRIMARY KEY (`id`),
	UNIQUE KEY `item_U_1` (`atomid`),
	UNIQUE KEY `item_U_2` (`link`),
	INDEX `item_FI_1` (`feed_id`),
	CONSTRAINT `item_FK_1`
		FOREIGN KEY (`feed_id`)
		REFERENCES `feed` (`id`)
)Type=InnoDB;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
