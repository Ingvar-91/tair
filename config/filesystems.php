<?php

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
	
	'categories' => [
        'path' => 'img/categories/',
        'resolution' => ['width' => 250, 'height' => 250]
    ],
    'avatars' => [
        'path' => 'img/avatars/',
        'resolution' => ['width' => 130, 'height' => 130]
    ],
    'preview_frontpage' => [
        'path' => 'img/preview_frontpage/',
        'resolution' => ['width' => 320, 'height' => 182]
    ],
    'logo' => [
        'path' => 'img/logo/',
        'resolution' => ['height' => 70]
    ],
    'logo_brands' => [
        'path' => 'img/logo_brands/',
        'resolution' => [
            'x3' => ['width' => 200, 'height' => 60]
        ]
    ],
    'slider' => [
        'path' => 'img/slider/',
        'resolution' => [
            'x3' => ['width' => 1280, 'height' => 500],
            'x1' => ['width' => 320, 'height' => 124]
        ]
    ],
    'shops_gallery' => [
        'path' => 'img/shops_gallery/',
        'resolution' => [
            'x3' => ['width' => null, 'height' => 800],
            'x2' => ['width' => null, 'height' => 400],
            'x1' => ['width' => null, 'height' => 200]
        ]
    ],
    'shops' => [
        'path' => 'img/shops/',
        'resolution' => [
            'x3' => ['width' => 1280, 'height' => 500],
            'x2' => ['width' => 640, 'height' => 250],
            'x1' => ['width' => 320, 'height' => 125]
        ]
    ],
    'products' => [
        'path' => 'img/products/',
        'resolution' => [
            'x3' => ['width' => 900, 'height' => 900],
            'x2' => ['width' => 350, 'height' => 350],
            'x1' => ['width' => 150, 'height' => 150]
        ]
    ],

    'disks' => [

        'local' => [
            'driver' => 'local',
            //'root' => storage_path('app'),
			'root' => base_path('public'),
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
