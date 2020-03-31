<?php

declare(strict_types=1);

namespace ChessZebra\ForsythEdwardsNotation;

use ChessZebra\ForsythEdwardsNotation\Exception\InvalidFenException;
use function explode;

/**
 * The representation of a chessboard in the Forsyth–Edwards Notation (FEN).
 */
final class FenNotation
{
    /** The default position of a chess board. */
    public const DEFAULT_POSITION = 'rnbqkbnr/pppppppp/8/8/8/8/PPPPPPPP/RNBQKBNR w KQkq - 0 1';

    /**
     * The places of the pieces.
     *
     * @var string
     */
    private $piecePlacement;

    /**
     * An indication whether its black or white's turn.
     * The value 'b' means black, 'w' means white.
     *
     * @var string
     */
    private $turn;

    /**
     * A value that indicates whether or not castling is available.
     * This value is null when castling is not available; otherwise this has one or more letters:
     * - "K" (White can castle kingside),
     * - "Q" (White can castle queenside),
     * - "k" (Black can castle kingside), and/or
     * - "q" (Black can castle queenside).
     *
     * @var CastlingAvailability
     */
    private $castlingAvailability;

    /**
     * En passant target square in Standard Algebraic Notation (SAN).
     * If there's no en passant target square, this value is null. If a pawn has just made a two-square move, this is
     * the position "behind" the pawn. This is recorded regardless of whether there is a pawn in position to make an
     * en passant capture.
     *
     * @var string|null
     */
    private $enPassantTargetSquare;

    /**
     * Halfmove clock: This is the number of halfmoves since the last capture or pawn advance. This is used to
     * determine if a draw can be claimed under the fifty-move rule.
     *
     * @var int
     */
    private $halfMoveClock;

    /**
     * Fullmove number: The number of the full move. It starts at 1, and is incremented after Black's move.
     *
     * @var int
     */
    private $fullMoveNumber;

    public function __construct(string $fen)
    {
        $this->validate($fen);

        $fields = explode(' ', $fen);

        $this->piecePlacement = $fields[0];
        $this->turn = $fields[1];
        $this->enPassantTargetSquare = $fields[3] === '-' ? null : $fields[3];
        $this->halfMoveClock = (int)$fields[4];
        $this->fullMoveNumber = (int)$fields[5];
        $this->castlingAvailability = CastlingAvailability::parseCastlingAvailability($fields[2]);
    }

    private function validate(string $fen): void
    {
        $validator = new Validator();

        switch ($validator->validate($fen)) {
            case ValidationResult::VALID:
                break;

            case ValidationResult::EN_PASSANT_INVALID_MOVE:
                throw InvalidFenException::enPassantIllegal($fen);
            case ValidationResult::EN_PASSANT_INVALID_SQUARE:
                throw InvalidFenException::enPassantInvalidSquare($fen);
            case ValidationResult::FIELD_COUNT_TOO_LARGE:
            case ValidationResult::FIELD_COUNT_TOO_SMALL:
                throw InvalidFenException::incorrectFieldCount($fen);
            case ValidationResult::INVALID_CASTLING_PIECE:
                throw InvalidFenException::invalidCastlingPiece($fen);
            case ValidationResult::INVALID_TURN:
                throw InvalidFenException::invalidTurn($fen);
            case ValidationResult::HALFMOVE_COUNTER_NAN:
                throw InvalidFenException::wrongHalfMoveCounter($fen);
            case ValidationResult::MOVE_NUMBER_NAN:
            case ValidationResult::MOVE_NUMBER_POSITIVE:
                throw InvalidFenException::wrongMoveNumber($fen);
            case ValidationResult::PIECE_CONSECUTIVE_NUMBERS:
            case ValidationResult::PIECE_INVALID:
                throw InvalidFenException::invalidPiecePlacement($fen);
            case ValidationResult::PIECE_ROW_TOO_LARGE:
            case ValidationResult::PIECE_ROW_TOO_SMALL:
                throw InvalidFenException::incorrectPiecePlacementRowLength($fen);
            case ValidationResult::PIECE_NOT_ENOUGH_ROWS:
            case ValidationResult::PIECE_TOO_MANY_ROWS:
                throw InvalidFenException::incorrectPiecePlacementRowsLength($fen);
            default:
                throw InvalidFenException::unepectedError($fen); // @codeCoverageIgnore
        }
    }

    public function getPiecePlacement(): string
    {
        return $this->piecePlacement;
    }

    /**
     * @return array<int, string>
     */
    public function getPiecePlacementRows(): array
    {
        return explode('/', $this->piecePlacement);
    }

    public function isBlacksTurn(): bool
    {
        return $this->turn === 'b';
    }

    public function isWhitesTurn(): bool
    {
        return $this->turn === 'w';
    }

    public function canCastleWhiteKingSide(): bool
    {
        return $this->castlingAvailability->isWhiteKingSideAvailable();
    }

    public function canCastleWhiteQueenSide(): bool
    {
        return $this->castlingAvailability->isWhiteQueenSideAvailable();
    }

    public function canCastleBlackKingSide(): bool
    {
        return $this->castlingAvailability->isBlackKingSideAvailable();
    }

    public function canCastleBlackQueenSide(): bool
    {
        return $this->castlingAvailability->isBlackQueenSideAvailable();
    }

    public function getEnPassantTargetSquare(): ?string
    {
        return $this->enPassantTargetSquare;
    }

    public function getHalfMoveClock(): int
    {
        return $this->halfMoveClock;
    }

    public function getFullMoveNumber(): int
    {
        return $this->fullMoveNumber;
    }

    public function toExtendedPositionDescription(): string
    {
        $result = $this->piecePlacement;
        $result .= ' ' . $this->turn;
        $result .= ' ' . $this->castlingAvailability->toString();

        if ($this->enPassantTargetSquare !== null) {
            $result .= ' ' . $this->enPassantTargetSquare;
        }

        return $result;
    }

    public function toString(): string
    {
        $result = $this->piecePlacement;
        $result .= ' ' . $this->turn;
        $result .= ' ' . $this->castlingAvailability->toString();

        if ($this->enPassantTargetSquare === null) {
            $result .= ' -';
        } else {
            $result .= ' ' . $this->enPassantTargetSquare;
        }

        $result .= ' ' . $this->halfMoveClock;
        $result .= ' ' . $this->fullMoveNumber;

        return $result;
    }

    /**
     * @return string
     */
    public function __toString() // phpcs:ignore
    {
        return $this->toString();
    }
}
