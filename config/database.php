<?php

use Illuminate\Support\Str;

if(isset($_SERVER['SERVER_NAME']) && !empty($_SERVER['SERVER_NAME']) && $_SERVER['SERVER_NAME'] == "oscblog.local" || $_SERVER['SERVER_NAME'] == "osc-blog.local"){
  define('ENVIRONMENT', "development");
}elseif(isset($_SERVER['SERVER_NAME']) && !empty($_SERVER['SERVER_NAME']) && $_SERVER['SERVER_NAME'] == "192.168.0.99"){
  define('ENVIRONMENT', "testing");
}elseif(isset($_SERVER['SERVER_NAME']) && !empty($_SERVER['SERVER_NAME']) && ($_SERVER['SERVER_NAME'] != "oscblog.local" || $_SERVER['SERVER_NAME'] != "192.168.0.99")){
  define('ENVIRONMENT', "live");
}else{
  // define('ENVIRONMENT', "development");
  define('ENVIRONMENT', "testing");
  // define('ENVIRONMENT', "live");
}

if(defined("ENVIRONMENT") && ENVIRONMENT == "development"){
  define('DRIVER', 'mysql');
  define('HOST', 'localhost');
  define('PORT', '3306');
  define('DATABASE', 'oscblog');
  define('USERNAME', 'oscblog_user');
  define('PASSWORD', 'TVfSOQMttX0Gm35g');
  define('UNIX_SOCKET', '/Applications/MAMP/tmp/mysql/mysql.sock');
  define('CHARSET', 'utf8mb4');
  define('COLLATION', 'utf8mb4_unicode_ci');
  define('PREFIX', '');
  define('PREFIX_INDEXES', true);
  define('STRICT', true);
  define('ENGINE', null);
  define('OPTIONS', extension_loaded('pdo_mysql') ? array_filter([PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),]) : []);
}elseif(defined("ENVIRONMENT") && ENVIRONMENT == "testing"){
  define('DRIVER', 'mysql');
  define('HOST', '192.168.0.99');
  define('PORT', '3306');
  define('DATABASE', 'osc_blog');
  define('USERNAME', 'admin');
  define('PASSWORD', '55NLYTe6');
  // define('UNIX_SOCKET', '/var/run/mysqld/mysqld.sock');
  define('UNIX_SOCKET', '');
  define('CHARSET', 'utf8mb4');
  define('COLLATION', 'utf8mb4_unicode_ci');
  define('PREFIX', '');
  define('PREFIX_INDEXES', true);
  define('STRICT', true);
  define('ENGINE', null);
  define('OPTIONS', extension_loaded('pdo_mysql') ? array_filter([PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),]) : []);
}elseif(defined("ENVIRONMENT") && ENVIRONMENT == "live"){
  define('DRIVER', 'mysql');
  define('HOST', '');
  define('PORT', '3306');
  define('DATABASE', '');
  define('USERNAME', '');
  define('PASSWORD', '');
  define('UNIX_SOCKET', '');
  define('CHARSET', 'utf8mb4');
  define('COLLATION', 'utf8mb4_unicode_ci');
  define('PREFIX', '');
  define('PREFIX_INDEXES', true);
  define('STRICT', true);
  define('ENGINE', null);
  define('OPTIONS', extension_loaded('pdo_mysql') ? array_filter([PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),]) : []);
}else{
  define('DRIVER', 'mysql');
  define('HOST', '');
  define('PORT', '3306');
  define('DATABASE', '');
  define('USERNAME', '');
  define('PASSWORD', '');
  define('UNIX_SOCKET', '');
  define('CHARSET', 'utf8mb4');
  define('COLLATION', 'utf8mb4_unicode_ci');
  define('PREFIX', '');
  define('PREFIX_INDEXES', true);
  define('STRICT', true);
  define('ENGINE', null);
  define('OPTIONS', extension_loaded('pdo_mysql') ? array_filter([PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),]) : []);
}

