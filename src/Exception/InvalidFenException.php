<?php

declare(strict_types=1);

namespace ChessZebra\ForsythEdwardsNotation\Exception;

use RuntimeException;
use Throwable;
use function count;

/**
 * An exception being thrown when the FenReader is unable to parse a FEN string.
 */
final class InvalidFenException extends RuntimeException // phpcs:ignore
{
    public const CODE_INCORRECT_FIELDS = 0;
    public const CODE_INVALID_TURN = 1;

    /**
     * @param string[] $fields
     */
    public static function incorrectFieldCount(array $fields, ?Throwable $previous = null): InvalidFenException
    {
        $msg = 'Invalid FEN string, does not contain 6 fields but ' . count($fields) . '.';

        return new static($msg, self::CODE_INCORRECT_FIELDS, $previous);
    }

    public static function invalidTurn(string $turn, ?Throwable $previous = null): InvalidFenException
    {
        $msg = 'Invalid FEN turn provided: ' . $turn;

        return new static($msg, self::CODE_INVALID_TURN, $previous);
    }
}
