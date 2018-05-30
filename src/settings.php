<?php
return [
    'settings' => [
        'displayErrorDetails' => true, // set to false in production
        'addContentLengthHeader' => false, // Allow the web server to send the content-length header

        // Renderer settings
        'renderer' => [
            'template_path' => __DIR__ . '/../templates/',
        ],

        // Monolog settings
        'logger' => [
            'name' => 'slim-app',
            'path' => __DIR__ . '/../logs/app.log',
            'level' => \Monolog\Logger::DEBUG,
        ],
        'database' => [
            'hostname' => (getenv("MYSQL_HOST"))?getenv("MYSQL_HOST"):'192.168.1.27',
            'port' => (getenv("MYSQL_PORT"))?getenv("MYSQL_PORT"):'27071',
            'database' => (getenv("MYSQL_DATABASE"))?getenv("MYSQL_DATABASE"):'romsync',
            'username' => (getenv("MYSQL_USER"))?getenv("MYSQL_USER"):'xbmc',
            'password' => (getenv("MYSQL_PASSWORD"))?getenv("MYSQL_PASSWORD"):'xbmc'
        ],
        'youtube' => [
          'key' => (getenv("YOUTUBE_API_KEY")) ? getenv("YOUTUBE_API_KEY") : "AIzaSyAzejE7EzH8BSE1arIe1P70t0ruZphqe9A",
          'search_tmpl_url' => "https://www.googleapis.com/youtube/v3/search?part=snippet&key=%s&type=video&q=%s"
        ],
        'locations' => [
             "rom_location" => (getenv("ROM_DEFAULT_FOLDER"))?getenv("ROM_DEFAULT_FOLDER"):"/roms",
             'image_location'=> (getenv("IMAGE_DEFAULT_FOLDER"))?getenv("IMAGE_DEFAULT_FOLDER"):"/images"
        ],
        'name' => 'romsync-resources',
        'version' => '2.0.1',
        'urlPrefix' => '/api',
        'HMAC_SECRET' => 'Pillsbury'
    ],
];
