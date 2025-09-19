<?php

namespace App\Enums;

enum ParkingType: string
{
    case NONE     = 'none';
    case STREET   = 'street';
    case GARAGE   = 'garage';
    case CARPORT  = 'carport';
    case RESERVED = 'reserved';
}
