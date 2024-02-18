<?php

namespace S4mpp\AdminPanel\Controllers;

use S4mpp\AdminPanel\Utils;
use Illuminate\Http\Request;
use S4mpp\AdminPanel\Resource;
use S4mpp\AdminPanel\AdminPanel;
use Illuminate\Routing\Controller;
use S4mpp\Laraguard\Laraguard;

class ResourceController extends Controller
{
    public function __invoke()
	{
		$path = request()->route()->action['as'];
		
		$path_steps = explode('.', $path);

		$resource =  AdminPanel::getResource($path_steps[2]);

		return Laraguard::layout('admin::resources.index', compact('resource'));
	}

	public function create()
	{
		$path = request()->route()->action['as'];
		
		$path_steps = explode('.', $path);

		$resource =  AdminPanel::getResource($path_steps[2]);

		//----------------------------------------------------------------

		return Laraguard::layout('admin::resources.create', compact('resource'));
	}

	public function read(int $id)
	{
		$path = request()->route()->action['as'];
		
		$path_steps = explode('.', $path);

		$resource =  AdminPanel::getResource($path_steps[2]);

		//----------------------------------------------------------------

		$register = $resource->getModel()->findOrFail($id);

		$custom_actions = [];

		foreach($resource->getCustomActions() as $custom_action)
		{
			// if(!Utils::checkRoles($custom_action->getRolesForAccess()))
			// {
			// 	continue;
			// }

			// $custom_action->setRegister($register);

			$custom_actions[$custom_action->getSlug()] = $custom_action;
		}


		return Laraguard::layout('admin::resources.read', compact('resource', 'register', 'custom_actions'));
	}

	public function delete()
	{
		$path = request()->route()->action['as'];
		
		$path_steps = explode('.', $path);

		$resource =  AdminPanel::getResource($path_steps[2]);

		//----------------------------------------------------------------

		// delete
	}

	public function report(string $slug)
	{
		$path = request()->route()->action['as'];
		
		$path_steps = explode('.', $path);

		$resource =  AdminPanel::getResource($path_steps[2]);

		//----------------------------------------------------------------

		$report = $resource->getReport($slug);

		return Laraguard::layout('admin::resources.report', compact('resource', 'report'));
	}
	

	public function customActionCallback()
	{
		
	}

    public function customActionUpdate()
	{

	}

    public function customActionView()
	{

	}



	// public function report()
	// {
	// 	$report = null;

	// 	$resource = $this->_getResource();

	// 	$path = explode('/', request()->route()->uri);

	// 	$slug_report = end($path);

	// 	$report = $resource->getReport($slug_report);

	// 	if(!$report)
	// 	{
	// 		abort(404);
	// 	}

	// 	$report->setModel($resource->getModel());

	// 	return $resource->getView('report', [
	// 		'resource' => $resource,
	// 		'report' => $report
	// 	]);
	// }

    // public function create()
	// {
	// 	$resource = $this->_getResource();

	// 	return $resource->getView('create', compact('resource'));
	// }

    // public function update(int $id)
	// {
	// 	$resource = $this->_getResource();

	// 	$register = $resource->getModel()->findOrFail($id);

	// 	return $resource->getView('update', compact('resource', 'register'));
	// }

    // public function read(int $id)
	// {
	// 	$resource = $this->_getResource();

	// 	$register = $resource->getModel()->findOrFail($id);

	// 	$custom_actions = null;

	// 	foreach($resource->getCustomActions() as $custom_action)
	// 	{
	// 		if(!Utils::checkRoles($custom_action->getRolesForAccess()))
	// 		{
	// 			continue;
	// 		}

	// 		$custom_action->setRegister($register);

	// 		$custom_actions[$custom_action->getSlug()] = $custom_action;
	// 	}

	// 	return $resource->getView('read', compact('resource', 'register', 'custom_actions'));
	// }

    // public function delete(Request $request, int $id)
	// {
	// 	$resource = $this->_getResource();

	// 	$register = $resource->getModel()->findOrFail($id);

	// 	$register->delete();

	// 	$request->session()->flash('message', 'Exclusão realizada com sucesso!');

	// 	return redirect()->route($resource->getRouteName('index'));
	// }

	// private function _getResource(): Resource
	// {
	// 	$path = request()->route()->action['as'];

	// 	$path_steps = explode('.', $path);

	// 	return AdminPanel::getResource($path_steps[1].'Resource');
	// }
}