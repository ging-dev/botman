<?php

// >_ 2021 Gingdev

use BotMan\BotMan\BotMan;
use BotMan\BotMan\BotManFactory;
use BotMan\BotMan\Drivers\DriverManager;

require __DIR__.'/vendor/autoload.php';

DriverManager::loadDriver(\BotMan\Drivers\Facebook\FacebookDriver::class);

$config = [
    'facebook' => [
        'token'         => getenv('TOKEN'),
        'app_secret'    => getenv('SECRET'),
        'verification'  => getenv('VERIFY'),
    ]
];

$botman = BotManFactory::create($config);

$botman->hears('hello', function (BotMan $bot) {
    $bot->reply('Hello yourself.');
});

$botman->hears('dze', function (BotMan $bot) {
    $bot->reply('Bé Naga Tôn');
});

$botman->listen();
