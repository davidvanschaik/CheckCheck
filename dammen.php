<?php

namespace Game;

require "vendor/autoload.php";

use Player\Player;

(new Checkers([new Player('white'), new Player('black')]))->start();