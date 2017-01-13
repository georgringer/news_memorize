<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'Memorize news records',
    'description' => 'Add news records to a personal list',
    'category' => 'plugin',
    'author' => 'Georg Ringer',
    'author_email' => '',
    'state' => 'beta',
    'internal' => '',
    'uploadfolder' => 0,
    'createDirs' => '',
    'clearCacheOnLoad' => 0,
    'version' => '1.0.0',
    'constraints' => [
        'depends' => [
            'typo3' => '7.6.0-8.9.99',
            'news' => '3.2.0-8.9.99',
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
];
