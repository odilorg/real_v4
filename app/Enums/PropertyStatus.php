<?php

namespace App\Enums;

enum PropertyStatus: string
{
    case DRAFT        = 'draft';
    case NEEDS_REVIEW = 'needs_review';
    case PUBLISHED    = 'published';
    case ARCHIVED     = 'archived';
}
