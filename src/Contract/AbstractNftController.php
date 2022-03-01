<?php

declare(strict_types=1);

namespace App\Contract;

use App\Service\CollectionManager;
use App\TotalSupplyProvider\CachedTotalSupplyProvider;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Contracts\Cache\CacheInterface;

abstract class AbstractNftController extends AbstractController
{
    public function __construct(
        protected readonly CollectionManager $collectionManager,
        protected readonly CachedTotalSupplyProvider $cachedTotalSupplyProvider,
        protected readonly UrlGeneratorInterface $urlGenerator,
        protected readonly CacheInterface $cache,
    ) {
    }

    protected function isValidTokenId(int $tokenId): bool
    {
        $isRevealed = $this->getParameter('app.collection_is_revealed');

        return $isRevealed && $tokenId > 0 && $tokenId <= $this->cachedTotalSupplyProvider->getTotalSupply();
    }

    protected function getDefaultCacheExpiration(): int
    {
        return (int) $this->getParameter('app.cache_expiration');
    }
}
