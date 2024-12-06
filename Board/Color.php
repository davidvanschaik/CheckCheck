<?php

namespace Board;

class Color
{
    private $foreground_colors = array();
    private $background_colors = array();

    public function __construct()
    {
        // Set up shell colors
        $this->foreground_colors['black'] = '0;30';
        $this->foreground_colors['light_gray'] = '0;37';
        $this->foreground_colors['white'] = '1;37';

        $this->background_colors['light_gray'] = '47';
        $this->background_colors['black2'] = '48';
    }

    // Returns colored string
    public function getColoredString($string, $bold, $foreground_color = null, $background_color = null)
    {
        $colored_string = "";
        // Check if given foreground color found
        if (isset($this->foreground_colors[$foreground_color])) {
            $colored_string .= "\033[" . $this->foreground_colors[$foreground_color] . "m";
        }
        // Check if given background color found
        if (isset($this->background_colors[$background_color])) {
            $colored_string .= "\033[" . $this->background_colors[$background_color] . "m";
        }
        if ($bold) {
            $colored_string .= "\033[1m"; // Vetgedrukt inschakelen
        }
        // Add string and end coloring
        $colored_string .= $string . "\033[0m";
        return $colored_string;
    }

    // Returns all foreground color names
    public function getForegroundColors()
    {
        return array_keys($this->foreground_colors);
    }

    // Returns all background color names
    public function getBackgroundColors()
    {
        return array_keys($this->background_colors);
    }
}