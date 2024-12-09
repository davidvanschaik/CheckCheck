<?php

namespace Validation;

use Board\Board;
use Board\Position;
use Player\Move;
use Player\Player;

class ValidateContainsOpponentStone implements Rules
{
    public function validate(Move $move, Board $board, Player $player): bool
    {
        if (! (new ValidateContainsStone())->validate($move, $board, $player)) {
            return false;
        }
        return $this->containOpponentStone($move->startPos, $board, $player);
    }

    public function containOpponentStone(Position $position, Board $board, Player $player): bool
    {
        $moveY = $position->y + ($player->color === 'white' ? +1 : -1);
        $contains = [];

        foreach ([$position->x + 1, $position->x - 1] as $direction) {
            $square = $board->getRows("$direction,$moveY");

            if (! is_null($square->stone) && $square->stone->color !== $player->color) {
                $contains[] = $square->stone;
            }
        }
        return ! is_null($contains);
    }
}