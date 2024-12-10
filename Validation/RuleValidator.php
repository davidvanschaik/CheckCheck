<?php

namespace Validation;

use Board\Board;
use Board\Position;
use Player\Player;
use Player\Stone;
use Player\Move;

class RuleValidator
{
    private array $rules;

    public function __construct()
    {
        $this->rules = [
            'position' => new ValidatePosition(),
            'player' => new ValidatePlayer(),
            'captures' => new ValidateAvailableCaptures()
        ];
    }

    /**
     * @param Move $move
     * @param Board $board
     * @param Player $player
     * @return bool
     */
    public function validateMove(Move $move, Board $board, Player $player): bool
    {
        foreach ($this->rules as $rule) {
            if (! $rule->validate($move, $board, $player)) {
                return false;
            }
        }
        return true;
    }
}