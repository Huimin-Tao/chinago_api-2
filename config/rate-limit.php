<?php

return [
    'limiters' => [
        'api' => [
            'driver' => 'cache', // O 'redis' si usas Redis
            'key' => 'api|%s',
            'max_attempts' => 60,
            'decay_minutes' => 1,
        ],
    ],
];