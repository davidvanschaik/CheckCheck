<?php

namespace Validation;

use Board\Board;
use Player\Move;
use Player\Player;

class ValidatePlayer implements Rules
{
    /**
     * @return bool
     * Validates if move belongs to active player
     */
    public function validate(Move $move, Board $board, Player $player): bool
    {
        $square = $board->getRows($move->startPos);
        if ($square->stone?->color !== $player->color) {
            echo "Invalid move: Only your own stones can be moved. Try again! \n";
            return false;
        }
        return true;
    }
}