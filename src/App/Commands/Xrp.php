<?php

declare(strict_types=1);

namespace App\Commands;

use Discord\Parts\Channel\Message;
use Exception;
use React\Promise\ExtendedPromiseInterface;

class Xrp implements CommandInterface
{
    public function __construct(
        private Message $message,
    ) {
    }

    /**
     * @throws Exception
     */
    public function execute(): ExtendedPromiseInterface
    {
        $driver = 'App\\Providers\\Crypto\\Drivers\\Mercadobitcoin';
        $data = (new $driver($this->message))->xrp();

        ['buy' => $buy, 'sell' => $sell] = $data;

        $message = "{$this->message->author} XRP buy: {$buy}  sell: {$sell}";

        return $this->message->channel->sendMessage($message);
    }
}
