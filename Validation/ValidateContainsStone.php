<?php

namespace Validation;

use Board\Board;
use Board\Position;
use Player\Move;
use Player\Player;

class ValidateContainsStone implements Rules
{
    /**
     * @return bool
     * Returns boolean if giving position contains stone.
     */
    public function validate(Move $move, Board $board, Player $player): bool
    {
        return  $this->containsStone($board, $move->endPos) &&
                $this->containOpponentStone($move->startPos, $board, $player);
    }

    /**
     * @param Board $board
     * @param Position $position
     * @return bool
     */
    public function containsStone(Board $board, Position $position): bool
    {
        $square = $board->getRows($position);
        if (is_object($square) && property_exists($square, 'stone')) {
            return ! is_null($square->stone);
        }
        return false;
    }

    /**
     * @param Position $position
     * @param Board $board
     * @param Player $player
     * @return bool
     * Validate based on the giving position and current player if position contains opponent stone
     */
    public function containOpponentStone(Position $position, Board $board, Player $player): bool
    {
        $moveY = $position->y + ($player->color === 'white' ? - 1 : + 1);
        $contains = [];

        foreach ([$position->x + 1, $position->x - 1] as $direction) {
            $square = $board->getRows(new Position($direction, $moveY));

            if (! is_null($square?->stone) && $square->stone->color !== $player->color) {
                $contains[] = $square;
            }
        }
        return ! empty($contains);
    }
}