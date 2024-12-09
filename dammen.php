<?php

namespace Game;

require "vendor/autoload.php";

use Game\Checkers;
use Player\Player;

$spel = new Checkers([new Player('white'), new Player('black')]);

$spel->start();
