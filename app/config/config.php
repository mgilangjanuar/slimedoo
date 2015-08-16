<?php

$config = [
    'dir' => '/slimedoo',
    'name' => 'SliMedoo Framework v2',
    'defaultFunction' => 'actionIndex',
    'timezone' => 'Asia/Jakarta',
    'db'  => [
        'database_type' => 'sqlite',
        'database_file' => 'app/config/database/db.sqlite'
    ],
    /** 
    *  example for mysql configuration
    * 
    *  'db' => [
    *      'database_type' => 'mysql',
    *      'database_name' => 'name',
    *      'server' => 'localhost',
    *      'username' => 'your_username',
    *      'password' => 'your_password',
    *      'charset' => 'utf8',
    *  ],
    */ 
];