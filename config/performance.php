<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Performance Cache Settings
    |--------------------------------------------------------------------------
    |
    | Configure cache durations for different types of data
    |
    */

    'cache' => [
        'categories' => [
            'ttl' => env('CACHE_CATEGORIES_TTL', 3600), // 1 hour
        ],
        'kendaraan_stats' => [
            'ttl' => env('CACHE_KENDARAAN_STATS_TTL', 1800), // 30 minutes
        ],
        'similar_motors' => [
            'ttl' => env('CACHE_SIMILAR_MOTORS_TTL', 1800), // 30 minutes
        ],
        'brands' => [
            'ttl' => env('CACHE_BRANDS_TTL', 1800), // 30 minutes
        ],
        'store_data' => [
            'ttl' => env('CACHE_STORE_DATA_TTL', 900), // 15 minutes
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Database Query Optimizations
    |--------------------------------------------------------------------------
    |
    | Configure database-related performance settings
    |
    */

    'database' => [
        'pagination' => [
            'per_page' => env('DB_PAGINATION_PER_PAGE', 10),
            'store_per_page' => env('DB_STORE_PAGINATION_PER_PAGE', 12),
        ],
        'eager_loading' => [
            'default_relations' => ['dokumen', 'categories'],
            'minimal_relations' => ['categories'],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Image Processing
    |--------------------------------------------------------------------------
    |
    | Configure image upload and processing limits
    |
    */

    'images' => [
        'max_photos_per_kendaraan' => env('MAX_PHOTOS_PER_KENDARAAN', 10),
        'max_file_size' => env('MAX_PHOTO_SIZE', 2048), // KB
        'allowed_types' => ['jpg', 'jpeg', 'png', 'gif'],
        'thumbnails' => [
            'generate' => env('GENERATE_THUMBNAILS', true),
            'sizes' => [
                'small' => ['width' => 150, 'height' => 150],
                'medium' => ['width' => 300, 'height' => 300],
                'large' => ['width' => 800, 'height' => 600],
            ]
        ]
    ],

    /*
    |--------------------------------------------------------------------------
    | Monitoring & Logging
    |--------------------------------------------------------------------------
    |
    | Configure performance monitoring settings
    |
    */

    'monitoring' => [
        'slow_query_threshold' => env('SLOW_QUERY_THRESHOLD', 1000), // milliseconds
        'slow_request_threshold' => env('SLOW_REQUEST_THRESHOLD', 1.0), // seconds
        'log_slow_requests' => env('LOG_SLOW_REQUESTS', true),
        'log_memory_usage' => env('LOG_MEMORY_USAGE', false),
    ],

    /*
    |--------------------------------------------------------------------------
    | Response Optimization
    |--------------------------------------------------------------------------
    |
    | Configure response compression and optimization
    |
    */

    'response' => [
        'gzip_compression' => env('RESPONSE_GZIP', true),
        'minify_html' => env('RESPONSE_MINIFY_HTML', true),
        'cache_static_assets' => env('CACHE_STATIC_ASSETS', true),
        'asset_versioning' => env('ASSET_VERSIONING', true),
    ],
];
