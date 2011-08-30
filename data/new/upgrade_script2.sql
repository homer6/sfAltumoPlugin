

SELECT * from information_schema.columns 
    WHERE 
        table_name = "country" AND 
        column_name = "updated_at" AND 
        table_schema = DATABASE()
        \G



IF EXISTS ( SELECT * FROM information_schema.columns WHERE table_name = 'country' AND column_name = 'created_at' AND table_schema = DATABASE() ) THEN
    ALTER TABLE `country` DROP COLUMN `created_at`;
END IF;
IF EXISTS ( SELECT * FROM information_schema.columns WHERE table_name = 'country' AND column_name = 'created_at' AND table_schema = DATABASE() ) THEN
    ALTER TABLE `country` DROP COLUMN `updated_at`;
END IF;
IF EXISTS ( SELECT * FROM information_schema.columns WHERE table_name = 'country' AND column_name = 'created_at' AND table_schema = DATABASE() ) THEN
    ALTER TABLE `country` DROP COLUMN `updated_at`;
END IF;


ALTER TABLE `country` DROP COLUMN `created_at`;
    DROP COLUMN `updated_at`,
    DROP KEY IF EXISTS `country_U_2`;

    
ALTER TABLE `country`
    ADD UNIQUE INDEX `country_U_2` ( `iso_code` );

    
    
    SELECT * FROM information_schema.columns WHERE table_name = 'country' AND table_schema = 'gst'
    SELECT TABLE_NAME, INDEX_NAME, COLUMN_NAME, CARDINALITY, INDEX_TYPE FROM information_schema.statistics WHERE INDEX_NAME != 'PRIMARY' AND table_schema = 'gst';