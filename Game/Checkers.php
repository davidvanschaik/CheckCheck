<?php

namespace Game;

use Board\Board;
use Board\Position;
use Player\Move;
use Console\Response;
use Player\Player;
use Validation\RuleValidator;
use Validation\ValidateContainsStone;

class Checkers
{
    private Board $board;
    private array $players;
    private int $activePlayer;
    private Response $response;
    private bool $winner;

    public function __construct(array $players)
    {
        $this->board = new Board();
        $this->activePlayer = 0;
        $this->players = $players;
        $this->response = new Response();
        $this->winner = false;
    }

    public function start(): void
    {
        do {
            $this->response->showBoard($this->board, $this->players[$this->activePlayer]);
            do {
                $move = $this->getPlayerMove();
                $validateMove = (new RuleValidator())->validateMove($move, $this->board, $this->players[$this->activePlayer]);
            } while (!$validateMove);

            $this->players[$this->activePlayer]->executeMove($move, $this->board);
            $this->activePlayer = 1 - $this->activePlayer;
            $this->validateWinner($this->board, $this->players[$this->activePlayer]);
        } while (! $this->winner);
    }

    private function getPlayerMove(): Move
    {
        $startPosition = $this->setPosition(readline("\n \nPlease select a stone to move. (x,y) "));
        $endPosition = $this->setPosition(readline("Choose where you want to move your stone. (x,y) "));

        return $this->players[$this->activePlayer]->setMove($startPosition, $endPosition);
    }

    private function setPosition(string $position): Position
    {
        list($x, $y) = explode(',', $position);
        return new Position($x, $y);
    }

    private function validateWinner(Board $board, Player $activePlayer): void
    {
        $stones = (new ValidateContainsStone())->getAllStones($this->board);
        foreach (['black', 'white'] as $color) {
            if (count($stones[$color]) === 0) {
                $this->response->showBoard($board, $activePlayer);
                echo $color === 'white' ? "Black" : "white" . " wins \n";
                $this->winner = true;
            }
        }
    }
}