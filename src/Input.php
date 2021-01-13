<?php
namespace Gussi\AOC2020;

trait Input {
    private array $input;

    private function input(): array {
        if (isset($this->input)) {
            return $this->input;
        }

        $this->input = [];

        while (!feof(STDIN)) {
            $this->input[] = trim(fgets(STDIN));
        }

        return $this->input;
    }
}
