<?php

namespace Game;

use Board\Board;
use Board\Position;
use Player\Move;
use Validation\RuleValidator;

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
            $this->board->showBoard();
            $move = $this->getPlayerMove();
            $this->validateRules($move);
        }
    }

    private function getPlayerMove(): Move
    {
        $color = ucfirst($this->players[$this->activePlayer]->color);
        $startPosition = $this->setPosition(readline("\n \nIt's $color's turn. Please select a stone to move. (x,y) "));
        $endPosition = $this->setPosition(readline("Choose where you want to move your stone. (x,y) "));
        return $this->players[$this->activePlayer]->setMove($startPosition, $endPosition);
    }

    private function setPosition(string $position): Position
    {
        list($x, $y) = explode(',', $position);
        return new Position($x, $y);
    }

    private function validateRules(Move $move): void
    {
        if ((new RuleValidator())->validateMove($move, $this->board, $this->players[$this->activePlayer])) {
            $this->players[$this->activePlayer]->executeMove($move, $this->board);
            $this->activePlayer = 1 - $this->activePlayer;
        }
    }
}