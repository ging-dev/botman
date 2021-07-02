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

// Only work in php 7.4
$botman->hears('{message}', function(BotMan $bot, $message) use ($curl) {
    $curl->get('https://secureapp.simsimi.com/v1/simsimi/talkset', [
        'uid' => '306320877',
        'av' => '6.9.5.1',
        'ak' => 'cS7nbNTWYV4wHOJA3rdfhtytk2c=',
        'session' => 'DVvvKBWbfDaH4jWADVP7jB1ZMmF7kZTk4RhBY4ZbqAVbsabYzb66TLax5xCymNx1UhaPtEavdNn43SgRqRDYTSA5',
        'cc' => 'VN',
        'tz' => 'Asia/Saigon',
        'os' => 'a',
        'lc' => 'vn',
        'message_sentence' => $message,
        'normalProb' => 2,
        'isFilter' => 0,
        'reqFilter' => 0,
    ]);

    $bot->reply($curl->response->simsimi_talk_set->answers[0]->sentence);
});

$botman->listen();
