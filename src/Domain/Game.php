<?php
namespace App\Domain;

// TODO init speed + increment each level
// TODO: each level new board and get consequent numbers instead of apples
// TODO: bug: change direction is a dead -> <- = dead

class Game
{
    public Board $board;
    public Snake $snake;
    public int $speed = 100000;

    public function __construct($width, $height)
    {
        $this->board = new Board($width, $height);
        $this->snake = new Snake($width, $height);

        // TODO exclude border if is displayed
        $this->board->apple = $this->generateItem($this->snake->trail);
        $this->board->rock = $this->generateItem(array_merge($this->snake->trail, [$this->board->apple->x(), $this->board->apple->y()]));
    }

    public function move() {
        $snake = $this->snake;

        // Move the snake.
        $positionX = $snake->head->x() + $snake->movementX;
        $positionY = $snake->head->y() + $snake->movementY;

        // TODO create Head class like Point and ad this logic in there
        // Wrap the snake around the boundaries of the board.
        if ($positionX < 0) {
            $positionX = $this->board->width - 1;
        }
        if ($positionX > $this->board->width - 1) {
            $positionX = 0;
        }
        if ($positionY < 0) {
            $positionY = $this->board->height - 1;
        }
        if ($positionY > $this->board->height - 1) {
            $positionY = 0;
        }

        $this->snake->head = new Point($positionX, $positionY);

        // Add to the snakes trail at the front.
        array_unshift($snake->trail, [$snake->head->x(), $snake->head->y()]);

        // Remove a block from the end of the snake (but keep correct length).
        if (count($snake->trail) > $snake->tail) {
            array_pop($snake->trail);
        }

        if ($this->board->apple->x() == $snake->head->x() && $this->board->apple->y() == $snake->head->y()) {
            // The snake has eaten an apple.
            $snake->tail++;

            if ($this->speed > 2000) {
                // Increase the speed of the game up to a certain limit.
                $this->speed = $this->speed - ($snake->tail * ($this->board->width / $this->board->height + 10));
            }

            $this->board->apple = $this->generateItem($this->snake->trail);
        }

        $this->snake = $snake;
    }

    public function generateItem(array $unavailablePoints = []): Point
    {
        $itemX = rand(0, $this->board->width - 1);
        $itemY = rand(0, $this->board->height - 1);

        while (array_search([$itemX, $itemY], $unavailablePoints) !== false) {
            $itemX = rand(0, $this->board->width - 1);
            $itemY = rand(0, $this->board->height - 1);
        }

        return new Point($itemX, $itemY);
    }

    public function isGameOver(): bool
    {
        if ($this->snake->head->x() === $this->board->rock->x() && $this->snake->head->y() === $this->board->rock->y()) {
            return true;
        }

        if ($this->snake->tail > 5) {
            // If the trail is greater than 5 then check for end condition.
            for ($i = 1; $i < count($this->snake->trail); $i++) {
                if ($this->snake->trail[$i][0] == $this->snake->head->x() && $this->snake->trail[$i][1] == $this->snake->head->y()) {
                    return true;
                }
            }
        }

        return false;
    }
}