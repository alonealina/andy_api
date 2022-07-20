<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class OrderStatus extends Enum
{
    const UNPAID = 0;
    const PAID = 1;
}
