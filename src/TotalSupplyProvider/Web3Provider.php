<?php


declare(strict_types=1);

namespace App\TotalSupplyProvider;

use App\Contract\CollectionContractInterface;
use App\Contract\TotalSupplyProviderInterface;
use App\Service\CollectionManager;
use Ethereum\Ethereum;
use Ethereum\SmartContract;
use RuntimeException;


final class Web3Provider implements TotalSupplyProviderInterface
{
    private int $totalSupply;

    private readonly SmartContract $contract;

    public function __construct(
        string $contractAddress,
        string $infuraEndpoint,
        CollectionManager $collectionManager,
    ) {
        $this->contract = new SmartContract(
            $collectionManager->getAbi(),
            $contractAddress,
            new Ethereum($infuraEndpoint),
        );
    }

    public function getTotalSupply(): int
    {
        if (! isset($this->totalSupply)) {
            /** @var CollectionContractInterface $smartContract */
            $smartContract = $this->contract;
            $totalSupply = $smartContract->totalSupply()->val();

            if (! is_int($totalSupply)) {
                throw new RuntimeException('Unexpected result from "totalSupply" call: "'.$totalSupply.'"');
            }

            $this->totalSupply = $totalSupply;
        }

        return $this->totalSupply;
    }
}
