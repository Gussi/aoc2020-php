<?php
namespace Gussi\AOC2020;

use Ds\Set;

class Day1
{
    public function part1() {
        $input = $this->input();

        foreach ($input as $x) {
            $y = 2020 - $x;
            if ($input->contains($y)) {
                return $x * $y;
            }
        }

        throw new \Exception("Answer not found");
    }

    public function input(): Set {
        $set = new Set();

        while ($line = trim(fgets(STDIN))) {
            $set->add((int)$line);
        }

        return $set;
    }

    public function part2() {
        $input = $this->input();

        foreach ($input as $i => $x) {
            foreach ($input->slice($i + 1) as $y) {
                $z = 2020 - ($x + $y);
                if ($input->contains($z)) {
                    return $x * $y * $z;
                }
            }
        }

        throw new \Exception("Answer not found");
    }
}
