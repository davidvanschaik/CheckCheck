<?php

namespace Player;

use Board\Position;

class Move
{
    public Position $startPos;
    public Position $endPos;

    public function __construct(int $startPosition, int $endPosition)
    {
        $this->startPos = new Position($startPosition);
        $this->endPos = new Position($endPosition);
    }
}