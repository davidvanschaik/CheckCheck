<?php

namespace Validation;

use Board\Board;
use Player\Move;
use Player\Player;

class ValidatePlayer implements Rules
{
    public function validate(Move $move, Board $board, Player $player): bool
    {
        $square = $board->getRows($move->startPos);
        return $square->stone->color === $player->color;
    }
}