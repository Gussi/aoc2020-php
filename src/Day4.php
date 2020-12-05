<?php
namespace Gussi\AOC2020;

class Day4
{
	public function part1() {
        $valid = 0;

        foreach ($this->input() as $passport) {
            if ($passport->valid_part_one()) {
                $valid++;
            }
        }

        return $valid;
	}

	public function part2() {
        $valid = 0;

        foreach ($this->input() as $passport) {
            if ($passport->valid_part_two()) {
                $valid++;
            }
        }

        return $valid;
	}

	private function input(): \Generator {
		$output = [];

		$passport_attributes = [];
		$input = "";
		while ($line = fgets(STDIN)) {
			$input .= $line;

			if (str_ends_with($input, "\n\n")) {
                $input = trim(str_replace("\n", " ", trim($input)));
				yield Passport::new($input);
				$input = "";
			}
		}

		return $output;
	}
}

class Passport
{
	private $byr; // Birth Year
	private $iyr; // Issue Year
	private $eyr; // Expiration Year
	private $hgt; // Height
	private $hcl; // Hair Color
	private $ecl; // Eye Color
	private $pid; // Passport ID
	private $cid; // Country ID

	static public function new(string $line): Passport {
		$passport = new Passport;

		foreach (explode(' ', $line) as $key_val) {
			[$key, $val] = explode(':', $key_val);

			if (!property_exists($passport, $key)) {
				throw new \Exception("Invalid attribute $key for Passport");
			}

			$passport->$key = $val;
		}

        return $passport;
	}

    public function valid_part_one(): bool {
        foreach (['byr', 'iyr', 'eyr', 'hgt', 'hcl', 'ecl', 'pid'] as $key) {
            if (empty($this->{$key})) {
                return FALSE;
            }
        }

        return TRUE;
    }

    public function valid_part_two(): bool {
        if (!$this->valid_part_one()) {
            return FALSE;
        }

        foreach ([
            // Validate birth year
            'byr' => function (Passport $passport): bool {
                return (1920 <= $passport->byr) && ($passport->byr <= 2002);
            },

            // Validate issue year
            'iyr' => function (Passport $passport): bool {
                return (2010 <= $passport->iyr) && ($passport->iyr <= 2020);
            },

            // Validate expiration year
            'eyr' => function (Passport $passport): bool {
                return (2020 <= $passport->eyr) && ($passport->eyr <= 2030);
            },

            // Validate height
            'hgt' => function (Passport $passport): bool {
                if (preg_match('/^(\d+)(cm|in)$/', $passport->hgt, $matches)) {
                    [$val, $height, $metric] = $matches;
                    switch ($metric) {
                        case 'cm':
                            return (150 <= $height ) && ($height <= 193);
                            break;

                        case 'in':
                            return (59 <= $height) && ($height <= 76);
                            break;
                    }
                }

                return FALSE;
            },

            // Validate hair color
            'hcl' => function (Passport $passport): bool {
                return preg_match(
                    pattern : "/^#[0-9a-f]{6}$/",
                    subject :$passport->hcl
                ) !== 0;
            },

            // Validate eye color
            'ecl' => function (Passport $passport): bool {
                return in_array(
                    needle      : $passport->ecl,
                    haystack    : ['amb', 'blu', 'brn', 'gry', 'grn', 'hzl', 'oth'],
                );
            },

            // Validate ID
            'pid' => function (Passport $passport): bool {
                return (bool)preg_match("/^\d{9}$/", $passport->pid);
            },

        ] as $key => $rule) {
            if (!$rule($this)) {
                return FALSE;
            }
        }

        return TRUE;
    }
}
