<?php
declare(strict_types=1);
namespace App\Enum;

enum StatusProductOfferEnum: int
{
    case DRAFT = 0;
    case PUBLISHED = 1;
    case PENDING = 2;
    case ACTIVE = 3;
    case FINISHED = 4;
}