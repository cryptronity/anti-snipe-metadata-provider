<?php

declare(strict_types=1);

namespace App\Exception;

use RuntimeException;


final class InvalidTokensRangeException extends RuntimeException
{
    public function __construct(int $min, int $max)
    {
        parent::__construct('Invalid tokens range: '.$min.'-'.$max);
    }
}
