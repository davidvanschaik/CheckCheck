<?php

namespace Board;

use Player\Stone;

class Square
{
    public Position $position;
    public string $color;
    public null | Stone $stone;

    public function __construct(Position $position, string $color, Stone $stone = null)
    {
        $this->position = $position;
        $this->color = $color;
        $this->stone = $stone;
    }

    public function getPosition(int $x, int $y): bool
    {
        return $this->position->match($x, $y);
    }
}