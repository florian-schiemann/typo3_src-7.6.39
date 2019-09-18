<?php
$EM_CONF[$_EXTKEY] = [
    'title' => 'Scheduler',
    'description' => 'The TYPO3 Scheduler let\'s you register tasks to happen at a specific time',
    'category' => 'misc',
    'version' => '7.6.39',
    'state' => 'stable',
    'uploadfolder' => 0,
    'createDirs' => '',
    'clearcacheonload' => 0,
    'author' => 'Francois Suter',
    'author_email' => 'francois@typo3.org',
    'author_company' => '',
    'constraints' => [
        'depends' => [
            'typo3' => '7.6.39',
        ],
        'conflicts' => [
            'gabriel' => ''
        ],
        'suggests' => [],
    ],
];
