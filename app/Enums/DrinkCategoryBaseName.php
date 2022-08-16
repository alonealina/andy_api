<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class DrinkCategoryBaseName extends Enum
{
    const CHAMPAGNE = 'シャンパン';
    const WINE = 'ワイン';
    const BRANDY_WHISKEY = 'ブランデーウイスキー';
    const SHOCHU = '焼酎';
    const SAKE = '日本酒';
    const COCKTAIL_SOUR = 'カクテルサワー';
    const SOFT_DRINK = '焼酎';
    const SPLIT = '割りもの';
    const OTHER = 'その他';
}
