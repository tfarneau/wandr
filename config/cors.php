<?php
return [
   'defaults' => [
       'supportsCredentials' => false,
       'allowedOrigins' => [],
       'allowedHeaders' => [],
       'allowedMethods' => [],
       'exposedHeaders' => [],
       'maxAge' => 0,
       'hosts' => [],
   ],

   'paths' => [
       'api/*' => [
           'allowedOrigins' => ['*'],
           'allowedHeaders' => ['*'],
           'allowedMethods' => ['*'],
           'maxAge' => 3600,
       ],
   ],
];
?>