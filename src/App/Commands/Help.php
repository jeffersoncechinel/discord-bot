<?php

declare(strict_types=1);

namespace App\Commands;

use Discord\Parts\Channel\Message;
use Exception;
use React\Promise\ExtendedPromiseInterface;

class Help implements CommandInterface
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
        $message = "{$this->message->author} I cant help.";

        return $this->message->channel->sendMessage($message);
    }
}
