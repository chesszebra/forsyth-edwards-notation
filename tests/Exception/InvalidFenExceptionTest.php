<?php

declare(strict_types=1);

namespace ChessZebra\ForsythEdwardsNotation\Exception;

use PHPUnit\Framework\TestCase;

final class InvalidFenExceptionTest extends TestCase
{
    /**
     * @covers \ChessZebra\ForsythEdwardsNotation\Exception\InvalidFenException::unepectedError
     */
    public function testUnexpectedError(): void
    {
        // Arrange
        $fen = 'rnbqkbnr/pppppppp/8/8/8/8/PPPPPPPP/RNBQKBNR w KQkq - 0 1';

        // Act
        $exception = InvalidFenException::unepectedError($fen);

        // Assert
        static::assertSame(
            'An unexpected error did occur for FEN "rnbqkbnr/pppppppp/8/8/8/8/PPPPPPPP/RNBQKBNR w KQkq - 0 1"', // phpcs:ignore
            $exception->getMessage()
        );
    }

    /**
     * @covers \ChessZebra\ForsythEdwardsNotation\Exception\InvalidFenException::invalidCastlingPiece
     */
    public function testInvalidCastlingPiece(): void
    {
        // Arrange
        $fen = 'rnbqkbnr/pppppppp/8/8/8/8/PPPPPPPP/RNBQKBNR w KQkq - 0 1';

        // Act
        $exception = InvalidFenException::invalidCastlingPiece($fen);

        // Assert
        static::assertSame(
            'Castling availability contains an invalid piece for FEN "rnbqkbnr/pppppppp/8/8/8/8/PPPPPPPP/RNBQKBNR w KQkq - 0 1"', // phpcs:ignore
            $exception->getMessage()
        );
    }

    /**
     * @covers \ChessZebra\ForsythEdwardsNotation\Exception\InvalidFenException::enPassantIllegal
     */
    public function testEnPassantIllegal(): void
    {
        // Arrange
        $fen = 'rnbqkbnr/pppppppp/8/8/8/8/PPPPPPPP/RNBQKBNR w KQkq - 0 1';

        // Act
        $exception = InvalidFenException::enPassantIllegal($fen);

        // Assert
        static::assertSame(
            'En-passant square is illegal for FEN "rnbqkbnr/pppppppp/8/8/8/8/PPPPPPPP/RNBQKBNR w KQkq - 0 1"',
            $exception->getMessage()
        );
    }

    /**
     * @covers \ChessZebra\ForsythEdwardsNotation\Exception\InvalidFenException::enPassantInvalidSquare
     */
    public function testEnPassantInvalidSquare(): void
    {
        // Arrange
        $fen = 'rnbqkbnr/pppppppp/8/8/8/8/PPPPPPPP/RNBQKBNR w KQkq - 0 1';

        // Act
        $exception = InvalidFenException::enPassantInvalidSquare($fen);

        // Assert
        static::assertSame(
            'En-passant square is invalid for FEN "rnbqkbnr/pppppppp/8/8/8/8/PPPPPPPP/RNBQKBNR w KQkq - 0 1"',
            $exception->getMessage()
        );
    }

    /**
     * @covers \ChessZebra\ForsythEdwardsNotation\Exception\InvalidFenException::incorrectFieldCount
     */
    public function testIncorrectFieldCount(): void
    {
        // Arrange
        $fen = 'rnbqkbnr/pppppppp/8/8/8/8/PPPPPPPP/RNBQKBNR w KQkq - 0';

        // Act
        $exception = InvalidFenException::incorrectFieldCount($fen);

        // Assert
        static::assertSame('Invalid FEN string, does not contain 6 fields but 5.', $exception->getMessage());
    }

