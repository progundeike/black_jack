<?php

namespace black_jack;

require_once(__DIR__ . '/Card.php');
require_once(__DIR__ . '/Participant.php');
require_once(__DIR__ . '/BlackJack.php');

class Player implements Participant
{
    private string $name;
    public function __construct(public DrawCard $drawCard, public Card $card, string $name)
    {
        $this->name = $name;
    }

    public function tern(): void
    {
        $playerScore = $this->card->getScore($this->card->hands[$this->name]);
        echo 'あなたの現在の得点は' . $playerScore . 'です。';
        if ($playerScore > 21) {
            echo PHP_EOL . 'あなたの負けです。' . PHP_EOL;
            echo 'ブラックジャックを終了します。' . PHP_EOL;
            exit;
        } elseif ($playerScore < 21) {
            if ($this->hitOrStay()) {
                $dealtCard = $this->drawCard->dealSingleCard($this->card);
                $this->card->hands[$this->name][] = $dealtCard;
                echo 'あなたの引いたカードは' . Card::SUIT[$dealtCard['suit']] . 'の' . $dealtCard['number'] . 'です。' . PHP_EOL;
                $this->tern();
            }
        }
    }

    public function hitOrStay(): bool
    {
        do {
            echo 'カードを引きますか？（Y/N)' . PHP_EOL;
            $choice = trim(fgets(STDIN));
            if (($choice === 'Y') || ($choice === 'y')) {
                $choice = true;
            } elseif (($choice === 'N') || ($choice === 'n')) {
                $choice = false;
            } else {
                echo '入力が正しくありません' . PHP_EOL;
            }
        } while (!is_bool($choice));
        return $choice;
    }
}
