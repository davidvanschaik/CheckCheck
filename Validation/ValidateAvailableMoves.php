<?php

namespace Validation;

use Board\Board;
use Board\Position;
use Board\Square;
use Player\Move;
use Player\Player;
use Validation\Rules;

class ValidateAvailableMoves implements Rules
{
    public function validate(Move $move, Board $board, Player $player): array
    {
        $availableStones = (new ValidateAvailableStones())->validate($move, $board, $player);
        $moveY = $player->color === 'white' ? -1 : +1;

        return array_reduce($availableStones, function ($acc, $stone) use ($moveY, $board, $move) {
            $stonePosition = $this->setPosition($stone->position->x, $stone->position->y);
            $this->validateAvailableMoves($stone, $stonePosition, $moveY, $board);
            return array_merge($acc, $this->validateAvailableMoves($stone, $stonePosition, $moveY, $board));
        }, []);
    }

    private function setPosition(int $x, int $y): string
    {
        return "$x,$y";
    }

    private function validateAvailableMoves(Square $stone, string $stonePosition, int $moveY, $board): array
    {
        $acc = [];
        $positionDirection = [- 1, + 1];

        foreach ($positionDirection as $direction) {
            $moveToPosition = $this->setPosition($stone->position->x + $direction, $stone->position->y + $moveY);
            if (
                (new ValidatePosition())->validatePosition([new Position($moveToPosition)]) &&
                ! (new ValidateContainsStone())->containsStone($board, new Move($stonePosition, $moveToPosition))
            ) {
                $acc[] = new Move("$stonePosition", $moveToPosition);
            }
        }
        return $acc;
    }
}