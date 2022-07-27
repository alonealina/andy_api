<?php
return [
    'accounts' => [
        'username' => 'ユーザー名',
        'password' => 'パスワード',
        'name' => '名前',
    ],
    'store_categories' => [
        'name' => 'お店の名前',
        'image' => '画像'
    ],
    'stores' => [
        'name' => 'お店の名前',
        'store_category_id' => 'ストアカテゴリ',
        'post_code_1' => '郵便番号1',
        'post_code_2' => '郵便番号2',
        'address' => '住所',
        'start_time' => '始まる時間',
        'end_time' => '始まる時間',
        'payment_method' => '支払方法',
        'counter_count' => 'カウンター',
        'table_count' => 'テーブル',
        'room_count' => '個室',
        'stand_count' => 'スタンド',
        'hotline' => 'お問い合わせ',
        'homepage_url' => 'ホームページURL',
        'image' => '画像'
    ],
    'foods' => [
        'food_category_id' => 'カテゴリー',
        'name' => '名前',
        'price' => '価格',
        'image' => '画像',
        'description' => '説明'
    ],
    'drinks' => [
        'drink_category_id' => 'カテゴリー',
        'name' => '名前',
        'price' => '価格',
        'image' => '画像',
        'description' => '説明'
    ],
    'news' => [
        'title' => '題名',
        'content' => 'コンテンツ',
    ],
    'information' => [
        'title' => '題名',
        'content' => 'コンテンツ',
        'time_event' => 'タイムイベント',
        'image' => '画像'
    ],
    'system_information' => [
        'pm_last' => 'PM8:00 ~ LAST',
        'companion_fee' => '同伴料',
        'nomination_fee' => '指名料',
        'extension_fee' => '延長料',
        'vip_fee' => 'VIP',
        'shochu_fee' => '焼酎',
        'brandy_fee' => 'ブランデー',
        'whisky_fee' => 'ウイスキー'
    ],
    'casts' => [
        'username' => 'ユーザー名',
        'password' => 'パスワード',
        'password_confirmation' => 'パスワードの確認',
        'name' => '名前',
        'height' => '身長',
        'blood_type' => '血液型',
        'hobbit' => '延長料',
        'type_person' => 'タイプの人',
        'dream' => '夢',
        'fetish' => 'フェチ',
        'slogan' => 'スローガン',
        'instagram_url' => 'InstagramのURL',
        'special_skill' => '特技'
    ],
    'order_details' => [
        'user_id' => '個室',
        'orderable_id' => 'orderable_id',
        'orderable_type' => 'orderable_type',
        'quantity' => '数量',
        'status' => '状態'
    ],
    'orders' => [
        'status' => '状態'
    ],
    'branches' => [
        'name' => '名前',
        'tablet_count' => '錠剤の数',
        'admin_id' => '管理者ID',
        'admin_password' => '管理者パスワード',
    ],
    'drink-categories' => [
        'name' => '名前',
        'parent_id' => 'カテゴリーID'
    ],
    'food-categories' => [
        'name' => '名前'
    ],
    'backgrounds' => [
        'position' => '位置',
        'file' => '画像'
    ],
    'turnover_details' => [
        'type' => 'タイプ',
    ],
    'maintain' => [
        'branch_id' => 'ブランチ',
        'branch_ids' => 'ブランチ',
        'role' => '役割',
        'maintain_status' => '状態',
        'start_time' => '始める時間',
        'end_time' => '終了時間',
    ]
];
