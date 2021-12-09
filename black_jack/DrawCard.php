<?php

namespace black_jack;

require_once(__DIR__ . '/Card.php');

class DrawCard
{
    /**
     * @return array{'name': array}
     */
    public function dealCards(Card $card, int $numberOfParticipant): array
    {
        $hands = [];
        for ($n = 1; $n <= 2; $n++) {
            for ($i = 1; $i <= $numberOfParticipant; $i++) {
                $name = Participant::PARTICIPANT_CODE[$i];
                $hands[$name][] = array_shift($card->deckCards);
            }
        }
        return $hands;
    }

    /**
     * @return array<string,string>
     */
    public function dealSingleCard(Card $card): array
    {
        $card = array_shift($card->deckCards);
        return $card;
    }
}
