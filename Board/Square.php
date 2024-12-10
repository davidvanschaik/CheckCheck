<?php

namespace Board;

use Player\King;
use Player\Stone;

class Square
{
    public Position $position;
    public string $color;
    public null | Stone $stone;
    public null | King $king;

    public function __construct(Position $position, string $color, Stone $stone = null, King $king = null)
    {
        $this->position = $position;
        $this->color = $color;
        $this->stone = $stone;
        $this->king = $king;
    }

    public function setKing(): void
    {
        $this->king = new King($this->stone->color);
        unset($this->stone);
    }

    public function matchPosition(Position $position): bool
    {
        return $position->match($this->position->x, $this->position->y);
    }
}