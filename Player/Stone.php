<?php

namespace Player;

class Stone extends Pieces
{
    public function __construct($color)
    {
        $this->color = $color;
    }
}