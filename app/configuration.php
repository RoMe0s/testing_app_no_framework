<?php

use App\Configuration;
use App\FileHelper;

if (file_exists(FileHelper::rootPath('.env'))) {
    $dotenv = \Dotenv\Dotenv::createImmutable(FileHelper::rootPath());
    $dotenv->load();
    unset($dotenv);
}

$getFromEnvironment = fn(string $key, $default = null) => getenv($key, true) ?: $default;

return [
    'app_name' => $getFromEnvironment('APP_NAME', 'test_app_name'),
    'app_key' => $getFromEnvironment('APP_KEY', '12345'),
    'env' => $getFromEnvironment('APP_ENV', Configuration::DEV_ENV),

    'database' => [
        'driver' => $getFromEnvironment('DB_DRIVER', 'pdo_mysql'),
        'host' => $getFromEnvironment('DB_HOST', 'mysql'),
        'user' => $getFromEnvironment('DB_USER', 'root'),
        'password' => $getFromEnvironment('DB_PWD', 'root'),
        'dbname' => $getFromEnvironment('DB_NAME', 'test_db'),
    ],

    'doctrine' => [
        'path_to_entities' => [
            FileHelper::rootPath('Domain'),
        ],
    ],
];
