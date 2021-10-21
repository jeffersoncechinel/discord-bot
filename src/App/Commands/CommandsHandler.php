<?php

declare(strict_types=1);

namespace App\Commands;

use Discord\Discord;
use Discord\Parts\Channel\Message;
use Exception;
use React\EventLoop\TimerInterface;
use React\Promise\ExtendedPromiseInterface;

class CommandsHandler
{
    const COMMAND_PREFIX = '!';

    public function __construct(
        public Message $message,
        public Discord $discord,
    ) {
    }

    protected static function commands(): array
    {
        return [
            self::COMMAND_PREFIX . 'help' => 'help',
            self::COMMAND_PREFIX . 'btc' => 'btc',
            self::COMMAND_PREFIX . 'xrp' => 'xrp',
            self::COMMAND_PREFIX . 'members' => 'members',
        ];
    }

    public function execute(): bool
    {
        if (!$cmd = $this->getCmd()) {
            return false;
        }

        self::$cmd();

        return true;
    }

    protected function getCmd(): bool|string
    {
        $content = $this->message->content;
        $cmd = explode(' ', $content);

        if (!isset($cmd[0])) {
            return false;
        }

        if (!array_key_exists($cmd[0], self::commands())) {
            return false;
        }

        return self::commands()[$cmd[0]];
    }

    /**
     * @throws Exception
     */
    protected function help(): ExtendedPromiseInterface
    {
        return (new Help($this->message))->execute();
    }

    /**
     * @throws Exception
     */
    protected function btc(): TimerInterface
    {
        return (new Btc($this->message, $this->discord))->execute();
    }

    /**
     * @throws Exception
     */
    protected function xrp(): ExtendedPromiseInterface
    {
        return (new Xrp($this->message))->execute();
    }

    /**
     * @throws Exception
     */
    protected function members(): ExtendedPromiseInterface
    {
        return (new Members($this->message, $this->discord))->execute();
    }
}
