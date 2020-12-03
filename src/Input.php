<?php
namespace Gussi\AOC2020;

trait Input {
    private array $input;

    private function input(): array {
        if (isset($this->input)) {
            return $this->input;
        }

        $this->input = [];

        while ($line = trim(fgets(STDIN))) {
            $this->input[] = $line;
        }

        return $this->input;
    }
}
