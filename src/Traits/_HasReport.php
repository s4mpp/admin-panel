<?php

namespace S4mpp\AdminPanel\Traits;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Collection as SupportCollection;

trait HasReport
{
	// public static function reportResponse(Collection | array $registers, ...$fields): SupportCollection
	// {
    //     foreach($registers as $register)
    //     {
    //         $item = [];

    //         foreach($fields as $field)
    //         {
    //             $item[$field] = $register[$field] ?? null;
    //         }
            
    //         $items[] = $item;
    //     }

    //     return collect($items ?? []);
	// }
}