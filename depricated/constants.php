<?php
define("DEFAULT_DATABASE_HOST", "localhost");
define("DEFAULT_DATABASE_PORT", "3306");
define("DEFAULT_DATABASE", "romsync");
define("DEFAULT_USERNAME", "root");
define("DEFAULT_PASSWORD", "");

define("DEFAULT_YOUTUBE_KEY", "AIzaSyAzejE7EzH8BSE1arIe1P70t0ruZphqe9A");
define("DEFAULT_YOUTUBE_URL", "https://www.googleapis.com/youtube/v3/search?part=snippet&key=%s&type=video&q=%s");

define("DEFAULT_LOG_FOLDER", "../logs");
define("DEFAULT_IMAGES_FOLDER", "../images");
define("DEFAULT_ROM_FOLDER", "../roms");

define("DEFAULT_CONFIGFILE_LOCATION", "../");
define("DEFAULT_CONFIGFILE_NAME", "config.json");
define("DEFAULT_CONFIGFILE_PATH", DEFAULT_CONFIGFILE_LOCATION . DEFAULT_CONFIGFILE_NAME);

define("DBSTATUS_FAILED", "FAILED");
define("DBSTATUS_OK", "ACTIVE");

define("DBTABLE_ROMS", "roms");
define("DBTABLE_SYSTEMS", "systems");
define("DBTABLE_OPTIONS", "options");
