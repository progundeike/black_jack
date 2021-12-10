<?php

namespace black_jack\Test;

use black_jack\BlackJack;
use black_jack\Participant;
use PHPUnit\Framework\TestCase;

require_once(__DIR__ . '/../BlackJack.php');
require_once(__DIR__ . '/../Participant.php');

class BlackJackTest extends TestCase
{
    public function testGetWinner(): void
    {
        $blackJack = new BlackJack();
        $participantScore = [
            Participant::DEALER => 22,
            Participant::PLAYER => 20,
            Participant::CPU1 => 15,
            Participant::CPU2 => 10,
        ];
        $this->assertSame([Participant::PLAYER], $blackJack->getWinner($participantScore));

        $participantScore = [
            Participant::DEALER => 22,
            Participant::PLAYER => 23,
            Participant::CPU1 => 25,
            Participant::CPU2 => 29,
        ];
        $this->assertSame(['draw'], $blackJack->getWinner($participantScore));

        $participantScore = [
            Participant::DEALER => 22,
            Participant::PLAYER => 23,
            Participant::CPU1 => 20,
            Participant::CPU2 => 20,
        ];
        $this->assertSame([Participant::CPU1, Participant::CPU2], $blackJack->getWinner($participantScore));

        $participantScore = [
            Participant::DEALER => 23,
            Participant::PLAYER => 19,
            Participant::CPU1 => 3,
            Participant::CPU2 => 1,
        ];
        $this->assertSame([Participant::PLAYER], $blackJack->getWinner($participantScore));
    }
}
