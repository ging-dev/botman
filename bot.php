<?php

// >_ 2021 Gingdev

use Curl\Curl;
use BotMan\BotMan\BotMan;
use BotMan\BotMan\BotManFactory;
use BotMan\BotMan\Drivers\DriverManager;
use BotMan\BotMan\Messages\Attachments\Image;
use BotMan\BotMan\Messages\Outgoing\OutgoingMessage;

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
$curl   = new Curl();

$botman->hears('hello', function (BotMan $bot) {
    $bot->reply('Hello yourself.');
});

$botman->hears('dze', function (BotMan $bot) {
    $bot->reply('Bé Naga Tôn');
});

$botman->hears('hentai', function(BotMan $bot) use ($curl) {
    $curl->get('https://nekos.life/api/v2/img/hentai');
    $attachment = new Image($curl->response->url);
    $message = OutgoingMessage::create('Dame bro!!!')
        ->withAttachment($attachment);
    $bot->reply($message);
});

$botman->listen();
