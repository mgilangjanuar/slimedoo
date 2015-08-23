<?php

$config = [
    'name' => 'SliMedoo Framework v2',
    'timezone' => 'Asia/Jakarta',
    'db' => [
        'database_type' => 'mysql',
        'database_name' => 'slimedoo',
        'server' => 'localhost',
        'username' => 'root',
        'password' => 'root',
        'charset' => 'utf8',
     ],
     'role' => [
        'theCreator', // role for user first register (must be set at this position)
        'user', // default role (must be set at this position)
        'admin', 
    ]
];