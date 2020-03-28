<?php

declare(strict_types=1);

namespace ChessZebra\ForsythEdwardsNotation;

use ChessZebra\ForsythEdwardsNotation\Exception\InvalidCastlingAvailabilityException;
use PHPUnit\Framework\TestCase;

final class CastlingAvailabilityTest extends TestCase
{
    /**
     * @covers \ChessZebra\ForsythEdwardsNotation\CastlingAvailability::__construct
     * @covers \ChessZebra\ForsythEdwardsNotation\CastlingAvailability::getValue
     * @covers \ChessZebra\ForsythEdwardsNotation\CastlingAvailability::isUnavailable
     */
    public function testConstructorInitializes(): void
    {
        // Arrange
        $value = 0;

        // Act
        $availability = new CastlingAvailability($value);

        // Assert
        static::assertSame(0, $availability->getValue());
        static::assertTrue($availability->isUnavailable());
    }

    /**
     * @covers \ChessZebra\ForsythEdwardsNotation\CastlingAvailability::parseCastlingAvailability
     */
    public function testParseInvalidValueThrowsException(): void
    {
        // Assert
        $this->expectException(InvalidCastlingAvailabilityException::class);

        // Arrange
        $value = '#';

        // Act
        CastlingAvailability::parseCastlingAvailability($value);
    }

    /**
     * @covers \ChessZebra\ForsythEdwardsNotation\CastlingAvailability::getValue
     * @covers \ChessZebra\ForsythEdwardsNotation\CastlingAvailability::parseCastlingAvailability
     */
    public function testParseDash(): void
    {
        // Arrange
        $value = '-';

        // Act
        $availability = CastlingAvailability::parseCastlingAvailability($value);

        // Assert
        static::assertSame(0, $availability->getValue());
    }

    /**
     * @covers \ChessZebra\ForsythEdwardsNotation\CastlingAvailability::isWhiteKingSideAvailable
     * @covers \ChessZebra\ForsythEdwardsNotation\CastlingAvailability::parseCastlingAvailability
     */
    public function testParseWhiteKing(): void
    {
        // Arrange
        $value = 'KQkq';

        // Act
        $availability = CastlingAvailability::parseCastlingAvailability($value);

        // Assert
        static::assertTrue($availability->isWhiteKingSideAvailable());
    }

    /**
     * @covers \ChessZebra\ForsythEdwardsNotation\CastlingAvailability::isWhiteQueenSideAvailable
     * @covers \ChessZebra\ForsythEdwardsNotation\CastlingAvailability::parseCastlingAvailability
     */
    public function testParseWhiteQueen(): void
    {
        // Arrange
        $value = 'KQkq';

        // Act
        $availability = CastlingAvailability::parseCastlingAvailability($value);

        // Assert
        static::assertTrue($availability->isWhiteQueenSideAvailable());
    }

    /**
     * @covers \ChessZebra\ForsythEdwardsNotation\CastlingAvailability::isBlackKingSideAvailable
     * @covers \ChessZebra\ForsythEdwardsNotation\CastlingAvailability::parseCastlingAvailability
     */
    public function testParseBlackKing(): void
    {
        // Arrange
        $value = 'KQkq';

        // Act
        $availability = CastlingAvailability::parseCastlingAvailability($value);

        // Assert
        static::assertTrue($availability->isBlackKingSideAvailable());
    }

    /**
     * @covers \ChessZebra\ForsythEdwardsNotation\CastlingAvailability::isBlackQueenSideAvailable
     * @covers \ChessZebra\ForsythEdwardsNotation\CastlingAvailability::parseCastlingAvailability
     */
    public function testParseBlackQueen(): void
    {
        // Arrange
        $value = 'KQkq';

        // Act
        $availability = CastlingAvailability::parseCastlingAvailability($value);

        // Assert
        static::assertTrue($availability->isBlackQueenSideAvailable());
    }

    /**
     * @covers \ChessZebra\ForsythEdwardsNotation\CastlingAvailability::toString
     * @covers \ChessZebra\ForsythEdwardsNotation\CastlingAvailability::parseCastlingAvailability
     */
    public function testToString(): void
    {
        // Arrange
        $value = 'KQkq';

        // Act
        $availability = CastlingAvailability::parseCastlingAvailability($value);

        // Assert
        static::assertSame($value, $availability->toString());
    }

    /**
     * @covers \ChessZebra\ForsythEdwardsNotation\CastlingAvailability::withoutWhite
     */
    public function testWithoutWhite(): void
    {
        // Arrange
        $availability = CastlingAvailability::parseCastlingAvailability('KQkq');

        // Act
        $newAvailability = $availability->withoutWhite();

        // Assert
        static::assertFalse($newAvailability->isWhiteKingSideAvailable());
        static::assertFalse($newAvailability->isWhiteQueenSideAvailable());
        static::assertTrue($newAvailability->isBlackKingSideAvailable());
        static::assertTrue($newAvailability->isBlackQueenSideAvailable());
    }

    /**
     * @covers \ChessZebra\ForsythEdwardsNotation\CastlingAvailability::withoutBlack
     */
    public function testWithoutBlack(): void
    {
        // Arrange
        $availability = CastlingAvailability::parseCastlingAvailability('KQkq');

        // Act
        $newAvailability = $availability->withoutBlack();

        // Assert
        static::assertTrue($newAvailability->isWhiteKingSideAvailable());
        static::assertTrue($newAvailability->isWhiteQueenSideAvailable());
        static::assertFalse($newAvailability->isBlackKingSideAvailable());
        static::assertFalse($newAvailability->isBlackQueenSideAvailable());
    }
}
