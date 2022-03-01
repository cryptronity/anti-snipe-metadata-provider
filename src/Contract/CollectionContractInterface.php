<?php

declare(strict_types=1);

namespace App\Contract;

use Ethereum\DataType\EthQ;


interface CollectionContractInterface
{
    public function totalSupply(): EthQ;
}
