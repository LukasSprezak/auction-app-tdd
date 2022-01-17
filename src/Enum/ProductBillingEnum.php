<?php
declare(strict_types=1);
namespace App\Enum;

enum ProductBillingEnum: string
{
    case PRICE = 'price';
    case GIVE_FOR_FREE = 'giveForFree';
    case REPLACEMENT = 'replacement';
}