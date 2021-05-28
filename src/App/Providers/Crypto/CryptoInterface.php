<?php

declare(strict_types=1);

namespace App\Providers\Crypto;

interface CryptoInterface
{
    public function xrp();

    public function btc();
}
