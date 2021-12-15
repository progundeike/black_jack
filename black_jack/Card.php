<?php

namespace black_jack;

class Card
{
    public const SUIT = [
        'SPADE' => 'スペード',
        'HEART' => 'ハート',
        'DIAMOND' => 'ダイア',
        'CLUB' => 'クラブ',
    ];

    public const CARDS_SCORE = [
        'A' => 1,
        '2' => 2,
        '3' => 3,
        '4' => 4,
        '5' => 5,
        '6' => 6,
        '7' => 7,
        '8' => 8,
        '9' => 9,
        '10' => 10,
        'J' => 10,
        'Q' => 10,
        'K' => 10,
    ];

    public const HARD_HAND = 1;
    public const SOFT_HAND = 11;
    public const Black_JACK = 21;

    /** @var array<int, array<string, string>> $deckCards */
    public array $deckCards;

    /** @var array<string, array<int,array<string, string>>> $hands */
    public array $hands;

    public function __construct()
    {
        $cards = [];
        foreach (array_keys($this::SUIT) as $suit) {
            foreach (array_keys($this::CARDS_SCORE) as $number) {
                $card = [
                    'suit' => $suit,
                    'number' => $number
                ];
                $cards[] = $card;
            }
        }
        shuffle($cards);
        $this->deckCards = $cards;
    }

    /** @param array<int,array<string,string>> $cards
    *  @return int $sumScore
    */
    public function getSoftHandScore(array $cards): int
    {
        $sumScore = 0;
        foreach ($cards as $card) {
            $score = self::CARDS_SCORE[$card['number']];
            $sumScore += $score;
        }
        if ($this->existA($cards) && ($sumScore <= 11)) {
            $sumScore += (self::SOFT_HAND - self::HARD_HAND);
        }
        return $sumScore;
    }

    public function getHardHandScore(array $cards): int
    {
        $sumScore = 0;
        foreach ($cards as $card) {
            $score = self::CARDS_SCORE[$card['number']];
            $sumScore += $score;
        }
        return $sumScore;
    }

    /** @param array<int,array<string,string>>  $cards
     *  @return bool
    */
    public function existA(array $cards): bool
    {
        return in_array('A', array_column($cards, 'number'));
    }
}
