<?php

namespace S4mpp\AdminPanel\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use S4mpp\AdminPanel\Requests\UserRequest;

class UserController extends Controller
{
    public function index()
    {
        $users = User::paginate();

        return view('admin::users.index', compact('users'));
    }

    public function create()
    {
        return view('admin::users.create');
    }

    public function edit(int $id)
    {
        $user = User::findOrFail($id);

        return view('admin::users.edit', compact('user'));
    }

    public function update(UserRequest $request, int $id)
    {
        $user = User::findOrFail($id);

        $this->_save($user, $request);

        $request->session()->flash('message', 'Usuário salvo com sucesso!');

        return redirect()->route('users_index_admin');
    }

    public function store(UserRequest $request)
    {
        $user = new User;

        $user->password = Hash::make(Str::password());
        
        $this->_save($user, $request);

        $request->session()->flash('message', 'Usuário criado com sucesso!');

        return redirect()->route('users_index_admin');
    }

    private function _save(User $user, Request $request)
    {
        $user->name = $request->name;
        $user->email = $request->email;
        $user->is_active = $request->is_active;

        $user->save();
    }
}