    /**
     * @covers \ChessZebra\ForsythEdwardsNotation\Exception\InvalidFenException::wrongHalfMoveCounter
     */
    public function testWrongHalfMoveCounter(): void
    {
        // Arrange
        $fen = 'rnbqkbnr/pppppppp/8/8/8/8/PPPPPPPP/RNBQKBNR w KQkq - 0';

        // Act
        $exception = InvalidFenException::wrongHalfMoveCounter($fen);

        // Assert
        static::assertSame(
            'Half move counter must be a non-negative integer in FEN "rnbqkbnr/pppppppp/8/8/8/8/PPPPPPPP/RNBQKBNR w KQkq - 0"', // phpcs:ignore
            $exception->getMessage()
        );
    }

    /**
     * @covers \ChessZebra\ForsythEdwardsNotation\Exception\InvalidFenException::invalidTurn
     */
    public function testIncorrectTurn(): void
    {
        // Arrange
        $fen = 'rnbqkbnr/pppppppp/8/8/8/8/PPPPPPPP/RNBQKBNR w KQkq - 0';

        // Act
        $exception = InvalidFenException::invalidTurn($fen);

        // Assert
        static::assertSame(
            'Invalid turn for FEN "rnbqkbnr/pppppppp/8/8/8/8/PPPPPPPP/RNBQKBNR w KQkq - 0".',
            $exception->getMessage()
        );
    }

    /**
     * @covers \ChessZebra\ForsythEdwardsNotation\Exception\InvalidFenException::wrongMoveNumber
     */
    public function testWrongMoveNumber(): void
    {
        // Arrange
        $fen = 'rnbqkbnr/pppppppp/8/8/8/8/PPPPPPPP/RNBQKBNR w KQkq - 0';

        // Act
        $exception = InvalidFenException::wrongMoveNumber($fen);

        // Assert
        static::assertSame(
            'Move number must be a positive integer in FEN "rnbqkbnr/pppppppp/8/8/8/8/PPPPPPPP/RNBQKBNR w KQkq - 0"',
            $exception->getMessage()
        );
    }

    /**
     * @covers \ChessZebra\ForsythEdwardsNotation\Exception\InvalidFenException::invalidPiecePlacement
     */
    public function testInvalidPiecePlacement(): void
    {
        // Arrange
        $fen = 'rnbqkbnr/pppppppp/8/8/8/8/PPPPPPPP/RNBQKBNR w KQkq - 0';

        // Act
        $exception = InvalidFenException::invalidPiecePlacement($fen);

        // Assert
        static::assertSame(
            'Piece placement row contains an invalid value in FEN "rnbqkbnr/pppppppp/8/8/8/8/PPPPPPPP/RNBQKBNR w KQkq - 0"', // phpcs:ignore
            $exception->getMessage()
        );
    }

    /**
     * @covers \ChessZebra\ForsythEdwardsNotation\Exception\InvalidFenException::incorrectPiecePlacementRowLength
     */
    public function testIncorrectPiecePlacementRowLength(): void
    {
        // Arrange
        $fen = 'rnbqkbnr/pppppppp/8/8/8/8/PPPPPPPP/RNBQKBNR w KQkq - 0';

        // Act
        $exception = InvalidFenException::incorrectPiecePlacementRowLength($fen);

        // Assert
        static::assertSame(
            'Piece placement row length is incorrect in FEN "rnbqkbnr/pppppppp/8/8/8/8/PPPPPPPP/RNBQKBNR w KQkq - 0"',
            $exception->getMessage()
        );
    }

    /**
     * @covers \ChessZebra\ForsythEdwardsNotation\Exception\InvalidFenException::incorrectPiecePlacementRowsLength
     */
    public function testIncorrectPiecePlacementRowsLength(): void
    {
        // Arrange
        $fen = 'rnbqkbnr/pppppppp/8/8/8/8/PPPPPPPP/RNBQKBNR w KQkq - 0';

        // Act
        $exception = InvalidFenException::incorrectPiecePlacementRowsLength($fen);

        // Assert
        static::assertSame(
            'No 8 piece placement rows found in FEN "rnbqkbnr/pppppppp/8/8/8/8/PPPPPPPP/RNBQKBNR w KQkq - 0"',
            $exception->getMessage()
        );
    }
}
