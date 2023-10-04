<?php

// config for OmniaDigital/Catalyst
return [
    'name' => 'Catalyst',

    'max_followers' => 0,
    'max_following' => 9999,
    'max_follow_per_hour' => 100,

    'extends' => [
        'frontend' => 'social::layouts.app',
    ],
];
