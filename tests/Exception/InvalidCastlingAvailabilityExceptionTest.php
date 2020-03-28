<?php

declare(strict_types=1);

namespace ChessZebra\ForsythEdwardsNotation\Exception;

use PHPUnit\Framework\TestCase;

final class InvalidCastlingAvailabilityExceptionTest extends TestCase
{
    /**
     * @covers \ChessZebra\ForsythEdwardsNotation\Exception\InvalidCastlingAvailabilityException::incorrectValue
     */
    public function testIncorrectValue(): void
    {
        // Arrange
        $value = '!';

        // Act
        $exception = InvalidCastlingAvailabilityException::incorrectValue($value);

        // Assert
        static::assertSame('The castling availability field "!" contains an invalid value.', $exception->getMessage());
    }
}
