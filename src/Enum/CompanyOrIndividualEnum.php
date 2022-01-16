<?php
declare(strict_types=1);
namespace App\Enum;

enum CompanyOrIndividualEnum: string
{
    case COMPANY = 'company';
    case INDIVIDUAL = 'individual';
}