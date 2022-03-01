<?php

declare(strict_types=1);

namespace App\Contract;


interface TotalSupplyProviderInterface
{
    public function getTotalSupply(): int;
}
