<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class PaymentMethod extends Enum
{
    const CREDIT_CARD = 0;
    const ELECTRONIC_MONEY = 1;
    const BARCODE = 2;
    const CASH = 3;
}
