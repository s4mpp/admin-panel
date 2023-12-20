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

	public function report()
	{
		$report = null;

		$resource = $this->_getResource();

		$path = explode('/', request()->route()->uri);

		$slug_report = end($path);

		$report = $resource->getReport($slug_report);

		if(!$report)
		{
			abort(404);
		}

		return $resource->getView('report', [
			'resource' => $resource,
			'report' => $report
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
			if(!Utils::checkRoles($custom_action->getRolesForAccess()))
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
		$path = request()->route()->action['as'];

		$path_steps = explode('.', $path);

		return AdminPanel::getResource($path_steps[1].'Resource');
	}
}