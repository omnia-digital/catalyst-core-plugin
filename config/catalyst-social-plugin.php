<?php

return [
    'name' => 'Social',

    'max_followers' => 0,
    'max_following' => 9999,
    'max_follow_per_hour' => 100,

    'extends' => [
        'frontend' => 'catalyst-social::layouts.app',
    ],
];
