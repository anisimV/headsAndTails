<?php

require_once 'classes/game.php';
require_once 'classes/player.php';

$game = new Game(
    new Player("Anton", 100),
    new Player("Anisim", 100),
);

$game->start();
