<?php

namespace Player;

use Board\Position;

class Player
{
    public string $color;

    public function __construct($color)
    {
        $this->color = $color;
    }

    public function setMove(Position $startPosition, Position $endPosition): Move
    {
        return new Move($startPosition, $endPosition);
    }
}