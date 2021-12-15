<?php

namespace black_jack;

require_once(__DIR__ . '/DrawCard.php');
require_once(__DIR__ . '/Card.php');
require_once(__DIR__ . '/Player.php');
require_once(__DIR__ . '/Dealer.php');
require_once(__DIR__ . '/Participant.php');
require_once(__DIR__ . '/Rule.php');
require_once(__DIR__ . '/Cpu.php');

class BlackJack
{
    public Card $card;
    public DrawCard $drawCard;
    public Rule $rule;
    public function __construct()
    {
        $this->card = new Card();
        $this->drawCard = new DrawCard();
        $this->rule = new Rule();
    }

    public function start(): void
    {
        $numberOfParticipant = $this->rule->getNumberOfParticipant();
        $this->card->hands = $this->drawCard->dealCards($this->card, $numberOfParticipant);
        $this->declareHand();

        $party = $this->createParticipant($numberOfParticipant);

        foreach ($party as $nameInstance) {
            $nameInstance -> tern();
            echo PHP_EOL;
        }

        $participantScore = $this->getParticipantScore($this->card->hands);
        foreach ($participantScore as $name => $score) {
            echo $name . 'の得点は' . $score . 'です。' . PHP_EOL;
        }

        $winnerList = $this->getWinner($participantScore);
        $this->declareWinner($winnerList);

        echo PHP_EOL . 'ブラックジャックを終了します。' . PHP_EOL;
    }

    /** @return array<object> */
    private function createParticipant(int $numberOfParticipant): array
    {
        $player = new Player($this->drawCard, $this->card, Participant::PLAYER);
        $dealer = new Dealer($this->drawCard, $this->card, Participant::DEALER);
        $party = [$player, $dealer];
        if ($numberOfParticipant >= 3) {
            $cpu1 = new Cpu($this->drawCard, $this->card, Participant::CPU1);
            $party[] = $cpu1;
        }
        if ($numberOfParticipant >= 4) {
            $cpu2 = new Cpu($this->drawCard, $this->card, Participant::CPU2);
            $party[] = $cpu2;
        }
        return $party;
    }

    /**
     * @param array<string, int> $participantScore
     * @return array<string>
     * */
    public function getWinner(array $participantScore): array
    {
        $difScoreArray = [];
        $bustList = [];
        foreach ($participantScore as $name => $score) {
            if ($score > Card::Black_JACK) {
                $bustList[$name] = 'bust';
            } else {
                $difScoreArray[$name] = Card::Black_JACK - $score;
            }
        }
        asort($difScoreArray, SORT_NUMERIC);
        $difScoreArray = array_merge($difScoreArray,$bustList);
        $winnerScore = current($difScoreArray);
        $winnerList = array_keys($difScoreArray, $winnerScore);
        if (count($winnerList) === count($participantScore)) {
            $winnerList = ['draw'];
        }
        return $winnerList;
    }

    public function declareHand(): void
    {
        $hands = $this->card->hands;
        $dealersHand = array_shift($hands);
        foreach ($hands as $participantCode => $cards) {
            echo $participantCode . 'の引いたカードは、' .
            Card::SUIT[$cards[0]['suit']] . 'の' . $cards[0]['number'] .
            'と、' .
            Card::SUIT[$cards[1]['suit']] . 'の' . $cards[1]['number'] .
            'です。' . PHP_EOL;
        }
        echo 'ディーラーの引いたカードは' . Card::SUIT[$dealersHand[0]['suit']] . 'の' . $dealersHand[0]['number'] . 'です。' . PHP_EOL
        . 'ディーラーの引いた2枚目のカードはわかりません。' . PHP_EOL;
    }

    /** @param array<string> $winnerList */
    public function declareWinner(array $winnerList): void
    {
        if ($winnerList === ['draw']) {
            echo '引き分けです。';
        } elseif (count($winnerList) == 1) {
            echo $winnerList[0] . 'の勝ちです!';
        } elseif (count($winnerList) == 2) {
            echo $winnerList[0] . 'と' . $winnerList[1] . 'の勝ちです!';
        } elseif (count($winnerList) == 3) {
            echo $winnerList[0] . 'と' . $winnerList[1] . $winnerList[2] . 'の勝ちです!';
        }
    }

    /**
     * @param array<string, array<int, array<string, string>>> $hands
     * @return array<string, int>
     * */
    public function getParticipantScore(array $hands): array
    {
        $participantScore = [];
        foreach ($hands as $name => $hand) {
            $score = $this->card->getSoftHandScore($hand);
            $participantScore[$name] = $score;
        }
        return $participantScore;
    }
}
