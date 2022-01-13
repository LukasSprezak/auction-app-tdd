<?php
declare(strict_types=1);
namespace App\Enum;

enum StateProductEnum: int
{
    case NEW = 0;
    case USED = 1;
}