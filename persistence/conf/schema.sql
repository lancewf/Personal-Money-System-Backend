
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

#-----------------------------------------------------------------------------
#-- user
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `user`;


CREATE TABLE `user`
(
	`id` BIGINT  NOT NULL COMMENT 'facebook id',
	PRIMARY KEY (`id`)
)Type=MyISAM COMMENT='a user to the system';

#-----------------------------------------------------------------------------
#-- allotted
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `allotted`;


CREATE TABLE `allotted`
(
	`key` INTEGER  NOT NULL AUTO_INCREMENT COMMENT 'user Id and cookie',
	`user_id` BIGINT  NOT NULL COMMENT 'user Id',
	`startdate` DATETIME  NOT NULL COMMENT 'date time in line',
	`enddate` DATETIME  NOT NULL COMMENT 'date time in line',
	`billtype_key` INTEGER  NOT NULL COMMENT 'Foreign Key for billtype',
	`amount` DOUBLE  NOT NULL COMMENT 'The amount allotted',
	PRIMARY KEY (`key`),
	INDEX `allotted_FI_1` (`billtype_key`),
	CONSTRAINT `allotted_FK_1`
		FOREIGN KEY (`billtype_key`)
		REFERENCES `billtype` (`key`),
	INDEX `allotted_FI_2` (`user_id`),
	CONSTRAINT `allotted_FK_2`
		FOREIGN KEY (`user_id`)
		REFERENCES `user` (`id`)
)Type=MyISAM COMMENT='a user to the system';

#-----------------------------------------------------------------------------
#-- billtype
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `billtype`;


CREATE TABLE `billtype`
(
	`key` INTEGER  NOT NULL AUTO_INCREMENT COMMENT 'user Id and cookie',
	`user_id` BIGINT  NOT NULL COMMENT 'user Id',
	`name` VARCHAR(100) COMMENT 'name',
	`description` LONGTEXT COMMENT 'Description of the bill type',
	PRIMARY KEY (`key`),
	INDEX `billtype_FI_1` (`user_id`),
	CONSTRAINT `billtype_FK_1`
		FOREIGN KEY (`user_id`)
		REFERENCES `user` (`id`)
)Type=MyISAM COMMENT='user\'s itinerary';

#-----------------------------------------------------------------------------
#-- purchase
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `purchase`;


CREATE TABLE `purchase`
(
	`key` INTEGER  NOT NULL AUTO_INCREMENT COMMENT 'user Id and cookie',
	`user_id` BIGINT  NOT NULL COMMENT 'user Id',
	`store` VARCHAR(100) COMMENT 'name',
	`cost` DOUBLE  NOT NULL,
	`date` DATETIME  NOT NULL COMMENT 'date time in line',
	`notes` LONGTEXT COMMENT 'Description of the ride',
	`billtype_key` INTEGER  NOT NULL COMMENT 'Foreign Key for billtype',
	PRIMARY KEY (`key`),
	INDEX `purchase_FI_1` (`billtype_key`),
	CONSTRAINT `purchase_FK_1`
		FOREIGN KEY (`billtype_key`)
		REFERENCES `billtype` (`key`),
	INDEX `purchase_FI_2` (`user_id`),
	CONSTRAINT `purchase_FK_2`
		FOREIGN KEY (`user_id`)
		REFERENCES `user` (`id`)
)Type=MyISAM COMMENT='A ride on a itinerary';

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
