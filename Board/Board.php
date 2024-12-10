<?php

namespace Board;

use Player\Stone;

class Board
{
    public array $rows;
    public Color $color;

    /**
     * Generating the rows with array of columns
     */
    public function __construct()
    {
        $row = 9;
        $this->color = new Color();
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
        } while ($col < 10);
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
            if ($row < 4) {
                return new Stone('black');
            } elseif ($row > 5) {
                return new Stone('white');
            }
        }
        return null;
    }

    public function showBoard(): void
    {
        $rowNumber = 9;

        foreach ($this->rows as $row) {
            $this->printNumbers($rowNumber--);
            foreach ($row as $square) {
                $backgroundColor = $square->color === 'white' ? 'light_gray' : 'black';
                $stone = isset($square->stone) ? "()" : "  ";
                $forgroundColor = $this->getStoneColor($square);
                $bold = isset($square->stone) && $square->stone->color === 'black' ?? false;
                print_r($this->color->getColoredString($stone, $bold, $forgroundColor, $backgroundColor));
            }
            print_r(PHP_EOL);
        }
        $this->printColumn();
    }

    private function getStoneColor(Square $square): null | string
    {
        if (isset($square->stone)) {
            return $square->stone->color === 'white' ? 'light_gray' : 'black';
        }
        return null;
    }

    private function printNumbers(int $number): void
    {
        print_r($this->color->getColoredString($number . " ", "white", "magenta"));
    }

    private function printColumn(): void
    {
        print_r($this->color->getColoredString("  ", "white", "magenta"));
        for ($columnNumber = 0; $columnNumber < 10; $columnNumber++) {
            $this->printNumbers($columnNumber);
        }
        print_r(PHP_EOL);
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