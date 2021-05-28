<?php

declare(strict_types=1);

namespace App\Commands;

use Discord\Discord;
use Discord\Parts\Channel\Message;
use Exception;
use React\EventLoop\TimerInterface;

class Btc implements CommandInterface
{
    public function __construct(
        private Message $message,
        private Discord $discord,
    ) {
    }

    /**
     * @throws Exception
     */
    public function execute(): TimerInterface
    {
        $seconds = 2;

        // experiment delay without block the event loop
        return $this->discord->loop->addTimer($seconds, function () {
            $driver = 'App\\Providers\\Crypto\\Drivers\\Mercadobitcoin';
            $data = (new $driver())->btc();

            ['buy' => $buy, 'sell' => $sell] = $data;

            $message = "{$this->message->author} Bitcoin buy: {$buy}  sell: {$sell}";

            return $this->message->channel->sendMessage($message);
        });
    }
}
