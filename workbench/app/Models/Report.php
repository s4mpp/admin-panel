<?php

namespace Workbench\App\Models;

use Closure;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Report extends Model
{
    use HasFactory;

    public static function reportRegistersByDate(Closure $filter)
    {
        return self::where($filter)
            ->select('created_at')
            ->selectRaw('count(id) as total')
            ->groupBy('created_at')
            ->orderBy('created_at')->paginate();
    }
}
