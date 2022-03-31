<?php

namespace App\Command;

use App\Application\PlayGameService;
use App\Domain\Game;
use App\Infrastructure\BoardRender;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GameCommand extends Command
{
    protected static $defaultName = 'snake';
    private PlayGameService $playGameService;

    public function __construct(string $name = null)
    {
        parent::__construct($name);

        $this->playGameService = new PlayGameService();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $stdin = fopen('php://stdin', 'r');
        stream_set_blocking(STDIN, 0);
        system('stty cbreak -echo');

        $game = new Game(20, 40);
        $boardRender = new BoardRender();

        while (1) {
            system('clear');
            echo 'Level: ' . $game->snake->tail . PHP_EOL;

            $this->playGameService->execute($game, $boardRender);
        }
    }
}