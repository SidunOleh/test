<?php

namespace App\Models;

use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
    ];

    public static function random(int $page = 1): Paginator
    {
        if (! $seed = Cache::get('seed')) {
            Cache::put('seed', $seed = rand(), 15);
        }

        $items = self::orderBy(DB::raw("RAND($seed)"))->paginate(10, ['*'], null, $page);

        return $items;
    }
}
