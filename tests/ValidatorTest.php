<?php

declare(strict_types=1);

namespace ChessZebra\ForsythEdwardsNotation;

use PHPUnit\Framework\TestCase;

final class ValidatorTest extends TestCase
{
    /**
     * @covers \ChessZebra\ForsythEdwardsNotation\Validator::validate
     */
    public function testValidFEN(): void
    {
        // Arrange
        $fen = 'rnbqkbnr/pppppppp/8/8/8/8/PPPPPPPP/RNBQKBNR w KQkq - 0 1';
        $validator = new Validator();

        // Act
        $result = $validator->validate($fen);

        // Assert
        static::assertSame(ValidationResult::VALID, $result);
    }

    /**
     * @covers \ChessZebra\ForsythEdwardsNotation\Validator::validate
     */
    public function testFieldCountTooSmall(): void
    {
        // Arrange
        $fen = 'rnbqkbnr/pppppppp/8/8/8/8/PPPPPPPP/RNBQKBNR';
        $validator = new Validator();

        // Act
        $result = $validator->validate($fen);

        // Assert
        static::assertSame(ValidationResult::FIELD_COUNT_TOO_SMALL, $result);
    }

    /**
     * @covers \ChessZebra\ForsythEdwardsNotation\Validator::validate
     */
    public function testFieldCountTooLarge(): void
    {
        // Arrange
        $fen = 'rnbqkbnr/pppppppp/8/8/8/8/PPPPPPPP/RNBQKBNR b KQkq - 0 1 abc';
        $validator = new Validator();

        // Act
        $result = $validator->validate($fen);

        // Assert
        static::assertSame(ValidationResult::FIELD_COUNT_TOO_LARGE, $result);
    }

    /**
     * @covers \ChessZebra\ForsythEdwardsNotation\Validator::validate
     */
    public function testMoveNumberNotANumber(): void
    {
        // Arrange
        $fen = 'rnbqkbnr/pppppppp/8/8/8/8/PPPPPPPP/RNBQKBNR b KQkq - 0 a';
        $validator = new Validator();

        // Act
        $result = $validator->validate($fen);

        // Assert
        static::assertSame(ValidationResult::MOVE_NUMBER_NAN, $result);
    }

    /**
     * @covers \ChessZebra\ForsythEdwardsNotation\Validator::validate
     */
    public function testMoveNumberNotPositive(): void
    {
        // Arrange
        $fen = 'rnbqkbnr/pppppppp/8/8/8/8/PPPPPPPP/RNBQKBNR b KQkq - 0 0';
        $validator = new Validator();

        // Act
        $result = $validator->validate($fen);

        // Assert
        static::assertSame(ValidationResult::MOVE_NUMBER_POSITIVE, $result);
    }

    /**
     * @covers \ChessZebra\ForsythEdwardsNotation\Validator::validate
     */
    public function testHalfMoveCounterNotANumber(): void
    {
        // Arrange
        $fen = 'rnbqkbnr/pppppppp/8/8/8/8/PPPPPPPP/RNBQKBNR b KQkq - a 1';
        $validator = new Validator();

        // Act
        $result = $validator->validate($fen);

        // Assert
        static::assertSame(ValidationResult::HALFMOVE_COUNTER_NAN, $result);
    }

    /**
     * @covers \ChessZebra\ForsythEdwardsNotation\Validator::validate
     */
    public function testEnPassantSquareInvalid(): void
    {
        // Arrange
        $fen = 'rnbqkbnr/pppppppp/8/8/8/8/PPPPPPPP/RNBQKBNR b KQkq a 0 1';
        $validator = new Validator();

        // Act
        $result = $validator->validate($fen);

        // Assert
        static::assertSame(ValidationResult::EN_PASSANT_INVALID_SQUARE, $result);
    }

    /**
     * @covers \ChessZebra\ForsythEdwardsNotation\Validator::validate
     */
    public function testInvalidCastlingPiece(): void
    {
        // Arrange
        $fen = 'rnbqkbnr/pppppppp/8/8/8/8/PPPPPPPP/RNBQKBNR b e - 0 1';
        $validator = new Validator();

        // Act
        $result = $validator->validate($fen);

        // Assert
        static::assertSame(ValidationResult::INVALID_CASTLING_PIECE, $result);
    }

