<?php

namespace black_jack\Test;

use black_jack\DrawCard;
use black_jack\Card;
use PHPUnit\Framework\TestCase;

require_once(__DIR__ . '/../Participant.php');
require_once(__DIR__ . '/../DrawCard.php');
require_once(__DIR__ . '/../Card.php');

class DrawCardTest extends TestCase
{
    public function testDealCards(): void
    {
        $drawCard = new DrawCard();
        $card = new Card();
        $cards = $drawCard->dealCards($card, 4);
        $this->assertSame(4, count($cards));
    }

    public function testDealSingleCard(): void
    {
        $drawCard = new DrawCard();
        $card = new Card();
        $singleCard = $drawCard->dealSingleCard($card);
        $this->assertSame(2, count($singleCard));
        $this->assertSame(51, count($card->deckCards));
    }
}
