<?php

declare(strict_types=1);

namespace App\TotalSupplyProvider;

use App\Contract\TotalSupplyProviderInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;


final class OpenSeaStatsProvider implements TotalSupplyProviderInterface
{
    private int $totalSupply;

    public function __construct(
        private readonly string $collectionSlug,
        private readonly HttpClientInterface $httpClient,
    ) {
    }

    public function getTotalSupply(): int
    {
        if (! isset($this->totalSupply)) {
            $response = $this->httpClient->request(
                'GET',
                'https://api.opensea.io/api/v1/collection/'.$this->collectionSlug,
            );
            $jsonContent = $response->toArray();

            $this->totalSupply = (int) $jsonContent['collection']['stats']['total_supply'];
        }

        return $this->totalSupply;
    }
}