return [

    /*
    |--------------------------------------------------------------------------
    | Default Database Connection Name
    |--------------------------------------------------------------------------
    |
    | Here you may specify which of the database connections below you wish
    | to use as your default connection for all database work. Of course
    | you may use many connections at once using the Database library.
    |
    */

    'default' => env('DB_CONNECTION', 'mysql'),

    /*
    |--------------------------------------------------------------------------
    | Database Connections
    |--------------------------------------------------------------------------
    |
    | Here are each of the database connections setup for your application.
    | Of course, examples of configuring each database platform that is
    | supported by Laravel is shown below to make development simple.
    |
    |
    | All database work in Laravel is done through the PHP PDO facilities
    | so make sure you have the driver for your particular database of
    | choice installed on your machine before you begin development.
    |
    */

    'connections' => [

        // 'sqlite' => [
        //     'driver' => 'sqlite',
        //     'database' => env('DB_DATABASE', database_path('database.sqlite')),
        //     'prefix' => '',
        //     'foreign_key_constraints' => env('DB_FOREIGN_KEYS', true),
        // ],

        'mysql' => [
            'driver' => DRIVER,
            'host' => HOST,
            'port' => PORT,
            'database' => DATABASE,
            'username' => USERNAME,
            'password' => PASSWORD,
            'unix_socket' => UNIX_SOCKET,
            'charset' => CHARSET,
            'collation' => COLLATION,
            'prefix' => PREFIX,
            'prefix_indexes' => PREFIX_INDEXES,
            'strict' => STRICT,
            'engine' => ENGINE,
            'options' => OPTIONS,
        ],

        // 'pgsql' => [
        //     'driver' => 'pgsql',
        //     'host' => env('DB_HOST', '127.0.0.1'),
        //     'port' => env('DB_PORT', '5432'),
        //     'database' => env('DB_DATABASE', 'forge'),
        //     'username' => env('DB_USERNAME', 'forge'),
        //     'password' => env('DB_PASSWORD', ''),
        //     'charset' => 'utf8',
        //     'prefix' => '',
        //     'prefix_indexes' => true,
        //     'schema' => 'public',
        //     'sslmode' => 'prefer',
        // ],

        // 'sqlsrv' => [
        //     'driver' => 'sqlsrv',
        //     'host' => env('DB_HOST', 'localhost'),
        //     'port' => env('DB_PORT', '1433'),
        //     'database' => env('DB_DATABASE', 'forge'),
        //     'username' => env('DB_USERNAME', 'forge'),
        //     'password' => env('DB_PASSWORD', ''),
        //     'charset' => 'utf8',
        //     'prefix' => '',
        //     'prefix_indexes' => true,
        // ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Migration Repository Table
    |--------------------------------------------------------------------------
    |
    | This table keeps track of all the migrations that have already run for
    | your application. Using this information, we can determine which of
    | the migrations on disk haven't actually been run in the database.
    |
    */

    'migrations' => 'migrations',

    /*
    |--------------------------------------------------------------------------
    | Redis Databases
    |--------------------------------------------------------------------------
    |
    | Redis is an open source, fast, and advanced key-value store that also
    | provides a richer body of commands than a typical key-value system
    | such as APC or Memcached. Laravel makes it easy to dig right in.
    |
    */

    // 'redis' => [
    //
    //     'client' => env('REDIS_CLIENT', 'predis'),
    //
    //     'options' => [
    //         'cluster' => env('REDIS_CLUSTER', 'predis'),
    //         'prefix' => Str::slug(env('APP_NAME', 'laravel'), '_').'_database',
    //     ],
    //
    //     'default' => [
    //         'host' => env('REDIS_HOST', '127.0.0.1'),
    //         'password' => env('REDIS_PASSWORD', null),
    //         'port' => env('REDIS_PORT', 6379),
    //         'database' => env('REDIS_DB', 0),
    //     ],
    //
    //     'cache' => [
    //         'host' => env('REDIS_HOST', '127.0.0.1'),
    //         'password' => env('REDIS_PASSWORD', null),
    //         'port' => env('REDIS_PORT', 6379),
    //         'database' => env('REDIS_CACHE_DB', 1),
    //     ],
    //
    // ],

];
