
CREATE DATABASE app_name
    CHARACTER SET utf8;

CREATE USER 
    'app_name'@'localhost' 
    IDENTIFIED BY 'testing123';

GRANT
    ALL ON app_name.* 
    TO 'app_name'@'localhost';
    
    
