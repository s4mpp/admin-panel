<?php

namespace S4mpp\AdminPanel\Controllers;

use App\Models\Setting;
use App\Http\Controllers\Controller;

class SettingsController extends Controller
{
    public function settings()
    {
        $register = $this->_getRegister();

        return view('admin::settings', compact('register'));
    }
    
    private function _getRegister(): Setting
    {
        $register = Setting::find(1);

        if(!$register)
        {
            $register = new Setting();
            $register->id = 1;
        }

        return $register;
    }
}