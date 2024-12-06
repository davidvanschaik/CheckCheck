<?php

namespace Board;

use Player\Stone;

class Board
{
    public array $rows;
    public Color $color;

    public function __construct()
    {
        $this->color = new Color();
        for ($row = 0; $row < 10; $row++) {
            $rowSquares = [];
            for ($col = 0; $col < 10; $col++) {
                $position = new Position("$row,$col");
                $color = ($row + $col) % 2 == 0 ? 'white' : 'black';
                $stone = $this->getStone($row, $color);

                $rowSquares[] = new Square($position, $color, $stone);
            }
            $this->rows[] = $rowSquares;
        }
    }

    private function getStone(int $row, string $color): Stone | null
    {
        if ($color === 'white') {
            if ($row < 4) {
                return new Stone('white');
            } elseif ($row > 5) {
                return new Stone('black');
            }
        }
        return null;
    }

    public function showBoard(): void
    {
        $rowNumber = 0;
        $this->printColumn();

        foreach ($this->rows as $row) {
            $this->printNumbers($rowNumber++);
            foreach ($row as $square) {
                $backgroundColor = $square->color === 'white' ? 'light_gray' : 'black';
                $stone = isset($square->stone) ? "()" : "  ";
                $forgroundColor = $this->getStoneColor($square);
                $bold = isset($square->stone) && $square->stone->color === 'black' ?? false;
                print_r($this->color->getColoredString($stone, $bold, $forgroundColor, $backgroundColor));
            }
            print_r(PHP_EOL);
        }
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
        print_r($this->color->getColoredString($number++ . " ", "white", "magenta"));
    }

    private function printColumn(): void
    {
        print_r($this->color->getColoredString("  ", "white", "magenta"));
        for ($columnNumber = 0; $columnNumber < 10; $columnNumber++) {
            $this->printNumbers($columnNumber);
        }
        print_r(PHP_EOL);
    }

    public function getRows($position): Square
    {
        list($x, $y) = explode(',', $position);
        $match = '';

        foreach ($this->rows as $row) {
            foreach ($row as $square) {
                if ($square->getPosition($x, $y)) {
                    $match = $square;
                }
            }
        }
        return $match;
    }
}