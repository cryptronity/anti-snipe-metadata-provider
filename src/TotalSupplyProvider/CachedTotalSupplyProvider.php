<?php

declare(strict_types=1);

namespace App\TotalSupplyProvider;

use App\Contract\TotalSupplyProviderInterface;
use LogicException;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;

final class CachedTotalSupplyProvider implements TotalSupplyProviderInterface
{
    /**
     * @var string
     */
    private const CACHE_TOTAL_SUPPLY = 'cached_total_supply_provider.total_supply';

    public function __construct(
        private readonly TotalSupplyProviderInterface $totalSupplyProvider,
        private readonly CacheInterface $cache,
        private readonly ParameterBagInterface $parameterBag,
    ) {
    }

    public function getTotalSupply(): int
    {
        $totalSupply = $this->cache->get(self::CACHE_TOTAL_SUPPLY, function (ItemInterface $item): int {
            $item->expiresAfter((int) $this->parameterBag->get('app.cache_expiration'));

            return $this->totalSupplyProvider->getTotalSupply();
        });

        if (! is_int($totalSupply)) {
            throw new LogicException('Unexpected cache value (it must be int).');
        }

        return $totalSupply;
    }
}