    /**
     * @covers \ChessZebra\ForsythEdwardsNotation\Validator::validate
     */
    public function testInvalidTurn(): void
    {
        // Arrange
        $fen = 'rnbqkbnr/pppppppp/8/8/8/8/PPPPPPPP/RNBQKBNR l KQkq - 0 1';
        $validator = new Validator();

        // Act
        $result = $validator->validate($fen);

        // Assert
        static::assertSame(ValidationResult::INVALID_TURN, $result);
    }

    /**
     * @covers \ChessZebra\ForsythEdwardsNotation\Validator::validate
     */
    public function testNotEnoughPieceRows(): void
    {
        // Arrange
        $fen = 'rnbqkbnr/pppppppp/8/8/8/8/PPPPPPPP b KQkq - 0 1';
        $validator = new Validator();

        // Act
        $result = $validator->validate($fen);

        // Assert
        static::assertSame(ValidationResult::PIECE_NOT_ENOUGH_ROWS, $result);
    }

    /**
     * @covers \ChessZebra\ForsythEdwardsNotation\Validator::validate
     */
    public function testTooManyPieceRows(): void
    {
        // Arrange
        $fen = 'rnbqkbnr/pppppppp/8/8/8/8/PPPPPPPP/RNBQKBNR/8 b KQkq - 0 1';
        $validator = new Validator();

        // Act
        $result = $validator->validate($fen);

        // Assert
        static::assertSame(ValidationResult::PIECE_TOO_MANY_ROWS, $result);
    }

    /**
     * @covers \ChessZebra\ForsythEdwardsNotation\Validator::validate
     */
    public function testConsecutiveNumbers(): void
    {
        // Arrange
        $fen = 'rnbqkbnr/pppppppp/8/8/8/8/88/RNBQKBNR b KQkq - 0 1';
        $validator = new Validator();

        // Act
        $result = $validator->validate($fen);

        // Assert
        static::assertSame(ValidationResult::PIECE_CONSECUTIVE_NUMBERS, $result);
    }

    /**
     * @covers \ChessZebra\ForsythEdwardsNotation\Validator::validate
     */
    public function testInvalidPiece(): void
    {
        // Arrange
        $fen = 'rnbqkbnr/pppppppp/8/8/8/8/PgPPPPPP/RNBQKBNR b KQkq - 0 1';
        $validator = new Validator();

        // Act
        $result = $validator->validate($fen);

        // Assert
        static::assertSame(ValidationResult::PIECE_INVALID, $result);
    }

    /**
     * @covers \ChessZebra\ForsythEdwardsNotation\Validator::validate
     */
    public function testTooSmallRow(): void
    {
        // Arrange
        $fen = 'rnbqkbnr/p4p/8/8/8/8/PPPPPPPP/RNBQKBNR b KQkq - 0 1';
        $validator = new Validator();

        // Act
        $result = $validator->validate($fen);

        // Assert
        static::assertSame(ValidationResult::PIECE_ROW_TOO_SMALL, $result);
    }

    /**
     * @covers \ChessZebra\ForsythEdwardsNotation\Validator::validate
     */
    public function testRowTooLarge(): void
    {
        // Arrange
        $fen = 'rnbqkbnr/p8p/8/8/8/8/PPPPPPPP/RNBQKBNR b KQkq - 0 1';
        $validator = new Validator();

        // Act
        $result = $validator->validate($fen);

        // Assert
        static::assertSame(ValidationResult::PIECE_ROW_TOO_LARGE, $result);
    }

    /**
     * @covers \ChessZebra\ForsythEdwardsNotation\Validator::validate
     */
    public function testEnPassantWrongTurnBlack(): void
    {
        // Arrange
        $fen = 'rnbqkbnr/pppppppp/8/8/8/8/PPPPPPPP/RNBQKBNR b KQkq a6 0 1';
        $validator = new Validator();

        // Act
        $result = $validator->validate($fen);

        // Assert
        static::assertSame(ValidationResult::EN_PASSANT_INVALID_MOVE, $result);
    }

    /**
     * @covers \ChessZebra\ForsythEdwardsNotation\Validator::validate
     */
    public function testEnPassantWrongTurnWhite(): void
    {
        // Arrange
        $fen = 'rnbqkbnr/pppppppp/8/8/8/8/PPPPPPPP/RNBQKBNR w KQkq a3 0 1';
        $validator = new Validator();

        // Act
        $result = $validator->validate($fen);

        // Assert
        static::assertSame(ValidationResult::EN_PASSANT_INVALID_MOVE, $result);
    }
}
