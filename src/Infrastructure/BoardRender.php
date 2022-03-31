<?php

namespace App\Infrastructure;

use App\Domain\Board;
use App\Domain\Snake;

class BoardRender
{
    const HEADER =
<<<EOD
                    /^\/^\
                  _|__|  O|
         \/     /~     \_/ \
          \____|__________/  \
                 \_______      \
                         `\     \                 \
                           |     |                  \
                          /      /                    \
                         /     /                       \
                       /      /                         \ \
                      /     /                            \  \
                    /     /             _----_            \   \
                   /     /           _-~      ~-_         |   |
                  (      (        _-~    _--_    ~-_     _/   |
                   \      ~-____-~    _-~    ~-_    ~-_-~    /
                     ~-_           _-~          ~-_       _-~   
                        ~--______-~                ~-___-~


EOD;

    public function render(Board $board, Snake $snake): string
    {
        $output = '';

        for ($x = 0; $x < $board->width; $x++) {
            for ($y = 0; $y < $board->height; $y++) {
                /*if ($x === 0 || $x === $this->width -1) {
                    $cell = '=';
                } elseif ($y === 0 || $y === $this->height -1) {
                    $cell = '|';
                }*/
                if ($board->apple->x() == $x && $board->apple->y() == $y) {
                    $cell = 'o';
                }
                elseif ($board->rock->x() == $x && $board->rock->y() == $y) {
                    $cell = 'x';
                }
                else {
                    $cell = ' ';
                }
                foreach ($snake->trail as $trail) {
                    if ($trail[0] == $x && $trail[1] == $y) {
                        $cell = '.';
                    }
                }
                $output .= $cell;
            }
            $output .= PHP_EOL;
        }

        $output .= PHP_EOL;

        return self::HEADER . $output;
    }
}