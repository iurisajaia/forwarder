<?php
namespace App\Enums;


use BenSampo\Enum\Enum;

final class DealStatusEnum extends Enum
{
    const in_progress = 'in_progress';
    const active = 'active';
    const completed = 'completed';
    const finished = 'finished';
    const canceled = 'canceled';
}
