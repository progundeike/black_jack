<?php

namespace black_jack\Test;

use black_jack\Card;
use PHPUnit\Framework\TestCase;

require_once(__DIR__ . '/../Card.php');

class CardTest extends TestCase
{
    public function testGetSoftHandScore(): void
    {
        $card = new Card();
        $this->assertSame(52, count($card->deckCards));

        $sampleCards = [
            ['suit' => 'SPADE', 'number' => 'J'],
            ['suit' => 'HEART', 'number' => 'A'],
        ];
        $this->assertSame(21, $card->getSoftHandScore($sampleCards));

        $sampleCards = [
            ['suit' => 'DIAMOND', 'number' => 'K'],
            ['suit' => 'CLUB', 'number' => '6'],
        ];
        $this->assertSame(16, $card->getSoftHandScore($sampleCards));

        $sampleCards = [
            ['suit' => 'DIAMOND', 'number' => 'K'],
            ['suit' => 'CLUB', 'number' => '6'],
            ['suit' => 'HEART', 'number' => 'A'],
        ];
        $this->assertSame(17, $card->getSoftHandScore($sampleCards));

        $sampleCards = [
            ['suit' => 'DIAMOND', 'number' => 'K'],
            ['suit' => 'CLUB', 'number' => '6'],
            ['suit' => 'HEART', 'number' => 'A'],
            ['suit' => 'SPADE', 'number' => 'A'],
        ];
        $this->assertSame(18, $card->getSoftHandScore($sampleCards));

        $sampleCards = [
            ['suit' => 'DIAMOND', 'number' => 'A'],
            ['suit' => 'CLUB', 'number' => 'A'],
            ['suit' => 'HEART', 'number' => 'A'],
            ['suit' => 'SPADE', 'number' => 'A'],
        ];
        $this->assertSame(14, $card->getSoftHandScore($sampleCards));
    }
}
