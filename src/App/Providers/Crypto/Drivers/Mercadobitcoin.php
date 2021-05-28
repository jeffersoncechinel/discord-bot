<?php

declare(strict_types=1);

namespace App\Providers\Crypto\Drivers;

use App\Providers\Crypto\CryptoInterface;

class Mercadobitcoin implements CryptoInterface
{
    public function btc(): array
    {
        $url = 'https://www.mercadobitcoin.net/api/btc/ticker';
        $response = $this->request($url);

        return $this->formatValue($response);
    }

    public function xrp(): array
    {
        $url = 'https://www.mercadobitcoin.net/api/xrp/ticker';
        $response = $this->request($url);

        return $this->formatValue($response);
    }

    protected function request($url): bool|string
    {
        return file_get_contents($url);
    }

    protected function formatValue($response): array
    {
        $response = json_decode($response, true);
        $buy = number_format((float)$response['ticker']['buy'], 8);
        $sell = number_format((float)$response['ticker']['sell'], 8);

        return compact('buy', 'sell');
    }
}
