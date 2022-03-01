<?php

declare(strict_types=1);

namespace App\Controller;

use App\Config\RouteName;
use App\Contract\AbstractNftController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Cache\ItemInterface;


#[Route(
    '/metadata/{tokenId}.{_format}',
    name: RouteName::GET_METADATA,
    requirements: [
        '_format' => 'json',
    ],
    defaults: [
        '_format' => 'json',
    ],
)]
final class MetadataController extends AbstractNftController
{
    /**
     * @var string
     */
    private const CACHE_TOKEN_METADATA = 'metadata_controller.metadata_';

    /**
     * @var string
     */
    private const CACHE_HIDDEN_METADATA = 'metadata_controller.hidden_metadata';

    public function __invoke(int $tokenId): Response
    {
        if (! $this->isValidTokenId($tokenId)) {
            $metadata = $this->cache->get(self::CACHE_HIDDEN_METADATA, function (ItemInterface $item): array {
                $item->expiresAfter($this->getDefaultCacheExpiration());

                return $this->collectionManager->getHiddenMetadata();
            });

            return $this
                ->json($metadata)
                ->setPublic()
                ->setMaxAge($this->getDefaultCacheExpiration())
            ;
        }

        $metadata = $this->cache->get(
            self::CACHE_TOKEN_METADATA.$tokenId,
            function (ItemInterface $item) use ($tokenId): array {
                $item->expiresAfter($this->getDefaultCacheExpiration());

                return $this->collectionManager->getMetadata($tokenId);
            },
        );

        return $this
            ->json($metadata)
            ->setPublic()
            ->setMaxAge($this->getDefaultCacheExpiration())
        ;
    }
}
