<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class AccountRole extends Enum
{
    const SUPER_ADMIN = 1;
    const ADMIN = 2;
    const CUSTOMER = 3;
    const CAST = 4;
}
