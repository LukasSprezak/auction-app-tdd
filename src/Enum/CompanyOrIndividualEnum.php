<?php
declare(strict_types=1);
namespace App\Enum;

enum CompanyOrIndividualEnum: string
{
    case COMPANY = 'company';
    case INDIVIDUAL = 'individual';

//    case COMPANY;
//    case INDIVIDUAL;
//
//    public function companyOrIndividual(): string
//    {
//        return match($this)
//        {
//            self::COMPANY => 'company',
//            self::INDIVIDUAL => 'individual',
//        };
//    }
}