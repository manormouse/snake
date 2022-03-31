<?php

namespace App\Application;

use App\Domain\Game;
use App\Infrastructure\BoardRender;

class PlayGameService
{
    public function execute(Game $game, BoardRender $boardRender)
    {
        $nextMovement = $game->snake->direction(STDIN);
        $game->move($nextMovement);

        echo $boardRender->render($game->board, $game->snake);

        if ($game->isGameOver()) {
            die('dead   :(');
        }

        usleep($game->speed);
    }
}