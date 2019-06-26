<?php

ini_set('post_max_size', '64M');
ini_set('upload_max_filesize', '64M');

!defined('PUBLIC_FOLDER') ? define ('PUBLIC_FOLDER', "/public") : "";
!defined('STORAGE_FOLDER') ? define ('STORAGE_FOLDER', "/storage") : "";
!defined('STORAGE_FOLDER_WITH_PUBLIC_FOLDER') ? define ('STORAGE_FOLDER_WITH_PUBLIC_FOLDER', "/public/storage") : "";

!defined('IMAGES_FOLDER') ? define ('IMAGES_FOLDER', "/images") : "";
!defined('TEMP_FOLDER') ? define ('TEMP_FOLDER', "/temp") : "";

!defined('FRONTEND_IMAGES_FOLDER') ? define ('FRONTEND_IMAGES_FOLDER', "/frontend/images") : "";

!defined('USERS_TEMP_FOLDER') ? define ('USERS_TEMP_FOLDER', "/users") : "";
!defined('USER_PROFILE_IMAGES_FOLDER') ? define ('USER_PROFILE_IMAGES_FOLDER', "/profile_images") : "";
!defined('POST_IMAGES_FOLDER') ? define ('POST_IMAGES_FOLDER', "/post_images") : "";
!defined('MEDIA_ITEMS_FOLDER') ? define ('MEDIA_ITEMS_FOLDER', "/media_items") : "";

!defined('POST_IMAGES_NO_IMAGE_FILE') ? define ('POST_IMAGES_NO_IMAGE_FILE', "no-image.png") : "";
!defined('USER_PROFILE_IMAGES_NO_IMAGE_FILE') ? define ('USER_PROFILE_IMAGES_NO_IMAGE_FILE', "no-image-logo.png") : "";

return [

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default filesystem disk that should be used
    | by the framework. The "local" disk, as well as a variety of cloud
    | based disks are available to your application. Just store away!
    |
    */

    'default' => env('FILESYSTEM_DRIVER', 'local'),

    /*
    |--------------------------------------------------------------------------
    | Default Cloud Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Many applications store files both locally and in the cloud. For this
    | reason, you may specify a default "cloud" driver here. This driver
    | will be bound as the Cloud disk implementation in the container.
    |
    */

    'cloud' => env('FILESYSTEM_CLOUD', 's3'),

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Here you may configure as many filesystem "disks" as you wish, and you
    | may even configure multiple disks of the same driver. Defaults have
    | been setup for each driver as an example of the required options.
    |
    | Supported Drivers: "local", "ftp", "sftp", "s3", "rackspace"
    |
    */

    'disks' => [

        'local' => [
            'driver' => 'local',
            'root' => storage_path('app'),
        ],

        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'public',
        ],

        's3' => [
            'driver' => 's3',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION'),
            'bucket' => env('AWS_BUCKET'),
            'url' => env('AWS_URL'),
        ],

    ],



];
