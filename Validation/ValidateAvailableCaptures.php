<?php

namespace Validation;

use Board\Board;
use Board\Position;
use Player\Move;
use Player\Player;
use Validation\Rules;

class ValidateAvailableCaptures implements Rules
{
    public function validate(Move $move, Board $board, Player $player)
    {
        $availableCaptures = [];
        $moveY = ($player->color === 'white' ? +1 : -1);
        $availableStones = (new ValidateAvailableStones())->validate($move, $board, $player);
        foreach ($availableStones as $square) {
            $position = $square->position;
            $van = $this->setPosition($position->x, $position->y);
            $naar = $this->setPosition($position->x + 2, $position->y + ($moveY * 2));
            $over = $this->setPosition($position->x + 1, ($position->y + $moveY));

            var_dump((new ValidateContainsOpponentStone())->containOpponentStone(new Position($van), $board, $player));
//            if ((new ValidatePosition())->validatePosition([new Position($naar)])) {
//                if (
//                    !(new ValidateContainsStone())->containsStone($board, new Move($van, $naar)) &&
//                    (new ValidateContainsOpponentStone())->containOpponentStone(new Position($van), $board, $player)
//                ) {
//                    $availableCaptures[] = new Move($position, $naar);
//                }
//            }
//            $naar = $this->setPosition($position->x - 2, $position->y + ($moveY * 2));
//            $over = $this->setPosition($position->x - 1, ($position->y + $moveY));
//            if ((new ValidatePosition())->validatePosition([new Position($naar)])) {
//                if (
//                    !(new ValidateContainsStone())->containsStone($board, new Move($van, $naar)) &&
//                    (new ValidateContainsOpponentStone())->containOpponentStone(new Position($van), $board, $player)
//                ) {
//                    $availableCaptures[] = new Move($position, $naar);
//                }
//            }
            return $availableCaptures;
        }
    }

    private function setPosition(int $x, int $y): string
    {
        return "$x,$y";
    }
}