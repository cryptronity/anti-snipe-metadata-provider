<?php

declare(strict_types=1);

namespace App\MetadataUpdater;

use App\Contract\MetadataUpdaterInterface;


final class UriUpdater implements MetadataUpdaterInterface
{
    public function updateMetadata(array &$metadata, int $tokenId, string $assetUri): void
    {
        $metadata['image'] = $assetUri;
    }
}
