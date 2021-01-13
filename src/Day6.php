<?php
namespace Gussi\AOC2020;

class Day6
{
    use Input;

    public function part1(): int {
        $output = 0;

        foreach ($this->get_groups() as $group) {
            $group_answers = [];

            foreach ($group as $person) {
                foreach (str_split($person) as $answer) {
                    $group_answers[$answer] = TRUE;
                }
            }

            $output += count($group_answers);
        }

        return $output;
    }

    public function part2() {
        $output = 0;

        foreach ($this->get_groups() as $group) {
            $group_answers = [];

            foreach ($group as $person) {
                foreach (str_split($person) as $answer) {
                    if (!isset($group_answers[$answer])) {
                        $group_answers[$answer] = 0;
                    }
                    $group_answers[$answer] += 1;
                }
            }

            foreach ($group_answers as $answer => $count) {
                if ($count == count($group)) {
                    $output += 1;
                }
            }
        }

        return $output;
    }

    private function get_groups(): array {
        $input = implode("\n", $this->input());
        $output = [];

        foreach (explode("\n\n", $input) as $group) {
            $output[] = explode("\n", $group);
        }

        return $output;
    }
}