<?php

namespace black_jack;

require_once(__DIR__ . '/BlackJack.php');

//BlackJack.phpで静的解析を行いやすいようにゲームの実行ファイルを分ける
$newGame = new BlackJack();
$newGame->start();
