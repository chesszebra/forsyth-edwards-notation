<?php

declare(strict_types=1);

namespace ChessZebra\ForsythEdwardsNotation;

use ChessZebra\ForsythEdwardsNotation\Exception\InvalidCastlingAvailabilityException;

use function strlen;

/**
 * A value that represents the type of castling that is possible.
 */
final class CastlingAvailability
{
    /**
     * Indicates that castling is unavailable.
     */
    public const UNAVAILABLE = 0;

    /**
     * Indicates that castling is possible for black towards the king side.
     */
    public const BLACK_KING_SIDE = 1;

    /**
     * Indiciates that castling is possible for black towards the queen side.
     */
    public const BLACK_QUEEN_SIDE = 2;

    /**
     * Indicates that castling is possible for white towards the king side.
     */
    public const WHITE_KING_SIDE = 4;

    /**
     * Indiciates that castling is possible for white towards the queen side.
     */
    public const WHITE_QUEEN_SIDE = 8;

    /**
     * Indicates that all sides can be castled to.
     */
    public const ALL = 15;

    /**
     * The bitwise value that represents the castling availability.
     */
    private int $value;

    /**
     * Initializes a new instance of this class.
     */
    public function __construct(int $value)
    {
        $this->value = $value;
    }

    /**
     * Gets the value of field "value".
     */
    public function getValue(): int
    {
        return $this->value;
    }

    /**
     * Checks if castling is unavailable.
     *
     * @return bool Returns true when castling is unavailable; false otherwise.
     */
    public function isUnavailable(): bool
    {
        return $this->value === 0;
    }

    /**
     * Checks if castling is possible for black towards the king side.
     *
     * @return bool Returns true when castling is possible; false otherwise.
     */
    public function isBlackKingSideAvailable(): bool
    {
        return ($this->value & self::BLACK_KING_SIDE) === self::BLACK_KING_SIDE;
    }

    /**
     * Checks if castling is possible for black towards the queen side.
     *
     * @return bool Returns true when castling is possible; false otherwise.
     */
    public function isBlackQueenSideAvailable(): bool
    {
        return ($this->value & self::BLACK_QUEEN_SIDE) === self::BLACK_QUEEN_SIDE;
    }

    /**
     * Checks if castling is possible for white towards the king side.
     *
     * @return bool Returns true when castling is possible; false otherwise.
     */
    public function isWhiteKingSideAvailable(): bool
    {
        return ($this->value & self::WHITE_KING_SIDE) === self::WHITE_KING_SIDE;
    }

    /**
     * Checks if castling is possible for white towards the queen side.
     *
     * @return bool Returns true when castling is possible; false otherwise.
     */
    public function isWhiteQueenSideAvailable(): bool
    {
        return ($this->value & self::WHITE_QUEEN_SIDE) === self::WHITE_QUEEN_SIDE;
    }

    /**
     * Creates a duplicate of this class without the availability for black to castle.
     */
    public function withoutBlack(): CastlingAvailability
    {
        $value = $this->value & ~self::BLACK_QUEEN_SIDE & ~self::BLACK_KING_SIDE;

        return new CastlingAvailability($value);
    }

    /**
     * Creates a duplicate of this class without the availability for black to castle.
     */
    public function withoutWhite(): CastlingAvailability
    {
        $value = $this->value & ~self::WHITE_QUEEN_SIDE & ~self::WHITE_KING_SIDE;

        return new CastlingAvailability($value);
    }

    public function toString(): string
    {
        $result = '';

        if ($this->isWhiteKingSideAvailable()) {
            $result .= 'K';
        }

        if ($this->isWhiteQueenSideAvailable()) {
            $result .= 'Q';
        }

        if ($this->isBlackKingSideAvailable()) {
            $result .= 'k';
        }

        if ($this->isBlackQueenSideAvailable()) {
            $result .= 'q';
        }

        return $result;
    }

    public static function parseCastlingAvailability(string $input): CastlingAvailability
    {
        $result = 0;

        for ($i = 0; $i < strlen($input); ++$i) {
            $value = $input[$i];

            switch ($value) {
                case 'k':
                    $result |= self::BLACK_KING_SIDE;
                    break;

                case 'q':
                    $result |= self::BLACK_QUEEN_SIDE;
                    break;

                case 'K':
                    $result |= self::WHITE_KING_SIDE;
                    break;

                case 'Q':
                    $result |= self::WHITE_QUEEN_SIDE;
                    break;

                case '-':
                    break;

                default:
                    throw new InvalidCastlingAvailabilityException('Invalid value provided: ' . $input);
            }
        }

        return new static($result);
    }
}
