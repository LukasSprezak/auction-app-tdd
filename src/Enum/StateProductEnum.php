<?php
declare(strict_types=1);
namespace App\Enum;

enum StateProductEnum: string
{
    case NEW = 'new';
    case USED = 'used';
}