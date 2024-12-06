<?php

namespace Game;

require "vendor/autoload.php";

use Game\Checkers;
use Player\Player;

$spel = new Checkers([new Player(), new Player()]);

$spel->start();
