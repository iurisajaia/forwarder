<?php
namespace App\Enums;

use BenSampo\Enum\Enum;

final class MessageStatusEnum extends Enum
{
    const in_progress = 'in_progress';
    const canceled = 'canceled';
    const finished = 'finished';
}
