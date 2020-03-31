<?php

declare(strict_types=1);

namespace ChessZebra\ForsythEdwardsNotation\Exception;

use RuntimeException;
use Throwable;
use function count;
use function explode;
use function sprintf;

/**
 * An exception being thrown when the FenReader is unable to parse a FEN string.
 */
final class InvalidFenException extends RuntimeException // phpcs:ignore
{
    public const CODE_UNEXPECTED = 0;
    public const CODE_CASTLING_AVAILABILITY = 1;
    public const CODE_EN_PASSANT_ILLEGAL = 2;
    public const CODE_EN_PASSANT_INVALID_SQUARE = 3;
    public const CODE_FIELD_COUNT = 4;
    public const CODE_HALF_MOVE_COUNTER = 5;
    public const CODE_INVALID_TURN = 6;
    public const CODE_MOVE_NUMBER = 7;
    public const CODE_PIECE_PLACEMENT_INVALID = 8;
    public const CODE_PIECE_PLACEMENT_LENGTH = 9;

    public static function unepectedError(string $fen, ?Throwable $previous = null): InvalidFenException
    {
        $msg = sprintf('An unexpected error did occur for FEN "%s"', $fen);

        return new static($msg, self::CODE_UNEXPECTED, $previous);
    }

    public static function invalidCastlingPiece(string $fen, ?Throwable $previous = null): InvalidFenException
    {
        $msg = sprintf('Castling availability contains an invalid piece for FEN "%s"', $fen);

        return new static($msg, self::CODE_CASTLING_AVAILABILITY, $previous);
    }

    public static function enPassantIllegal(string $fen, ?Throwable $previous = null): InvalidFenException
    {
        $msg = sprintf('En-passant square is illegal for FEN "%s"', $fen);

        return new static($msg, self::CODE_EN_PASSANT_ILLEGAL, $previous);
    }

    public static function enPassantInvalidSquare(string $fen, ?Throwable $previous = null): InvalidFenException
    {
        $msg = sprintf('En-passant square is invalid for FEN "%s"', $fen);

        return new static($msg, self::CODE_EN_PASSANT_INVALID_SQUARE, $previous);
    }

    public static function incorrectFieldCount(string $fen, ?Throwable $previous = null): InvalidFenException
    {
        $msg = 'Invalid FEN string, does not contain 6 fields but ' . count(explode(' ', $fen)) . '.';

        return new static($msg, self::CODE_FIELD_COUNT, $previous);
    }

    public static function wrongHalfMoveCounter(string $fen, ?Throwable $previous = null): InvalidFenException
    {
        $msg = sprintf('Half move counter must be a non-negative integer in FEN "%s"', $fen);

        return new static($msg, self::CODE_HALF_MOVE_COUNTER, $previous);
    }

    public static function invalidTurn(string $fen, ?Throwable $previous = null): InvalidFenException
    {
        $msg = sprintf('Invalid turn for FEN "%s".', $fen);

        return new static($msg, self::CODE_INVALID_TURN, $previous);
    }

    public static function wrongMoveNumber(string $fen, ?Throwable $previous = null): InvalidFenException
    {
        $msg = sprintf('Move number must be a positive integer in FEN "%s"', $fen);

        return new static($msg, self::CODE_MOVE_NUMBER, $previous);
    }

    public static function invalidPiecePlacement(string $fen, ?Throwable $previous = null): InvalidFenException
    {
        $msg = sprintf('Piece placement row contains an invalid value in FEN "%s"', $fen);

        return new static($msg, self::CODE_PIECE_PLACEMENT_INVALID, $previous);
    }

    public static function incorrectPiecePlacementRowLength(
        string $fen,
        ?Throwable $previous = null
    ): InvalidFenException {
        $msg = sprintf('Piece placement row length is incorrect in FEN "%s"', $fen);

        return new static($msg, self::CODE_PIECE_PLACEMENT_LENGTH, $previous);
    }

    public static function incorrectPiecePlacementRowsLength(
        string $fen,
        ?Throwable $previous = null
    ): InvalidFenException {
        $msg = sprintf('No 8 piece placement rows found in FEN "%s"', $fen);

        return new static($msg, self::CODE_PIECE_PLACEMENT_LENGTH, $previous);
    }
}
