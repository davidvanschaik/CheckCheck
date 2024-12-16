<?php

namespace Board;

use Player\Stone;

class Board
{
    public array $rows;

    /**
     * Generating the rows with array of columns
     */
    public function __construct()
    {
        $row = 7;
        do {
            $this->rows[] = $this->createRows($row);
            $row--;
        } while ($row > -1);
    }

    /**
     * @param int $row
     * @return Square[]
     * Generating columns with array of Square instances with Position, Stone, Color and King
     */
    private function createRows(int $row): array
    {
        $col = 0;
        $rowSquares = [];
        do {
            $position = new Position($col, $row);
            $color = ($row + $col) % 2 == 0 ? 'black' : 'white';
            $rowSquares[] = new Square($position, $color, $this->getStone($row, $color));

            $col++;
        } while ($col < 8);
        return $rowSquares;
    }

    /**
     * @param int $row
     * @param string $color
     * @return Stone|null
     * Determine where on the board the stones will be placed
     */
    private function getStone(int $row, string $color): Stone | null
    {
        if ($color === 'white') {
            if ($row < 1) {
                return new Stone('black');
            } elseif ($row > 6) {
                return new Stone('white');
            }
        }
        return null;
    }

    /**
     * @param Position $position
     * @return Square|null
     * Matches @Square with giving @Position
     */
    public function getRows(Position $position): Square | null
    {
        foreach ($this->rows as $row) {
            $square = array_filter($row, fn ($square) => $square->matchPosition($position));
            if (! empty($square)) {
                return array_values($square)[0];
            }
        }
        return null;
    }
}