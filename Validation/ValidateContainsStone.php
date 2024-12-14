<?php

namespace Validation;

use Board\Board;
use Board\Position;
use Board\Square;
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
        return $square !== null && $square->stone !== null;
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
        $directions = [+ 1, -1 ];

        foreach ($directions as $dir) {
            $direction = $position->x + $dir;
            $square = $board->getRows(new Position($direction, $moveY));
            if (
                $square !== null &&
                $square->stone !== null &&
                $square->stone->color !== $player->color &&
                !$this->isOnBorder($direction)
            ) {
                return true;
            }
        }
        return false;
    }

    private function isOnBorder(int $x): bool
    {
        // Assuming the board size is 8x8
        return $x < 1 || $x > 9;
    }
}