<?php

namespace Validation;

use Board\Board;
use Board\Position;
use Player\Move;
use Player\Player;
use Validation\Rules;

class ValidateAvailableMoves implements Rules
{
    public function validate(Move $move, Board $board, Player $player): array
    {
        $moveDirection = ($player->color === 'white' ? -1 : +1);
        $availableSquares = (new ValidateAvailableStones())->validate($move, $board, $player);
        $availableMoves = [];

        foreach ($availableSquares as $stonePosition) {
            $availableMoves[] = $this->availableMoves($stonePosition->position, [+1, -1], $moveDirection, $board, $move);
        }
        return $availableMoves;
    }

    private function availableMoves($stonePosition, array $moveX, int $moveY, Board $board, Move $move): array
    {
        $availableMoves = [];
        foreach ($moveX as $direction) {
            $moveTo = new Position($this->setPositions($stonePosition->x + $direction, $stonePosition->y + $moveY));
            if (
                (new ValidatePosition())->validatePosition([$moveTo])
                && ! (new ValidateContainsStone())->containsStone($board, $move)
            ) {
                $availableMoves[] = new Move("{$stonePosition->x},{$stonePosition->y}", $this->setPositions($stonePosition->x + $direction, $stonePosition->y + $moveY));
            }
        }
        var_dump($availableMoves);
        die;
    }

    private function setPositions(int $a, int $b): string
    {
       return "$a,$b";
    }
}