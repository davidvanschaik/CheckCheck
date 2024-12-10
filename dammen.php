<?php

namespace Game;

require "vendor/autoload.php";

use Game\Checkers;
use Player\Player;

(new Checkers([new Player('white'), new Player('black')]))->start();
