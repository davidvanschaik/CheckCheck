<?php

namespace Validation;

use Board\Board;
use Player\Move;
use Player\Player;
use Validation\Rules;

class ValidateContainsStone implements Rules
{
    public function validate(Move $move, Board $board, Player $player): bool
    {
        return $this->containsStone($board, $move);
    }

    public function containsStone(Board $board, Move $move): bool
    {
        $square = $board->getRows("{$move->startPos->x},{$move->startPos->y}");
        if (is_object($square) && property_exists($square, 'stone')) {
            return !is_null($square->stone);
        }
        return false;
    }
}