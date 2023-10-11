<?php

namespace S4mpp\AdminPanel\Controllers;

use App\Http\Controllers\Controller;
use S4mpp\Laraguard\Traits\Authentication;
use S4mpp\Laraguard\Traits\RecoveryPassword;

class AdminController extends Controller
{
    use Authentication, RecoveryPassword;

	public $guard;

    public $view_login = 'admin::login';

    public $view_forgot_password = 'admin::forgot_password';
    
    public $view_change_password = 'admin::change_password';

    public $field_username = 'email';

    public $route_identifier = 'admin-panel';

    public $login_2fa = true;

    public function __construct()
    {
        $this->route_redirect_after_login = config('admin.route_redirect_after_login');

        $this->guard = config('admin.guard', 'web');
    }

    public function generatePassword()
    {
        return redirect()->back()->with('message', 'Senha gerada com sucesso');
    }

    public function settings()
    {
        return view('admin::settings');
    }

    public function storeSettings()
    {
        return redirect()->back()->with('message', 'Alterações salvas com sucesso.');
    }
}