<?php

namespace black_jack;

require_once(__DIR__ . '/Card.php');
require_once(__DIR__ . '/Player.php');

class Cpu implements Participant
{
    private const ADDITIONAL_CARD_CHOICE = 15;
    private string $name;
    public function __construct(public DrawCard $drawCard, public Card $card, string $name)
    {
        $this->name = $name;
    }

    public function tern(): void
    {
        $playerScore = $this->card->getScore($this->card->hands[$this->name]);
        echo $this->name . 'の現在の得点は' . $playerScore . 'です。' . PHP_EOL;
        if ($playerScore < 21) {
            if ($this->hitOrStay($playerScore)) {
                $dealtCard = $this->drawCard->dealSingleCard($this->card);
                $this->card->hands[$this->name][] = $dealtCard;
                echo $this->name . 'の引いたカードは' .
                Card::SUIT[$dealtCard['suit']] . 'の' .
                $dealtCard['number'] . 'です。' . PHP_EOL;
                $this->tern();
            }
        }
    }

    public function hitOrStay(int $playerScore): bool
    {
        if ($playerScore < self::ADDITIONAL_CARD_CHOICE) {
            $choice = true;
        } else {
            $choice = false;
        }
        return $choice;
    }
}
