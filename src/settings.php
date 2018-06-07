<?php
return [
    'settings' => [
        'displayErrorDetails' => true, // set to false in production
        'addContentLengthHeader' => false, // Allow the web server to send the content-length header
        // Only set this if you need access to route within middleware
        'determineRouteBeforeAppMiddleware' => true,
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
        'keys' => [
            'youtube' => 'AIzaSyAzejE7EzH8BSE1arIe1P70t0ruZphqe9A'
        ],
        'url' => [
            'youtube_search' => 'https://www.googleapis.com/youtube/v3/search',
            'youtube_embed' => 'https://www.youtube.com/embed/',
            'gamesdb_search' => 'http://thegamesdb.net/api/GetGame.php'
        ],
        'mysql' => [
            'hostname' => '192.168.2.27',
            'port' => '3307',
            'database' => 'romsync',
            'username' => 'romsync_admin',
            'password' => 'DricasM4x'
        ],
        'sqlite' => [
            'path' => '/tmp/dbfile.txt'
        ],
        'locations' => [
            'roms' => 'roms',
            'images' => 'images'
        ],
        'app' => [
            'name' => 'romsync-resources',
            'version' => '2.0.1',
            'urlPrefix' => '/api',
            'loginRedirectUri' => 'http://localhost:3000/#/index'
        ],
        'jwt' => [
            'key'       => 'jjoomojmojmoj',    
            'algorithm' => 'HS512' 
        ],
        'serverName' => 'romsync.thedarkprincedc.com'
    ]
];
