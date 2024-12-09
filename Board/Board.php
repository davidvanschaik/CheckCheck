<?php

namespace Board;

use Player\Stone;

class Board
{
    public array $rows;
    public Color $color;

    public function __construct()
    {
        $row = 9;
        $this->color = new Color();
        do {
            $this->rows[] = $this->createRows($row);
            $row--;
        } while ($row > -1);
    }

    private function createRows(int $row): array
    {
        $col = 0;
        $rowSquares = [];
        do {
            $position = new Position("$col,$row");
            $color = ($row + $col) % 2 == 0 ? 'black' : 'white';
            $rowSquares[] = new Square($position, $color, $this->getStone($row, $color));

            $col++;
        } while ($col < 10);
        return $rowSquares;
    }

    private function getStone(int $row, string $color): Stone | null
    {
        if ($color === 'white') {
            if ($row < 4 || $row === 5) {
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

    public function getRows($position): Square | string
    {
        foreach ($this->rows as $row) {
            foreach ($row as $square) {
                if ($square->matchPosition($position)) {
                    return $square;
                }
                return '';
            }
        }
    }
}