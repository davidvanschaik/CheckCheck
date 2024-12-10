<?php

namespace Validation;

use Board\Board;
use Board\Position;
use Board\Square;
use Player\Move;
use Player\Player;

class ValidateAvailableMoves implements Rules
{
    public function validate(Move $move, Board $board, Player $player): array
    {
        $availableStones = (new ValidateAvailableStones())->validate($move, $board, $player);
        $moveY = $player->color === 'white' ? - 1 : + 1;

        return array_reduce($availableStones, function ($availableMoves, $stone) use ($moveY, $board, $move) {
            $stonePosition = new Position($stone->position->x, $stone->position->y);
            $this->validateAvailableMoves($stone, $stonePosition, $moveY, $board);
            return array_merge($availableMoves, $this->validateAvailableMoves($stone, $stonePosition, $moveY, $board));
        }, []);
    }

    private function validateAvailableMoves(Square $stone, Position $stonePosition, int $moveY, $board): array
    {
        $availableMoves = [];
        $positionDirection = [- 1, + 1];

        foreach ($positionDirection as $direction) {
            $moveToPosition = new Position($stone->position->x + $direction, $stone->position->y + $moveY);
            if (
                (new ValidatePosition())->validatePosition($moveToPosition) &&
                ! (new ValidateContainsStone())->containsStone($board, $moveToPosition)
            ) {
                $availableMoves[] = new Move($stonePosition, $moveToPosition);
            }
        }
        return $availableMoves;
    }
}