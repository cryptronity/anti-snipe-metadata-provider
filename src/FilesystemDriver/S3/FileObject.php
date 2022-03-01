<?php

declare(strict_types=1);

namespace App\FilesystemDriver\S3;


final class FileObject
{
    public function __construct(
        public string $contentType,
        public string $contents,
    ) {
    }
}
