<?php

declare(strict_types=1);

namespace App\Exception;

use RuntimeException;


final class InvalidTokenIdException extends RuntimeException
{
    public function __construct(int $tokenId)
    {
        parent::__construct('Invalid token ID: '.$tokenId);
    }
}
