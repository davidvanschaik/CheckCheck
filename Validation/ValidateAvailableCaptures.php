<?php

namespace Validation;

use Board\Board;
use Board\Position;
use Board\Square;
use Player\Move;
use Player\Player;

class ValidateAvailableCaptures implements Rules
{
    public function validate(Move $move, Board $board, Player $player): bool
    {
        $availableCaptures = $this->getAvailableCaptures($move, $board, $player);
        $availableMoves = $this->getAvailableMoves($move, $board, $player);

        if (! empty($availableCaptures)) {
            if (in_array($move, $availableCaptures)) {
                return true;
            }
            echo "You must Capture \n";
            return false;
        }
        if (in_array($move, $availableMoves)) {
            return true;
        }
        echo "Invalid move... Try again. \n";
        return false;
    }

    /**
     * @return array
     * Validates and retrieves all possible capture moves for a player based on the current game state.
     */
    private function getAvailableCaptures(Move $move, Board $board, Player $player): array
    {
        $availableStones = $this->getAvailableStones($move, $board, $player);
        return array_reduce($availableStones, function ($captures, $square) use ($move, $board, $player) {
            $moveY = $square->stone->moveDirection($square->stone);
            $position = $square->position;
            return array_merge($captures, $this->validateAvailableCaptures($moveY, $position, $board, $player));
        }, []);
    }

    /**
     * @param int $moveY
     * @param Position $position
     * @param Board $board
     * @param Player $player
     * @return array
     * Validates all the possible captures based on active player's stones.
     */
    private function validateAvailableCaptures(
        array    $moveY,
        Position $position,
        Board    $board,
        Player   $player
    ): array
    {
        $availableCaptures = [];
        $moveFrom = new Position($position->x, $position->y);

        foreach ($moveY as $directionY) {
            foreach ([-2, +2] as $directionX) {
                $moveTo = new Position(($position->x + $directionX), ($position->y + ($directionY * 2)));
                if (
                    (new ValidatePosition())->validatePosition($moveTo) &&
                    ! (new ValidateContainsStone())->containsStone($board, $moveTo) &&
                    (new ValidateContainsStone())->containOpponentStone($moveFrom, $board, $player, $directionY)
                ) {
                    $availableCaptures[] = new Move($position, $moveTo);
                }
            }
        }
        return $availableCaptures;
    }

    /**
     * @return array
     * Returns all the possible moves the current player can execute .
     */
    public function getAvailableMoves(Move $move, Board $board, Player $player): array
    {
        $availableStones = $this->getAvailableStones($move, $board, $player);
        return array_reduce($availableStones, function ($availableMoves, $square) use ($board, $move) {
            $moveY = $square->stone->moveDirection($square->stone);
            $stonePosition = new Position($square->position->x, $square->position->y);
            return array_merge($availableMoves, $this->validateAvailableMoves($square, $stonePosition, $moveY, $board));
        }, []);
    }

    /**
     * @param Square $stone
     * @param Position $stonePosition
     * @param int $moveY
     * @param $board
     * @return array
     * Returns array of Square instances that are not in use by any of the players stones that the active player can
     * make a move on
     */
    private function validateAvailableMoves(Square $square, Position $stonePosition, array $moveY, Board $board): array
    {
        $availableMoves = [];
        foreach ($moveY as $directionY) {
            foreach ([- 1, + 1] as $directionX) {
                $moveToPosition = new Position($square->position->x + $directionX, $square->position->y + $directionY);
                if (
                    (new ValidatePosition())->validatePosition($moveToPosition) &&
                    ! (new ValidateContainsStone())->containsStone($board, $moveToPosition)
                ) {
                    $availableMoves[] = new Move($stonePosition, $moveToPosition);
                }
            }
        }
        return $availableMoves;
    }

    /**
     * @return array
     * Retrieves all the squares on the board that contains active player's stones
     */
    private function getAvailableStones(Move $move, Board $board, Player $player): array
    {
        return array_reduce($board->rows, function ($availableSquares, $row) use ($player) {
            foreach ($row as $square) {
                if (! is_null($square->stone) && $square->stone->color === $player->color) {
                    $availableSquares[] = $square;
                }
            }
            return $availableSquares;
        }, []);
    }
}