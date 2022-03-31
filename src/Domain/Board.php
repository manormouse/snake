<?php
namespace App\Domain;

class Board
{
    public int $width = 0;
    public int $height = 0;
    public Point $apple;
    public Point $rock;

    public function __construct($width, $height)
    {
        $this->width = $width;
        $this->height = $height;
    }
}