SET @@foreign_key_checks = 0;

-- ------------------------------------------------------------------------------
-- Add denonym to country model
DROP TABLE IF EXISTS `_temp_country`;

CREATE TABLE `_temp_country` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `name` varchar(64) NOT NULL,
 `iso_code` varchar(12) NOT NULL,
 `iso_short_code` varchar(2) NOT NULL,
 `demonym` varchar(128) NOT NULL,
 KEY `index_name` ( `name` ),
 PRIMARY KEY  ( `id` ),
 UNIQUE INDEX `unique_iso_code` ( `iso_code` ),
 UNIQUE INDEX `unique_iso_short_code` ( `iso_short_code` )
)
ENGINE = InnoDB
CHARACTER SET = utf8
COLLATE = utf8_unicode_ci
ROW_FORMAT = COMPACT;

INSERT INTO `_temp_country`(`id`,
                                               `iso_code`,
                                               `iso_short_code`,
                                               `name`)
   SELECT `id`,
          `iso_code`,
          `iso_short_code`,
          `name`
     FROM `country`;

DROP TABLE `country`;

ALTER TABLE `_temp_country` RENAME `country`;

UPDATE `country` SET `demonym` = 'American' WHERE `iso_code` = 'USA';
UPDATE `country` SET `demonym` = 'Canadian' WHERE `iso_code` = 'CAN';


-- ------------------------------------------------------------------------------
-- Change the length of the iso code to accommodate australia
DROP TABLE IF EXISTS `_temp_state`;

CREATE TABLE `_temp_state` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `name` varchar(64) NOT NULL,
 `iso_code` varchar(12) NOT NULL,
 `iso_short_code` varchar(4) NOT NULL,
 `country_id` int(11) NOT NULL,
 `created_at` datetime DEFAULT NULL,
 `updated_at` datetime DEFAULT NULL,
 KEY `index_name` ( `name` ),
 PRIMARY KEY  ( `id` ),
 UNIQUE INDEX `unique_country_iso_short_code` ( `country_id`, `iso_short_code` ),
 UNIQUE INDEX `unique_iso_code` ( `iso_code` )
)
ENGINE = InnoDB
CHARACTER SET = utf8
COLLATE = utf8_unicode_ci
ROW_FORMAT = COMPACT;

INSERT INTO `_temp_state`(                   `country_id`,
                                             `created_at`,
                                             `id`,
                                             `iso_code`,
                                             `iso_short_code`,
                                             `name`,
                                             `updated_at`)
   SELECT `country_id`,
          `created_at`,
          `id`,
          `iso_code`,
          `iso_short_code`,
          `name`,
          `updated_at`
     FROM `state`;

DROP TABLE `state`;

ALTER TABLE `_temp_state` RENAME `state`;

ALTER TABLE `state` ADD CONSTRAINT `state_FK_1`
 FOREIGN KEY ( `country_id` ) REFERENCES `country` ( `id` ) ON DELETE CASCADE;
 
SET @@foreign_key_checks = 1;

-- ------------------------------------------------------------------------------
-- Add Australia
INSERT INTO `country` (
    `id` ,
    `name` ,
    `iso_code` ,
    `iso_short_code`,
    `demonym`
)
VALUES (
    NULL , 'Australia', 'AUS', 'AU', 'Australian'
);

SET @australia = (SELECT `id` FROM `country` WHERE `iso_code` = 'AUS' LIMIT 1);

INSERT INTO 
    `state` ( `name`, `iso_code`, `iso_short_code`, `country_id` )
VALUES
    ( 'New South Wales',                'AU-NSW',   'NSW',  @australia ),
    ( 'Queensland',                     'AU-QLD',   'QLD',  @australia ),
    ( 'South Australia',                'AU-SA',    'SA',   @australia ),
    ( 'Tasmania',                       'AU-TAS',   'TAS',  @australia ),
    ( 'Victoria',                       'AU-VIC',   'VIC',  @australia ),
    ( 'Western Australia',              'AU-WA',    'WA',   @australia ),
    ( 'Australian Capital Territory',   'AU-ACT',   'ACT',  @australia ),
    ( 'Northern Territory',             'AU-NT',    'NT',   @australia );

    
    
    
    
    
