<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class PositionBackground extends Enum
{
    const TOP1 = 0;
    const TOP2 = 1;
    const TOP3 = 2;
    const CAST = 3;
    const EVENT = 4;
    const DRINK = 5;
    const FOOD = 6;
    const AFTER = 7;
    const SYSTEM = 8;
}
