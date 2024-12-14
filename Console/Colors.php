<?php

namespace Console;

class Colors
{
//    Forground Colors
    public const BLACK = "\033[0;30m";
    public const GRAY = "\033[0;37m";
    public const WHITE = "\033[1;37m";
    public const BOLD = "\033[1m";

//    Background Colors
    public const BLACK_BG = "\033[48m";
    public const GRAY_BG = "\033[47m";

//    ASCII Characters
    public const DIGITS = [
        0 => "\u{FF10}",
        1 => "\u{FF11}",
        2 => "\u{FF12}",
        3 => "\u{FF13}",
        4 => "\u{FF14}",
        5 => "\u{FF15}",
        6 => "\u{FF16}",
        7 => "\u{FF17}",
        8 => "\u{FF18}",
        9 => "\u{FF19}",
    ];

    // Returns colored string
    public static function getColoredString(
        string $stone,
        bool $bold,
        string | null $foreground = null,
        string | null $background = null
    ): string
    {
        $colored_string = "";
        if (! is_null($foreground)) {
            $colored_string .= self::{$foreground};
        }
        if (! is_null($background)) {
            $colored_string .= self::{$background};
        }
        if ($bold) {
            $colored_string .= self::BOLD;
        }
        $colored_string .= $stone . "\033[0m";
        return $colored_string;
    }
}
