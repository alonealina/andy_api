<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class OrderStatus extends Enum
{
    const UNPAID = 0;
    const CALL_PAID = 1;
    const PAID = 2;
    const CLOSE = 3;
    const HIDDEN = 4;
}
