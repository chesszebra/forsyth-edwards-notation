<?php

declare(strict_types=1);

namespace ChessZebra\ForsythEdwardsNotation;

use ChessZebra\ForsythEdwardsNotation\Exception\InvalidFenException;

/**
 * The representation of a chessboard in the Forsyth–Edwards Notation (FEN).
 */
final class FenNotation
{
    /** The default position of a chess board. */
    public const DEFAULT_POSITION = 'rnbqkbnr/pppppppp/8/8/8/8/PPPPPPPP/RNBQKBNR w KQkq - 0 1';

    /**
     * The board values.
     *
     * @var string
     */
    private $board;

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
        $fields = explode(' ', $fen);
        if (count($fields) !== 6) {
            throw InvalidFenException::incorrectFieldCount($fields);
        }

        $this->board = $fields[0];
        $this->turn = $fields[1];
        $this->enPassantTargetSquare = $fields[3] === '-' ? null : (string)$fields[3];
        $this->halfMoveClock = (int)$fields[4];
        $this->fullMoveNumber = (int)$fields[5];

        if ($this->turn !== 'w' && $this->turn !== 'b') {
            throw InvalidFenException::invalidTurn($this->turn);
        }

        $this->castlingAvailability = CastlingAvailability::parseCastlingAvailability($fields[2]);
    }

    public function getBoard(): string
    {
        return $this->board;
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

    public function toString(): string
    {
        $result = $this->board;
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
