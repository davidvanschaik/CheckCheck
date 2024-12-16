<?php

namespace Player;

use Board\Board;
use Board\Position;

class Player
{
    public string $color;

    public function __construct($color)
    {
        $this->color = $color;
    }

    public function setMove(Position $startPosition, Position $endPosition): Move
    {
        return new Move($startPosition, $endPosition);
    }

    public function executeMove(Move $move, Board $board): void
    {
        $startSquare = $board->getRows($move->startPos);
        ($board->getRows($move->endPos))->stone = $startSquare->stone;
        $startSquare->stone = null;
        $this->captureStone($move, $board);
    }

    /**
     * @param Move $move
     * @param Board $board
     * @return void
     * Checks if the player made a capture and unsets the stone
     */
    private function captureStone(Move $move, Board $board): void
    {
        if (abs($move->startPos->x - $move->endPos->x) === 2) {
            $moveOverX = $move->startPos->x + ($move->endPos->x - $move->startPos->x) / 2;
            $moveOverY = $move->startPos->y + ($move->endPos->y - $move->startPos->y) / 2;
            $board->getRows(new Position($moveOverX, $moveOverY))->stone = null;
        }
        $this->setKing($move, $board);
    }

    private function setKing(Move $move, Board $board): void
    {
        $y = $this->color === 'white' ? 0 : 7;
        if ($move->endPos->y === $y) {
            $square = $board->getRows(new Position($move->endPos->x, $move->endPos->y));
            $square->stone = new King($this->color);
        }
    }
}