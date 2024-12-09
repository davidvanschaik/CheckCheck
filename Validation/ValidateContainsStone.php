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
        return ! is_null($board->getRows("{$move->startPos->x},{$move->startPos->y}")->stone) ;
    }
}