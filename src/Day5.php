<?php
namespace Gussi\AOC2020;

class Day5
{
    use Input;

    public function part1(): int {
        $max = 0;

        foreach ($this->input() as $seat) {
            [$row, $col] = $this->parse($seat);
            $id = $this->get_seat_id($row, $col);
            $max = max($max, $id);
        }

        return $max;
    }

    public function part2(): int {
        $taken = [];

        foreach ($this->input() as $seat) {
            [$row, $col]= $this->parse($seat);
            $id = $this->get_seat_id($row, $col);
            $taken[$id] = [$row, $col];
            $id = $this->get_seat_id($row, $col);
            $seen_ids[$id] = TRUE;
        }

        $cut = 15;

        foreach (range(0 + $cut, 127 - $cut) as $row) {
            foreach (range(0, 7) as $col) {
                $id = $this->get_seat_id($row, $col);
                if (!isset($seen_ids[$id])) {
                    return $id;
                }
            }
        }
    }

    static function parse(string $seat): array {
        $row = 128;
        for ($i = 0; $i < 7; $i++) {
            $row = match ($seat[$i]) {
                'F'     => $row - (2 ** (6 - $i)),
                'B'     => $row,
                default => throw new \Exception("Invalid op {$seat[$i]}"),
            };
        }

        $col = 8;
        for ($i = 7; $i <= 9; $i++) {
            $col = match ($seat[$i]) {
                'L'     => $col - (2 ** (2 - ($i - 7))),
                'R'     => $col,
                default => throw new \Exception("Invalid op {$seat[$i]}"),
            };
        }

        return [
            $row - 1,
            $col - 1,
        ];
    }

    static function get_seat_id(int $row, int $col): int {
        return ($row * 8) + $col;
    }
}
