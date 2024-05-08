<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'latitude',
        'longitude',
    ];

    public static function inRadius(float $lat, float $long, ?int $radius = null): Collection
    {
       $query = self::selectRaw("
            `latitude`, 
            `longitude`,
            (3959 * 
            acos(cos(radians({$lat})) * 
            cos(radians(`latitude`)) * 
            cos(radians(`longitude`) - radians({$long})) + 
            sin(radians({$lat})) * sin(radians(`latitude`)))) AS `distance`
        ");
        
        if ($radius) {
            $query->having('distance', '<=', $radius)->get();
        }

        return $query->get();
    }
}
