<?php

namespace Validation;

use Board\Board;
use Player\Move;
use Player\Player;

interface Rules
{
    /**
     * @param Move $move
     * @param Board $board
     * @param Player $player
     */
    public function validate(Move $move, Board $board, Player $player);
}