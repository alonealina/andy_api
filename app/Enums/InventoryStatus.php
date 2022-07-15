<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

class InventoryStatus extends Enum
{
    const ON_SALE = 1;
    const SOLD_OUT = 0;
}
