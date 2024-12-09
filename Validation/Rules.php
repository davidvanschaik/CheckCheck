<?php

namespace Validation;

use Board\Board;
use Player\Move;
use Player\Player;

interface Rules
{
    public function validate(Move $move, Board $board, Player $player);
}