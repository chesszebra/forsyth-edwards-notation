<?php

declare(strict_types=1);

namespace ChessZebra\ForsythEdwardsNotation;

use ChessZebra\ForsythEdwardsNotation\Exception\InvalidCastlingAvailabilityException;
use ChessZebra\ForsythEdwardsNotation\Exception\InvalidFenException;
use PHPUnit\Framework\TestCase;

final class FenNotationTest extends TestCase
{
    /**
     * @covers \ChessZebra\ForsythEdwardsNotation\FenNotation::toString
     */
    public function testToString(): void
    {
        // Arrange
        $fen = 'rnbqkbnr/pppppppp/8/8/8/8/PPPPPPPP/RNBQKBNR b KQkq - 0 1';

        // Act
        $notation = new FenNotation($fen);

        // Assert
        static::assertSame($fen, $notation->toString());
    }

    /**
     * @covers \ChessZebra\ForsythEdwardsNotation\FenNotation::toString
     */
    public function testToStringWithEnPassant(): void
    {
        // Arrange
        $fen = 'rnbqkbnr/pp1ppppp/8/2p5/4P3/8/PPPP1PPP/RNBQKBNR w KQkq c6 0 2';

        // Act
        $notation = new FenNotation($fen);

        // Assert
        static::assertSame($fen, $notation->toString());
    }

    /**
     * @covers \ChessZebra\ForsythEdwardsNotation\FenNotation::__toString
     */
    public function testToStringViaCast(): void
    {
        // Arrange
        $fen = 'rnbqkbnr/pppppppp/8/8/8/8/PPPPPPPP/RNBQKBNR b KQkq - 0 1';

        // Act
        $notation = new FenNotation($fen);

        // Assert
        static::assertSame($fen, (string)$notation);
    }

    /**
     * @covers \ChessZebra\ForsythEdwardsNotation\FenNotation::__construct
     */
    public function testReadInvalidFenThrowsException(): void
    {
        // Assert
        $this->expectException(InvalidFenException::class);

        // Arrange
        $fen = '';

        // Act
        new FenNotation($fen);
    }

    /**
     * @covers \ChessZebra\ForsythEdwardsNotation\FenNotation::__construct
     */
    public function testInvalidTurnThrowsException(): void
    {
        // Assert
        $this->expectException(InvalidFenException::class);

        // Arrange
        $fen = 'rnbqkbnr/pppppppp/8/8/8/8/PPPPPPPP/RNBQKBNR r KQkq - 0 1';

        // Act
        new FenNotation($fen);
    }

    /**
     * @covers \ChessZebra\ForsythEdwardsNotation\FenNotation::__construct
     * @covers \ChessZebra\ForsythEdwardsNotation\FenNotation::isBlacksTurn
     */
    public function testTurnIsBlack(): void
    {
        // Arrange
        $fen = 'rnbqkbnr/pppppppp/8/8/8/8/PPPPPPPP/RNBQKBNR b KQkq - 0 1';

        // Act
        $notation = new FenNotation($fen);

        // Assert
        static::assertTrue($notation->isBlacksTurn());
    }

    /**
     * @covers \ChessZebra\ForsythEdwardsNotation\FenNotation::__construct
     * @covers \ChessZebra\ForsythEdwardsNotation\FenNotation::isWhitesTurn
     */
    public function testTurnIsWhite(): void
    {
        // Arrange
        $fen = 'rnbqkbnr/pppppppp/8/8/8/8/PPPPPPPP/RNBQKBNR w KQkq - 0 1';

        // Act
        $notation = new FenNotation($fen);

        // Assert
        static::assertTrue($notation->isWhitesTurn());
    }

    /**
     * @covers \ChessZebra\ForsythEdwardsNotation\FenNotation::__construct
     */
    public function testInvalidCastlingAvailabilityThrowsException(): void
    {
        // Assert
        $this->expectException(InvalidCastlingAvailabilityException::class);

        // Arrange
        $fen = 'rnbqkbnr/pppppppp/8/8/8/8/PPPPPPPP/RNBQKBNR w KQkqR - 0 1';

        // Act
        new FenNotation($fen);
    }

    /**
     * @covers \ChessZebra\ForsythEdwardsNotation\FenNotation::__construct
     * @covers \ChessZebra\ForsythEdwardsNotation\FenNotation::getBoard
     */
    public function testGetBoard(): void
    {
        // Arrange
        $fen = 'rnbqkbnr/pppppppp/8/8/8/8/PPPPPPPP/RNBQKBNR w KQkq - 0 1';

        $notation = new FenNotation($fen);

        // Act
        $result = $notation->getBoard();

        // Assert
        static::assertSame('rnbqkbnr/pppppppp/8/8/8/8/PPPPPPPP/RNBQKBNR', $result);
    }

