<?php
namespace App\Domain;

class Snake
{
    public Point $head;
    public $trail = [];
    public int $tail = 5;

    // TODO: ojo al canviar a Point aqui es queda el last move pq vagi avançant
    public $movementX = 0;
    public $movementY = 0;

    public function __construct($width, $height)
    {
        $this->head = new Point(rand(0, $width - 1), rand(0, $height - 1));
    }

/*
 *         if ($key) {
            $key = $this->translateKeypress($key);
            switch ($key) {
                case 'UP':
                    return new Point(-1, 0);
                case 'DOWN':
                    return new Point(1, 0);
                case 'RIGHT':
                    return new Point(0, 1);
                case 'LEFT':
                    return new Point(0, -1);
            }
        }
 */

    public function direction($stdin)
    {
        // Listen to the button being pressed.
        $key = fgets($stdin);
        if ($key) {
            $key = $this->translateKeypress($key);
            switch ($key) {
                case "UP":
                    $this->movementX = -1;
                    $this->movementY = 0;
                    break;
                case "DOWN":
                    $this->movementX = 1;
                    $this->movementY = 0;
                    break;
                case "RIGHT":
                    $this->movementX = 0;
                    $this->movementY = 1;
                    break;
                case "LEFT":
                    $this->movementX = 0;
                    $this->movementY = -1;
                    break;
                case "SPACE": // TODO bugged
                    $this->movementX = 0;
                    $this->movementY = 0;
                    break;
            }
        }
    }

    function translateKeypress($string)
    {
        switch ($string) {
            case "\033[A":
                return "UP";
            case "\033[B":
                return "DOWN";
            case "\033[C":
                return "RIGHT";
            case "\033[D":
                return "LEFT";
            case "\n":
                return "ENTER";
            case " ":
                return "SPACE";
            case "\010":
            case "\177":
                return "BACKSPACE";
            case "\t":
                return "TAB";
            case "\e":
                return "ESC";
        }
        return $string;
    }
}