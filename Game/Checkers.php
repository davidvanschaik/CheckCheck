<?php

namespace Game;

use Board\Board;
use Board\Position;
use Validation\ValidateAvailableCaptures;

class Checkers
{
    private Board $board;
    private array $players;
    private int $activePlayer;
    private bool $winner;

    public function __construct(array $players)
    {
        $this->board = new Board();
        $this->activePlayer = 0;
        $this->players = $players;
        $this->winner = false;
    }

    public function start(): void
    {
        while (! $this->winner) {
            $this->board->showBoard($this->board);
            [$startPosition, $endPosition] = $this->getPlayerMove();
            $move = $this->players[$this->activePlayer]->setMove($startPosition, $endPosition);
            var_dump((new ValidateAvailableCaptures())->validate($move, $this->board, $this->players[$this->activePlayer]));
        }
    }

    private function getPlayerMove(): array
    {
        $color = ucfirst($this->players[$this->activePlayer]->color);
        $startPosition = $this->setPosition(readline("\n \nIt's $color's turn. Please select a stone to move. (x,y) "));
        $endPosition = $this->setPosition(readline("Choose the destination for your stone (format: x,y) "));

        return [$startPosition, $endPosition];
    }

    private function setPosition(string $position): Position
    {
        list($x, $y) = explode(',', $position);
        return new Position($x, $y);
    }
}