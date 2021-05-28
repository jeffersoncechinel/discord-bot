<?php

require_once(__DIR__ . '/../vendor/autoload.php');

use App\Commands\CommandsHandler;
use Discord\Discord;
use Discord\Parts\Channel\Message;
use Discord\WebSockets\Event;
use Monolog\Logger;
use React\EventLoop\Factory;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

$discord = new Discord([
    'token' => $_ENV['DISCORD_TOKEN'],
    'storeMessages' => false,
    'retrieveBans' => false,
    'loop' => Factory::create(),
    'logger' => new Logger('New logger'),
]);

$discord->on('ready', function (Discord $discord) {
    echo 'Bot is ready!' . PHP_EOL;

    $discord->on(Event::MESSAGE_CREATE, function (Message $message, Discord $discord) {
        (new CommandsHandler($message, $discord))->execute();
    });
});

$discord->run();
