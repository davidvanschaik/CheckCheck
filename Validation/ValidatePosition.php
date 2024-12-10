<?php

namespace Validation;

use Board\Board;
use Board\Position;
use Player\Move;
use Player\Player;

class ValidatePosition implements Rules
{
    /**
     * @return bool
     * Validates if the current move positions are valid position on the board
     */
    public function validate(Move $move, Board $board, Player $player): bool
    {
        foreach ([$move->startPos, $move->endPos] as $position) {
            return $this->validatePosition($position);
        }
    }

    public function validatePosition(Position $position): bool
    {
        if ($position->x > 9 || $position->x < 0) {
            return false;
        }
        if ($position->y > 9 || $position->y < 0) {
            return false;
        }
        return true;
    }
}