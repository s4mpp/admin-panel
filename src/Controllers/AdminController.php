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

    public $route_redirect_after_login = 'dashboard_admin';

    public function __construct()
    {
        $this->guard = config('admin.guard');
    }
}