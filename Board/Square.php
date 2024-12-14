<?php

namespace Board;

use Player\Pieces;
use Player\Stone;

class Square
{
    public Position $position;
    public string $color;
    public null | Pieces $stone;

    public function __construct(Position $position, string $color, Stone $stone = null)
    {
        $this->position = $position;
        $this->color = $color;
        $this->stone = $stone;
    }

    public function matchPosition(Position $position): bool
    {
        return $position->match($this->position->x, $this->position->y);
    }
}