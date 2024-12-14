<?php

namespace Player;

abstract class Pieces
{
    public string $color;

    public function captureBackwards(self $stone): bool
    {
        return $stone instanceof King;
    }

    public function moveDirection(self $stone): array
    {
        if ($stone instanceof King) {
            return [-1, +1];
        }
        return $this->color === 'white' ? [-1] : [+1];
    }
}