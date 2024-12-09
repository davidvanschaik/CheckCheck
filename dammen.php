<?php

namespace Game;

require "vendor/autoload.php";

use Game\Checkers;
use Player\Player;

$spel = new Checkers([new Player('black'), new Player('white')]);

$spel->start();
