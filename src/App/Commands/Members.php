<?php

declare(strict_types=1);

namespace App\Commands;

use Exception;
use Discord\Discord;
use Discord\Parts\Channel\Message;
use React\Promise\ExtendedPromiseInterface;

class Members implements CommandInterface
{
    public function __construct(
        private Message $message,
        private Discord $discord,
    ) {
    }

    /**
     * @throws Exception
     */
    public function execute(): ExtendedPromiseInterface
    {
        $members = $this->discord->guilds->get('id', $_ENV['GUILD_ID'])->members;

        $message[] = 'Members list: ' . PHP_EOL;

        foreach ($members as $member) {
            $message[] = 'username: ' . $member->username . PHP_EOL . 'avatar: <' . $member->user->avatar . '>' . PHP_EOL;
        }

        $message = implode(PHP_EOL, $message);
        return $this->message->author->sendMessage($message);
    }
}
