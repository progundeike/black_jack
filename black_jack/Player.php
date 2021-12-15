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
        $softHandScore = $this->card->getSoftHandScore($this->card->hands[$this->name]);
        $hardHandScore = $this->card->getHardHandScore($this->card->hands[$this->name]);
        echo $this->name . 'の現在の得点は';
        if ($softHandScore > card::Black_JACK) {
            //バストした場合、ゲームを終了
            echo $softHandScore . '点です。' . PHP_EOL;
            echo PHP_EOL . $this->name . 'の負けです。' . PHP_EOL;
            echo 'ブラックジャックを終了します。' . PHP_EOL;
            exit;
        } elseif ($softHandScore < card::Black_JACK) {
            //21未満では追加のカードを引くか尋ねて、最初に戻る

            //「A」を引いている場合、ハードハンドとソフトハンドの得点を宣言する
            if ($this->card->existA($this->card->hands[$this->name]) && ($softHandScore !== $hardHandScore)) {
                echo $softHandScore . '点または、' . $hardHandScore . '点です。' . PHP_EOL;
            } else {
                echo $softHandScore . '点です。' . PHP_EOL;
            }

            if ($this->hitOrStay()) {
                $dealtCard = $this->drawCard->dealSingleCard($this->card);
                $this->card->hands[$this->name][] = $dealtCard;
                echo $this->name . 'の引いたカードは' . Card::SUIT[$dealtCard['suit']] . 'の' . $dealtCard['number'] . 'です。' . PHP_EOL;
                $this->tern();
            }
        } elseif ($softHandScore === card::Black_JACK) {
            //ブラックジャックの場合、得点を宣言するだけ
            echo $softHandScore . '点です。' . PHP_EOL;
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
