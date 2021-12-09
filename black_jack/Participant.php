<?php

namespace black_jack;

require_once(__DIR__ . '/Player.php');

interface Participant
{
    public const DEALER = 'ディーラー';
    public const PLAYER = 'あなた';
    public const CPU1 = '太郎';
    public const CPU2 = '花子';

    public const PARTICIPANT_CODE = [
        1 => self::DEALER,
        2 => self::PLAYER,
        3 => self::CPU1,
        4 => self::CPU2,
    ];

    public function tern(): void;
}
