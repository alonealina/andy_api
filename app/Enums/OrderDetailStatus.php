<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class OrderDetailStatus extends Enum
{
    const PENDING = 0;
    const DONE = 1;
    const CLOSE = 2;
    const HIDDEN = 3;
}
