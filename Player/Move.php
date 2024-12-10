<?php

namespace Player;

use Board\Position;

class Move
{
    public Position $startPos;
    public Position $endPos;

    public function __construct(Position $startPosition, Position $endPosition)
    {
        $this->startPos = $startPosition;
        $this->endPos = $endPosition;
    }
}