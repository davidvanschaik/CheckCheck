<?php

namespace Validation;

use Board\Board;
use Board\Position;
use Player\Move;
use Player\Player;

class ValidateAvailableCaptures implements Rules
{
    public function validate(Move $move, Board $board, Player $player)
    {
        $availableStones = (new ValidateAvailableStones())->validate($move, $board, $player);
        return array_reduce($availableStones, function ($captures, $square) use ($move, $board, $player) {
            $moveY = ($player->color === 'white' ? -1 : 1);
            $position = $square->position;
            return array_merge($captures, $this->validateCaptures($moveY, $position, $board, $player));
        }, []);
    }

    private function validateCaptures(
        int      $moveY,
        Position $position,
        Board    $board,
        Player   $player
    ): array
    {
        $availableCaptures = [];
        foreach ([+2, -2] as $direction) {
            $moveTo = new Position($position->x + $direction, $position->y + ($moveY * 2));
            $moveOver = new Position($position->x + ($direction / 2), $position->y + $moveY);
            if (
                (new ValidatePosition())->validatePosition($moveTo) &&
                !(new ValidateContainsStone())->containsStone($board, $moveTo) &&
                (new ValidateContainsOpponentStone())->containOpponentStone($moveOver, $board, $player)
            ) {
                $availableCaptures[] = new Move($position, $moveTo);
            }
        }
        return $availableCaptures;
    }
}