<?php

namespace Board;

class Position
{
    public int $x;
    public int $y;

    public function __construct(string $position)
    {
        list($this->y, $this->x) = explode(',', $position);
    }

    public function match(int $x, int $y): bool
    {
        return $this->x == $x && $this->y == $y;
    }
}