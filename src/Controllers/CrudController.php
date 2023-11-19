<?php

namespace S4mpp\AdminPanel\Controllers;

use S4mpp\AdminPanel\Utils;
use Illuminate\Http\Request;
use S4mpp\AdminPanel\Resource;
use S4mpp\AdminPanel\AdminPanel;
use App\Http\Controllers\Controller;

class CrudController extends Controller
{
    public function index()
	{
		$resource = $this->_getResource();

		return $resource->getView('index', [
			'resource' => $resource
		]);
	}

    public function create()
	{
		$resource = $this->_getResource();

		return $resource->getView('create', compact('resource'));
	}

    public function update(int $id)
	{
		$resource = $this->_getResource();

		$register = $resource->getModel()->findOrFail($id);

		return $resource->getView('update', compact('resource', 'register'));
	}

    public function read(int $id)
	{
		$resource = $this->_getResource();

		$register = $resource->getModel()->findOrFail($id);

		$custom_actions = null;

		foreach($resource->getCustomActions() as $custom_action)
		{
			if(!Utils::checkPermissions($custom_action->getPermissionsForAccess()))
			{
				continue;
			}

			$custom_action->setRegister($register);

			$custom_actions[$custom_action->getSlug()] = $custom_action;
		}

		return $resource->getView('read', compact('resource', 'register', 'custom_actions'));
	}

    public function delete(Request $request, int $id)
	{
		$resource = $this->_getResource();

		$register = $resource->getModel()->findOrFail($id);

		$register->delete();

		$request->session()->flash('message', 'Exclusão realizada com sucesso!');

		return redirect()->route($resource->getRouteName('index'));
	}

	private function _getResource(): Resource
	{
		$name_route = request()->route()->action['as'];

		$module_name = explode('.', $name_route)[1];

		return AdminPanel::getResource($module_name.'Resource');
	}
}