    /**
     * @covers \ChessZebra\ForsythEdwardsNotation\FenNotation::__construct
     * @covers \ChessZebra\ForsythEdwardsNotation\FenNotation::getEnPassantTargetSquare
     */
    public function testEnPassentTargetSquareIsNull(): void
    {
        // Arrange
        $fen = 'rnbqkbnr/pppppppp/8/8/8/8/PPPPPPPP/RNBQKBNR w KQkq - 0 1';

        // Act
        $notation = new FenNotation($fen);

        // Assert
        static::assertNull($notation->getEnPassantTargetSquare());
    }

    /**
     * @covers \ChessZebra\ForsythEdwardsNotation\FenNotation::__construct
     * @covers \ChessZebra\ForsythEdwardsNotation\FenNotation::canCastleWhiteKingSide
     */
    public function testCastlingWhiteKingSideSet(): void
    {
        // Arrange
        $fen = 'rnbqkbnr/pp1ppppp/8/2p5/4P3/8/PPPP1PPP/RNBQKBNR w KQkq c6 0 2';

        // Act
        $notation = new FenNotation($fen);

        // Assert
        static::assertTrue($notation->canCastleWhiteKingSide());
    }

    /**
     * @covers \ChessZebra\ForsythEdwardsNotation\FenNotation::__construct
     * @covers \ChessZebra\ForsythEdwardsNotation\FenNotation::canCastleWhiteQueenSide
     */
    public function testCastlingWhiteQueenSideSet(): void
    {
        // Arrange
        $fen = 'rnbqkbnr/pp1ppppp/8/2p5/4P3/8/PPPP1PPP/RNBQKBNR w KQkq c6 0 2';

        // Act
        $notation = new FenNotation($fen);

        // Assert
        static::assertTrue($notation->canCastleWhiteQueenSide());
    }

    /**
     * @covers \ChessZebra\ForsythEdwardsNotation\FenNotation::__construct
     * @covers \ChessZebra\ForsythEdwardsNotation\FenNotation::canCastleBlackKingSide
     */
    public function testCastlingBlackKingSideSet(): void
    {
        // Arrange
        $fen = 'rnbqkbnr/pp1ppppp/8/2p5/4P3/8/PPPP1PPP/RNBQKBNR w KQkq c6 0 2';

        // Act
        $notation = new FenNotation($fen);

        // Assert
        static::assertTrue($notation->canCastleBlackKingSide());
    }

    /**
     * @covers \ChessZebra\ForsythEdwardsNotation\FenNotation::__construct
     * @covers \ChessZebra\ForsythEdwardsNotation\FenNotation::canCastleBlackQueenSide
     */
    public function testCastlingBlackQueenSideSet(): void
    {
        // Arrange
        $fen = 'rnbqkbnr/pp1ppppp/8/2p5/4P3/8/PPPP1PPP/RNBQKBNR w KQkq c6 0 2';

        // Act
        $notation = new FenNotation($fen);

        // Assert
        static::assertTrue($notation->canCastleBlackQueenSide());
    }

    /**
     * @covers \ChessZebra\ForsythEdwardsNotation\FenNotation::__construct
     * @covers \ChessZebra\ForsythEdwardsNotation\FenNotation::getEnPassantTargetSquare
     */
    public function testEnPassentTargetSquareIsSet(): void
    {
        // Arrange
        $fen = 'rnbqkbnr/pp1ppppp/8/2p5/4P3/8/PPPP1PPP/RNBQKBNR w KQkq c6 0 2';

        // Act
        $notation = new FenNotation($fen);

        // Assert
        static::assertSame('c6', $notation->getEnPassantTargetSquare());
    }

    /**
     * @covers \ChessZebra\ForsythEdwardsNotation\FenNotation::__construct
     * @covers \ChessZebra\ForsythEdwardsNotation\FenNotation::getHalfMoveClock
     */
    public function testHalfMoveClock(): void
    {
        // Arrange
        $fen = 'rnbqkbnr/pp1ppppp/8/2p5/4P3/5N2/PPPP1PPP/RNBQKB1R b KQkq - 1 2';

        $notation = new FenNotation($fen);

        // Act
        $result = $notation->getHalfMoveClock();

        // Assert
        static::assertSame(1, $result);
    }

    /**
     * @covers \ChessZebra\ForsythEdwardsNotation\FenNotation::__construct
     * @covers \ChessZebra\ForsythEdwardsNotation\FenNotation::getFullMoveNumber
     */
    public function testFullMoveNumber(): void
    {
        // Arrange
        $fen = 'rnbqkbnr/pp1ppppp/8/2p5/4P3/5N2/PPPP1PPP/RNBQKB1R b KQkq - 1 2';

        $notation = new FenNotation($fen);

        // Act
        $result = $notation->getFullMoveNumber();

        // Assert
        static::assertSame(2, $result);
    }
}
