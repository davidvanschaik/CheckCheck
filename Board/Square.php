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

    public function __construct(Position $position, string $color, Stone $stone = null, King $dam = null)
    {
        $this->position = $position;
        $this->color = $color;
        $this->stone = $stone;
    }

    public function setKing(): void
    {
        $this->king = new King($this->stone->color);
        unset($this->stone);
    }

    public function matchPosition(string $position): bool
    {
        list($x, $y) = explode(',', $position);
        return $this->position->x === intval($x) && $this->position->y === intval($y);
    }
}