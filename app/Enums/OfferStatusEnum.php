<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class OfferStatusEnum extends Enum
{
    const accepted = 'accepted';
    const rejected = 'rejected';
    const pending = 'pending';
}
