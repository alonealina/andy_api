<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class MessageStatus extends Enum
{
    const SUCCESS = 'SUCCESS';
    const ERROR = 'ERROR';
    const ON_SALE = 1;
    const SOLD_OUT = 0;
}
