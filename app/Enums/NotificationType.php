<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class NotificationType extends Enum
{
    const SOS = 'SOS';
    const NEW_ORDER = 'NEW_ORDER';
    const PAID_ORDER = 'PAID_ORDER';
}
