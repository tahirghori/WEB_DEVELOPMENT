<?php

define('TIME_ZONE_COUNTRY_DEFAULT', 'Asia/Karachi');
define('MIGRATION_FOLDER_PATH', $_SERVER['DOCUMENT_ROOT'].str_replace('index.php', '', $_SERVER['SCRIPT_NAME'])."application/migrations/");
define('PREFRANCE_FILE_NAME', 'db_prefrance.php');

define('AUTO_CONFIG_PATH', $_SERVER['DOCUMENT_ROOT'].str_replace('index.php', '', $_SERVER['SCRIPT_NAME'])."application/config/".PREFRANCE_FILE_NAME);
define('DB_CONFIGURATION_FORM', $_SERVER['DOCUMENT_ROOT'].str_replace('index.php', '', $_SERVER['SCRIPT_NAME'])."application/views/do_config_form.php");
define('DATABASE_BACKUP_PATH', "db_backups/");


define('CREAE_DB', 'CREAE_DB');
define('UPDATE_DB', 'UPDATE_DB');
define('SETTINGS', 'SETTINGS');
define('IMPORT', 'IMPORT');
define('EXPORT', 'EXPORT');



define('AUTO_MIGRATION', 'ON');
define('MIGRATION_VERSION', '6');







 ?>