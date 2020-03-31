<?php

declare(strict_types=1);

namespace ChessZebra\ForsythEdwardsNotation;

final class ValidationResult
{
    public const VALID = 0;
    public const EN_PASSANT_INVALID_MOVE = 1;
    public const EN_PASSANT_INVALID_SQUARE = 2;
    public const FIELD_COUNT_TOO_LARGE = 3;
    public const FIELD_COUNT_TOO_SMALL = 4;
    public const INVALID_CASTLING_PIECE = 5;
    public const INVALID_TURN = 6;
    public const HALFMOVE_COUNTER_NAN = 7;
    public const MOVE_NUMBER_NAN = 8;
    public const MOVE_NUMBER_POSITIVE = 9;
    public const PIECE_CONSECUTIVE_NUMBERS = 10;
    public const PIECE_INVALID = 11;
    public const PIECE_NOT_ENOUGH_ROWS = 12;
    public const PIECE_ROW_TOO_SMALL = 13;
    public const PIECE_ROW_TOO_LARGE = 14;
    public const PIECE_TOO_MANY_ROWS = 15;
}
