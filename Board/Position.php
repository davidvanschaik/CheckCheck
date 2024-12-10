<?php

namespace Board;

class Position
{
    public int $x;
    public int $y;

    public function __construct(int $x, int $y)
    {
        $this->x = $x;
        $this->y = $y;
    }

    public function match(int $x, int $y): bool
    {
        return $this->x == $x && $this->y == $y;
    }
}