<?php

namespace black_jack;

require_once(__DIR__ . '/BlackJack.php');
require_once(__DIR__ . '/Participant.php');

class Rule
{
    public function getNumberOfParticipant(): int
    {
        do {
            echo '何人で遊びますか? (1〜3)' . PHP_EOL;
            (int) $number = trim(fgets(STDIN));
            if (1 <= $number && $number <= 3) {
                $input = false;
            } else {
                echo '入力が正しくありません' . PHP_EOL;
                $input = true;
            }
        } while ($input);
        (int) $number++;
        return (int) $number;
    }
}
