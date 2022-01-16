<?php
declare(strict_types=1);
namespace App\Enum;

enum StatusProductOfferEnum: string
{
    case DRAFT = 'draft';
    case PUBLISHED = 'published';
    case PENDING = 'pending';
    case ACTIVE = 'active';
    case FINISHED = 'finished';
    case ARCHIVED = 'archived';
    case DELETED = 'deleted';
}