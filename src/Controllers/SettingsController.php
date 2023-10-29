<?php

namespace S4mpp\AdminPanel\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use S4mpp\AdminPanel\AdminPanel;
use App\Http\Controllers\Controller;
use S4mpp\AdminPanel\Traits\HasForm;
use S4mpp\AdminPanel\Traits\HasValidation;

class SettingsController extends Controller
{
	// use HasForm, HasValidation;

    public function settings()
    {
        $form = AdminPanel::getSettings();

        $register = Setting::find(1);

        return view('admin::settings', compact('form', 'register'));
    }

    public function storeSettings(Request $request)
    {
		$settings = AdminPanel::getSettings();

		$fields = self::_getFields($settings);

		$fields_validated = self::_validate($request, $fields, 'settings', 1);

        $register = Setting::find(1);

        if(!$register)
        {
            $register = new Setting();
        }
        
        foreach($fields as $field)
        {
            $register->{$field->name} = $fields_validated[$field->name] ?? null;
        }

        $register->save();


        return redirect()->back()->with('message', 'Alterações salvas com sucesso.');
    }
}