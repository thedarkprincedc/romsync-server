<?php
return array(
    'jwt' => array(
        'key'       => 'jjoomojmojmoj',     // Key for signing the JWT's, I suggest generate it with base64_encode(openssl_random_pseudo_bytes(64))
        'algorithm' => 'HS512' // Algorithm used to sign the token, see https://tools.ietf.org/html/draft-ietf-jose-json-web-algorithms-40#section-3
        ),
    'database' => array(
        'user'     => 'jwt', // Database username
        'password' => 'jwt', // Database password
        'host'     => 'sp-simple-jwt-mysql', // Database host
        'name'     => 'jwt', // Database schema name
    ),
    'serverName' => 'romsync.thedarkprincedc.com',
);