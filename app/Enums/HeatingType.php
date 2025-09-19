<?php

namespace App\Enums;

enum HeatingType: string
{
    case NONE     = 'none';
    case GAS      = 'gas';
    case ELECTRIC = 'electric';
    case CENTRAL  = 'central';
    case OTHER    = 'other';
}