-- ------------------------------------------------------------------------------
-- Add New Zealand
INSERT INTO `country` (
    `id` ,
    `name` ,
    `iso_code` ,
    `iso_short_code`,
    `demonym`
)
VALUES (
    NULL , 'New Zealand', 'NZL', 'NZ', 'New Zealander'
);

SET @new_zealand = (SELECT `id` FROM `country` WHERE `iso_code` = 'NZL' LIMIT 1);


INSERT INTO 
    `state` ( `name`, `iso_code`, `iso_short_code`, `country_id` )
VALUES
    ( 'Auckland',   'NZ-AUK',   'AUK',  @new_zealand ),
    ( 'Bay of Plenty',   'NZ-BOP',   'BOP',  @new_zealand ),
    ( 'Canterbury',   'NZ-CAN',   'CAN',  @new_zealand ),
    ( "Hawke's Bay",   'NZ-HKB',   'HKB',  @new_zealand ),
    ( 'Manawatu-Wanganui',   'NZ-MWT',   'MWT',  @new_zealand ),
    ( 'Northland',   'NZ-NTL',   'NTL',  @new_zealand ),
    ( 'Otago',   'NZ-OTA',   'OTA',  @new_zealand ),
    ( 'Southland',   'NZ-STL',   'STL',  @new_zealand ),
    ( 'Taranaki',   'NZ-TKI',   'TKI',  @new_zealand ),
    ( 'Waikato',   'NZ-WKO',   'WKO',  @new_zealand ),
    ( 'Wellington',   'NZ-WGN',   'WGN',  @new_zealand ),
    ( 'West Coast',   'NZ-WTC',   'WTC',  @new_zealand ),
    ( 'Gisborne District',   'NZ-GIS',   'GIS',  @new_zealand ),
    ( 'Marlborough District',   'NZ-MBH',   'MBH',  @new_zealand ),
    ( 'Nelson City',   'NZ-NSN',   'NSN',  @new_zealand ),
    ( 'Tasman District',   'NZ-TAS',   'TAS',  @new_zealand ),
    ( 'Chatham Islands Territory',   'NZ-CIT',   'CIT',  @new_zealand ),
    ( 'North Island',   'NZ-N',   'N',  @new_zealand ),
    ( 'Suth Island',   'NZ-S',   'S',  @new_zealand );
    
SET @@foreign_key_checks = 1;




SET @@foreign_key_checks = 0;



-- -----------------------------------------------------------------------------
-- create table currency
CREATE TABLE `currency` (
    `id` int(11) NOT NULL auto_increment,
    `name` varchar(64) NOT NULL,
    `iso_code` varchar(3) NOT NULL,
    `iso_number` varchar(3) NOT NULL,
    PRIMARY KEY  ( `id` )
)
ENGINE = InnoDB
CHARACTER SET = utf8
COLLATE = utf8_unicode_ci
AUTO_INCREMENT = 1
ROW_FORMAT = Compact
;



-- -----------------------------------------------------------------------------
-- create table add FK to currency from country
DROP TABLE IF EXISTS `_temp_country`;

CREATE TABLE `_temp_country` (
    `id` int(11) NOT NULL auto_increment,
    `name` varchar(64) NOT NULL,
    `iso_code` varchar(12) NOT NULL,
    `iso_short_code` varchar(2) NOT NULL,
    `demonym` varchar(128) NOT NULL,
    `default_currency_id` int(11) default NULL,
    KEY `country_FI_1` ( `default_currency_id` ),
    KEY `index_name` ( `name` ),
    PRIMARY KEY  ( `id` ),
    UNIQUE INDEX `unique_iso_code` ( `iso_code` ),
    UNIQUE INDEX `unique_iso_short_code` ( `iso_short_code` )
)
ENGINE = InnoDB
CHARACTER SET = utf8
COLLATE = utf8_unicode_ci
AUTO_INCREMENT = 5
ROW_FORMAT = Compact
;

INSERT INTO `_temp_country`
( `demonym`, `id`, `iso_code`, `iso_short_code`, `name` )
SELECT
`demonym`, `id`, `iso_code`, `iso_short_code`, `name`
FROM `country`;

DROP TABLE `country`;

ALTER TABLE `_temp_country` RENAME `country`;

ALTER TABLE `country` ADD CONSTRAINT `country_FK_1`
    FOREIGN KEY ( `default_currency_id` ) REFERENCES `currency` ( `id` ) ON DELETE CASCADE;

    
    
    
    
    
SET @@foreign_key_checks = 1;