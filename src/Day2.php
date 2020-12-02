<?php
namespace Gussi\AOC2020;

class Day2
{
    public function part1() {
        $input = $this->input();
        $valid = 0;

        foreach ($input as $password) {
            if (self::valid1(...$password)) {
                $valid++;
            }
        }

        return $valid;
    }

    public function part2() {
        $input = $this->input();
        $valid = 0;

        foreach ($input as $password) {
            if (self::valid2(...$password)) {
                $valid++;
            }
        }

        return $valid;
    }

    public function input(): array {
        $passwords = [];

        while ($line = trim(fgets(STDIN))) {
            $passwords[] = sscanf(
                string      : $line,
                format      : "%d-%d %c: %s"
            );
        }

        return $passwords;
    }

    static private function valid1(int $min, int $max, string $char, string $password): bool {
        $count = substr_count(
            haystack    : $password,
            needle      : $char
        );

        return ($min <= $count) && ($count <= $max);
    }

    static private function valid2(int $i, int $j, string $char, string $password): bool {
        return ($password[$i-1] == $char) xor ($password[$j-1] == $char);
    }
}
