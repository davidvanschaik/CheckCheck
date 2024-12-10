<?php

namespace Validation;

use Board\Board;
use Board\Position;
use Player\Move;
use Player\Player;

class ValidateContainsStone implements Rules
{
    public function validate(Move $move, Board $board, Player $player): bool
    {
        return $this->containsStone($board, $move->endPos);
    }

    public function containsStone(Board $board, Position $position): bool
    {
        $square = $board->getRows($position);
        if (is_object($square) && property_exists($square, 'stone')) {
            return ! is_null($square->stone);
        }
        return false;
    }
}