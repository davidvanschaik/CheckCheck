<?php

namespace Validation;

use Board\Board;
use Player\Move;
use Player\Player;
use Validation\Rules;

class ValidatePosition implements Rules
{
    public function validate(Move $move, Board $board, Player $player): bool
    {
        return $this->validatePosition([$move->startPos, $move->endPos]);
    }

    public function validatePosition(array $positions): bool
    {
        foreach ($positions as $position) {
            if ($position->x > 9 || $position->x < 0) {
                return false;
            }
            if ($position->y > 9 || $position->y < 0) {
                return false;
            }
        }
        return true;
    }
}