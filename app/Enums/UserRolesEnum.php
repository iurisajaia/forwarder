<?php

namespace App\Enums;

enum UserRolesEnum: int
{
    case STANDARD = 1;
    case LEGAL = 2;
    case FORWARDER = 3;
    case DRIVER = 4;
}
