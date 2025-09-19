<?php

namespace App\Enums;

enum PropertyType: string
{
    case APARTMENT   = 'apartment';
    case HOUSE       = 'house';
    case LAND        = 'land';
    case COMMERCIAL  = 'commercial';
    case ROOM_SHARE  = 'room_share';
    case NEW_BUILD   = 'new_build';
}
