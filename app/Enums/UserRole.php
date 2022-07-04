<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static ADMIN()
 * @method static static EMPLOYEE()
 * @method static static CUSTOMER()
 */
final class UserRole extends Enum
{
    const ADMIN = 1;
    const EMPLOYEE = 2;
    const CUSTOMER = 3;
}
