<?php

namespace App\Commands;

use Discord\Parts\Channel\Message;

class CommandsHandler
{
    const COMMAND_PREFIX = '!';

    public static function execute(Message $message)
    {
        if (!$cmd = self::getCmd($message)) {
            return false;
        }

        return self::$cmd($message);
    }

    private static function getCmd($message)
    {
        $content = $message->content;
        $cmd = explode(' ', $content);

        if (!isset($cmd[0])) {
            return false;
        }

        if (!array_key_exists($cmd[0], self::commands())) {
            return false;
        }

        return self::commands()[$cmd[0]];
    }

    public static function commands()
    {
        return [
            self::COMMAND_PREFIX . 'help' => 'help',
            self::COMMAND_PREFIX . 'btc' => 'btc',
            self::COMMAND_PREFIX . 'xrp' => 'xrp',
        ];
    }

    private static function help($message)
    {
        return $message->channel->sendMessage("{$message->author} I cant help.");
    }

    private static function btc($message)
    {
        $btc = file_get_contents('https://www.mercadobitcoin.net/api/btc/ticker');
        $btc = json_decode($btc, 1);

        $buy = number_format($btc['ticker']['buy'], 8);
        $sell = number_format($btc['ticker']['sell'], 8);

        return $message->channel->sendMessage("{$message->author} Bitcoin buy: {$buy}  sell: {$sell}");
    }

    private static function xrp($message)
    {
        $btc = file_get_contents('https://www.mercadobitcoin.net/api/xrp/ticker');
        $btc = json_decode($btc, 1);

        $buy = number_format($btc['ticker']['buy'], 8);
        $sell = number_format($btc['ticker']['sell'], 8);

        return $message->channel->sendMessage("{$message->author} XRP buy: {$buy}  sell: {$sell}");
    }
}
