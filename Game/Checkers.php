<?php

namespace Game;

use Board\Board;
use Player\Player;
use Validation\RuleValidator;

class Checkers
{
    private Board $board;
    private array $players;
    private int $activePlayer;

    public function __construct(array $players)
    {
        $this->board = new Board();
        $this->activePlayer = 0;
        $this->players = $players;
    }

    public function start(): void
    {
        $this->board->showBoard();
        $position = readline("welk vak wil je ophalen? \n");

        var_dump($this->board->getRows($position));
    }
}