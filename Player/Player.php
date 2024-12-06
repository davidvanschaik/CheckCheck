<?php

namespace Player;

use Board\Position;

class Player
{
    public string $stoneColor;

    public function __construct($color)
    {
        $this->stoneColor = $color;
    }

    public function setMove(int $startPosition, int $endPosition): Move
    {
        return new Move($startPosition, $endPosition);
    }
}