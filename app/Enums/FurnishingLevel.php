<?php

namespace App\Enums;

enum FurnishingLevel: string
{
    case UNFURNISHED = 'unfurnished';
    case PARTLY      = 'partly';
    case FULLY       = 'fully';
}
