<?php

declare(strict_types=1);

namespace ChessZebra\ForsythEdwardsNotation;

use function count;
use function ctype_digit;
use function explode;
use function intval;
use function preg_match;
use function strlen;
use function strpos;

final class Validator
{
    private const SYMBOLS = 'pnbrqkPNBRQK';

    public function validate(string $fen): int
    {
        $tokens = explode(' ', $fen);

        if (count($tokens) < 6) {
            return ValidationResult::FIELD_COUNT_TOO_SMALL;
        }

        if (count($tokens) > 6) {
            return ValidationResult::FIELD_COUNT_TOO_LARGE;
        }

        if (!ctype_digit($tokens[FenFields::MOVE_NUMBER])) {
            return ValidationResult::MOVE_NUMBER_NAN;
        }

        if ($tokens[FenFields::MOVE_NUMBER] < 1) {
            return ValidationResult::MOVE_NUMBER_POSITIVE;
        }

        if (!ctype_digit($tokens[FenFields::HALF_MOVE_COUNTER])) {
            return ValidationResult::HALFMOVE_COUNTER_NAN;
        }

        if (!(preg_match('/^(-|[a-h]{1}[3|6]{1})$/', $tokens[FenFields::EN_PASSANT]) === 1)) {
            return ValidationResult::EN_PASSANT_INVALID_SQUARE;
        }

        if (!(preg_match('/(^-$)|(^[K|Q|k|q]{1,}$)/', $tokens[FenFields::CASTLING]) === 1)) {
            return ValidationResult::INVALID_CASTLING_PIECE;
        }

        if (!(preg_match('/^(w|b)$/', $tokens[FenFields::TURN]) === 1)) {
            return ValidationResult::INVALID_TURN;
        }

        $rows = explode('/', $tokens[FenFields::PIECES]);

        if (count($rows) < 8) {
            return ValidationResult::PIECE_NOT_ENOUGH_ROWS;
        }

        if (count($rows) > 8) {
            return ValidationResult::PIECE_TOO_MANY_ROWS;
        }

        for ($i = 0; $i < count($rows); ++$i) {
            $sumFields = 0;
            $previousWasNumber = false;

            for ($k = 0; $k < strlen($rows[$i]); ++$k) {
                if (ctype_digit($rows[$i]{$k})) {
                    if ($previousWasNumber) {
                        return ValidationResult::PIECE_CONSECUTIVE_NUMBERS;
                    }

                    $sumFields += intval($rows[$i]{$k}, 10);
                    $previousWasNumber = true;
                } else {
                    if (strpos(self::SYMBOLS, $rows[$i]{$k}) === false) {
                        return ValidationResult::PIECE_INVALID;
                    }

                    ++$sumFields;
                    $previousWasNumber = false;
                }
            }

            if ($sumFields < 8) {
                return ValidationResult::PIECE_ROW_TOO_SMALL;
            }

            if ($sumFields > 8) {
                return ValidationResult::PIECE_ROW_TOO_LARGE;
            }
        }

        if ($tokens[FenFields::EN_PASSANT] !== '-') {
            if (($tokens[FenFields::EN_PASSANT]{1} === '3' && $tokens[FenFields::TURN] === 'w') ||
                ($tokens[FenFields::EN_PASSANT]{1} === '6' && $tokens[FenFields::TURN] === 'b')) {
                return ValidationResult::EN_PASSANT_INVALID_MOVE;
            }
        }

        return ValidationResult::VALID;
    }
}
