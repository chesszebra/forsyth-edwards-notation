<?php

declare(strict_types=1);

namespace ChessZebra\ForsythEdwardsNotation\Exception;

use RuntimeException;
use Throwable;

use function sprintf;

final class InvalidCastlingAvailabilityException extends RuntimeException // phpcs:ignore
{
    public static function incorrectValue(
        string $field,
        ?Throwable $previous = null
    ): InvalidCastlingAvailabilityException {
        $msg = sprintf('The castling availability field "%s" contains an invalid value.', $field);

        return new static($msg, 0, $previous);
    }
}
