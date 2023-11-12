<?php

namespace S4mpp\AdminPanel\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use S4mpp\AdminPanel\AdminPanel;

class CrudController extends Controller
{
    public function index(Request $request)
	{
		$name_route = $request->route()->action['as'];

		$module_slug = explode('.', $name_route)[1];

		$admin = AdminPanel::getInstance();

		$resource = $admin->loadResources()->getResource($module_slug);

		return $resource->getView('index', [
			'resource' => $resource
		]);
	}

    public function create(Request $request)
	{
		$name_route = $request->route()->action['as'];

		$module_slug = explode('.', $name_route)[1];

		$admin = AdminPanel::getInstance();

		$resource = $admin->loadResources()->getResource($module_slug);

		return $resource->getView('create', [
			'resource' => $resource
		]);
	}

    public function update(Request $request, int $id)
	{
		$name_route = $request->route()->action['as'];

		$module_slug = explode('.', $name_route)[1];

		$admin = AdminPanel::getInstance();

		$resource = $admin->loadResources()->getResource($module_slug);

		$register = $resource->getModel()->findOrFail($id);

		return $resource->getView('update', [
			'resource' => $resource,
			'register' => $register,
		]);
	}

    public function read(Request $request, int $id)
	{
		$name_route = $request->route()->action['as'];

		$module_slug = explode('.', $name_route)[1];

		$admin = AdminPanel::getInstance();

		$resource = $admin->loadResources()->getResource($module_slug);

		$register = $resource->getModel()->findOrFail($id);

		$read = $resource->getRead();

		return $resource->getView('read', [
			'resource' => $resource,
			'register' => $register,
			'read' => $read,
		]);
	}
}