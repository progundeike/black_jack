<?php

namespace black_jack;

require_once(__DIR__ . '/Card.php');

class Dealer implements Participant
{
    private string $name;
    public function __construct(public DrawCard $drawCard, public Card $card, string $name)
    {
        $this->name = $name;
    }

    public function tern(): void
    {
        echo 'ディーラーの引いた2枚目のカードは' .
        Card::SUIT[$this->card->hands[$this->name][1]['suit']] . 'の' .
        $this->card->hands[$this->name][1]['number'] . 'でした。' . PHP_EOL;
        echo 'ディーラーの現在の得点は' . $this->card->getScore($this->card->hands[$this->name]) . 'です。' . PHP_EOL;

        while ($this->card->getScore($this->card->hands[$this->name]) < 17) {
            $dealtCard = $this->drawCard->dealSingleCard($this->card);
            echo 'ディーラーの引いたカードは' . Card::SUIT[$dealtCard['suit']] . 'の' . $dealtCard['number'] . 'です。' . PHP_EOL;
            $this->card->hands[$this->name][] = $dealtCard;
            echo 'ディーラーの現在の得点は' . $this->card->getScore($this->card->hands[$this->name]) . 'です。' . PHP_EOL;
        }
    }
}
