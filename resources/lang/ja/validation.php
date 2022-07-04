<?php

return [
    'regex' => ':attributeの形式が正しくありません。',
    'email' => ':attributeメール形式である必要があります。',
    'url' => ':attributeの形式が正しくありません。',
    'unique' => ':attributeが既に存在しています。',
    'required'             => ':attributeを入力してください。',
    'numeric'              => ':attributeには数字を入力してください',
    'min'                  => [
        'array'   => ':attributeの項目は:min個以上にしてください',
        'file'    => ':attributeには:min KB以上のファイルを指定してください',
        'numeric' => ':attributeには:min以上の数字を指定してください',
        'string'  => ':attributeは:min文字以上にしてください',
    ],
    'max'                  => [
        'array'   => ':attributeの項目は:max個以下にしてください',
        'file'    => ':attributeには:max KB以下のファイルを指定してください',
        'numeric' => ':attributeには:max以下の数字を指定してください',
        'string'  => ':attributeは:max文字以下にしてください',
    ],
    'exists' => '選択された:attributeは有効ではありません',
    'in' => ':attribute入力内容が正しくありません。',
];
