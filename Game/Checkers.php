<?php

namespace Game;

use Board\Board;

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
        }
    }

    private function getPlayerMove(): array
    {
        $color = ucfirst($this->players[$this->activePlayer]->color);
        $startPosition = readline("\n \nIt's $color's turn. Please select a stone to move. (x,y)");
        $endPosition = readline("Choose the destination for your stone (format: x,y) ");

        return [$startPosition, $endPosition];
    }
}