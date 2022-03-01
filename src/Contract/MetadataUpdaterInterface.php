<?php

declare(strict_types=1);

namespace App\Contract;

interface MetadataUpdaterInterface
{
    /**
     * @param array<string, mixed> $metadata
     */
    public function updateMetadata(array &$metadata, int $tokenId, string $assetUri): void;
}
