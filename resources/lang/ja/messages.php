<?php

use App\Enums\NotificationType;

return [
    'common' => [
        'data_not_found' => 'データが見つかりません',
        'forbidden'=> '禁断'
    ],
    'users' => [
        'login_fail' => 'ログイン失敗',
        'unauthenticated' => '認証されていない',
    ],
    'notification' => [
        NotificationType::SOS => '緊急呼び出し'
    ]
];
