<?php

namespace S4mpp\AdminPanel\Input;

use Illuminate\Support\Facades\Hash;
use S4mpp\AdminPanel\Traits\HasValidationRules;

final class Password extends Input
{

    /**
     * @return array<string>
     */
    public function getAttributes(): array
    {
        return [
            'type' => 'password',
            'autocomplete' => 'new-password',
        ];
    }

    public function processInputData(string $data = null): ?string
    {
        if(!$data)
        {
            return null;
        }

        return Hash::make($data);
    }
}
