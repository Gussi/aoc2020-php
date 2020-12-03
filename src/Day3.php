<?php
namespace Gussi\AOC2020;

class Day3
{
    use Input;

    public function part1(int $t_x = 3, int $t_y = 1) {
        $world = new World($this->input());
        $trees = 0;

        while (TRUE) {
            if ($world->done()) {
                break;
            }

            if ($world->tree()) {
                $trees++;
            }

            $world->traverse($t_x, $t_y);
        }

        return $trees;
    }

    public function part2() {
        return array_product([
            $this->part1(1, 1),
            $this->part1(3, 1),
            $this->part1(5, 1),
            $this->part1(7, 1),
            $this->part1(1, 2),
        ]);
    }
}

class World
{
    private $map = [];
    private Player $player;

    public function __construct(array $input) {
        $this->player = new Player;

        foreach ($input as $line) {
            $this->add($line);
        }
    }

    private function add(string $line) {
        $this->map[] = str_split($line);
    }

    private function height(): int {
        return count($this->map);
    }

    private function width(): int {
        return count($this->map[0]);
    }

    public function tree(): bool {
        return $this->map[$this->player->y][$this->player->x] === '#';
    }

    public function done(): bool {
        return $this->player->y >= $this->height();
    }

    public function traverse(int $x, int $y) {
        $this->player->x += $x;
        $this->player->x = $this->player->x % $this->width();
        $this->player->y += $y;
    }

    public function __clone() {
        $this->player = clone $this->player;
    }
}


class Player
{
    public function __construct(
        public int $x = 0,
        public int $y = 0,
    ) { }
}
