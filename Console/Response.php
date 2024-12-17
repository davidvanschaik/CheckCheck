<?php

namespace Console;

use Board\Board;
use Board\Square;

class Response
{
    public function showBoard(Board $board, $activePlayer): void
    {
        echo "\033[2J\033[H";
        $rowNumber = 9;
        $margin = $this->margin($board);
        echo " $margin It's " . ucfirst($activePlayer->color) . "'s turn \n \n \n";

        foreach ($board->rows as $row) {
            echo $margin;
            $this->printNumbers($rowNumber--);
            foreach ($row as $square) {
                $this->print($square);
            }
            print_r(PHP_EOL);
        }
        echo $margin;
        $this->printColumn();
    }

    private function print(Square $square): void
    {
        $backgroundColor = $square->color === 'white' ? 'GRAY_BG' : 'BLACK_BG';
        $stone = $this->getStoneOrKing($square);
        $forgroundColor = $this->getStoneColor($square);
        $bold = isset($square->stone) && $square->stone->color === 'black' ?? false;
        print_r(Colors::getColoredString($stone, $bold, $forgroundColor, $backgroundColor));
    }

    private function getStoneOrKing(Square $square): string
    {
        if (isset($square->stone) && $square->stone->captureBackwards($square->stone)) {
            return $square->stone->color === 'white' ? "𝐊♛" : "♛𝐊";
        }
        if (isset($square->stone)) {
            return "()";
        }
        return "  ";
    }

    private function getStoneColor(Square $square): null | string
    {
        if (isset($square->stone)) {
            return $square->stone->color === 'white' ? 'GRAY' : 'BLACK';
        }
        return null;
    }

    private function printNumbers(int $number): void
    {
        print_r(Colors::getColoredString(Colors::DIGITS[$number], false));
    }

    private function printColumn(): void
    {
        print_r(Colors::getColoredString("  ", "white"));
        for ($columnNumber = 0; $columnNumber < 10; $columnNumber++) {
            $this->printNumbers($columnNumber);
        }
        print_r(PHP_EOL);
    }

    private function margin(Board $board): string
    {
        $terminalWidth = exec('tput cols');
        $boardWidth = count($board->rows[0]);
        return str_repeat(' ', ($terminalWidth - $boardWidth - 15) / 2);
    }
}