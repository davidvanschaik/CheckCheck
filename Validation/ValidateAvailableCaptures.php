<?php

namespace Validation;

use Board\Board;
use Player\Move;
use Player\Player;
use Validation\Rules;

class ValidateAvailableCaptures implements Rules
{
    public function validate(Move $move, Board $board, Player $player)
    {

    }
}