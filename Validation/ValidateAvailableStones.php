<?php

namespace Validation;

use Board\Board;
use Player\Move;
use Player\Player;

class ValidateAvailableStones implements Rules
{
    public function validate(Move $move, Board $board, Player $player): array
    {
        return array_reduce($board->rows, function ($availableSquares, $row) use ($player) {
            foreach ($row as $square) {
                if (! is_null($square->stone) && $square->stone->color === $player->color) {
                    $availableSquares[] = $square;
                }
            }
            return $availableSquares;
        }, []);
    }
}