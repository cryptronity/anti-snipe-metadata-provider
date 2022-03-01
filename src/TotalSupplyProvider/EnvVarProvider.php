<?php

declare(strict_types=1);

namespace App\TotalSupplyProvider;

use App\Contract\TotalSupplyProviderInterface;


final class EnvVarProvider implements TotalSupplyProviderInterface
{
    public function __construct(
        private readonly int $totalSupply,
    ) {
    }

    public function getTotalSupply(): int
    {
        return $this->totalSupply;
    }
}
