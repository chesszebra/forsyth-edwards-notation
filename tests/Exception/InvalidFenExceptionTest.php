<?php

declare(strict_types=1);

namespace ChessZebra\ForsythEdwardsNotation\Exception;

use PHPUnit\Framework\TestCase;

final class InvalidFenExceptionTest extends TestCase
{
    /**
     * @covers \ChessZebra\ForsythEdwardsNotation\Exception\InvalidFenException::incorrectFieldCount
     */
    public function testIncorrectFieldCount(): void
    {
        // Arrange
        $fields = [1, 2, 3];

        // Act
        $exception = InvalidFenException::incorrectFieldCount($fields);

        // Assert
        static::assertSame('Invalid FEN string, does not contain 6 fields but 3.', $exception->getMessage());
    }

    /**
     * @covers \ChessZebra\ForsythEdwardsNotation\Exception\InvalidFenException::invalidTurn
     */
    public function testInvalidTurn(): void
    {
        // Arrange
        $turn = '/';

        // Act
        $exception = InvalidFenException::invalidTurn($turn);

        // Assert
        static::assertSame('Invalid FEN turn provided: /', $exception->getMessage());
    }
}
