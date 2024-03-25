<?php

namespace S4mpp\AdminPanel\Controllers;

use S4mpp\AdminPanel\Utils;
use Illuminate\Http\Request;
use S4mpp\AdminPanel\Resource;
use S4mpp\Laraguard\Laraguard;
use S4mpp\AdminPanel\AdminPanel;
use S4mpp\AdminPanel\Input\Input;
use Illuminate\Routing\Controller;
use S4mpp\AdminPanel\Enums\Action;
use S4mpp\AdminPanel\Labels\Label;
use S4mpp\AdminPanel\Utils\Finder;
use S4mpp\AdminPanel\Elements\Card;
use S4mpp\AdminPanel\Filter\Filter;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Route;
use S4mpp\AdminPanel\Elements\Report;
use S4mpp\AdminPanel\Elements\Repeater;
use S4mpp\AdminPanel\CustomActions\View;
use S4mpp\AdminPanel\CustomActions\Update;
use Spatie\Permission\PermissionRegistrar;
use S4mpp\AdminPanel\CustomActions\Callback;
use S4mpp\AdminPanel\CustomActions\CustomAction;
use Illuminate\Contracts\View\View as ViewContract;
use Illuminate\Contracts\View\Factory as ViewFactory;

/**
 * @codeCoverageIgnore
 */
final class ResourceController extends Controller
{
    public function __invoke(): ViewFactory|ViewContract|null
    {
        /** @var string */
        $path = Route::current()?->getAction('as');

        $path_steps = explode('.', $path);

        $resource = AdminPanel::getResource($path_steps[2]);

        if(!$resource)
        {
            throw new \Exception('Resource not found');
        }

        //----------------------------------------------------------------

        $filters = $resource->getFilters();

        $alpine_expression_filters = [];

        foreach ($filters as $filter) {
            $alpine_expression_filters[] = implode(':', [$filter->getField(), $filter->getAlpineExpression()]);
        }

        $reports = array_filter($resource->getReports(), function(Report $report) use ($resource)
        {
            return Auth::guard(AdminPanel::getGuardName())->user()->can($resource->getName().'.report.'.$report->getSlug());
        }); 

        $placeholder_search = $resource->getMessagePlaceholderSearch();

        $can_create = Auth::guard(AdminPanel::getGuardName())->user()->can($resource->getName().'.create');

        return Laraguard::layout('admin::resources.index', compact('resource', 'filters', 'reports', 'placeholder_search', 'alpine_expression_filters', 'can_create'));
    }

    public function create(): ViewFactory|ViewContract|null
    {
        /** @var string */
        $path = Route::current()?->getAction('as');

        $path_steps = explode('.', $path);

        $resource = AdminPanel::getResource($path_steps[2]);

        if(!$resource)
        {
            throw new \Exception('Resource not found');
        }

        //----------------------------------------------------------------

        $repeaters = $resource->getRepeaters();

        $data_slides = [];

        foreach ($repeaters as $repeater) {
            $data_slides[] = 'slide'.$repeater->getRelation().': false';
        }

        return Laraguard::layout('admin::resources.create', compact('resource', 'repeaters', 'data_slides'));
    }

    public function update(int $id): ViewFactory|ViewContract|null
    {
        /** @var string */
        $path = Route::current()?->getAction('as');

        $path_steps = explode('.', $path);

        $resource = AdminPanel::getResource($path_steps[2]);

        if(!$resource)
        {
            throw new \Exception('Resource not found');
        }

        //----------------------------------------------------------------

        $repeaters = $resource->getRepeaters();

        $data_slides = [];

        foreach ($repeaters as $repeater) {
            $data_slides[] = 'slide'.$repeater->getRelation().': false';
        }

        /** @var array<Input> */
        $inputs = Finder::findElementsRecursive($resource->setCurrentAction(Action::Update)->getForm(), Input::class);

        $fields = array_map(fn (Input $input) => $input->getName(), $inputs);

        array_unshift($fields, 'id');

        $register = $resource->getModel()->select($fields)->findOrFail($id);

        $register = $register->getAttributes();

        return Laraguard::layout('admin::resources.update', compact('resource', 'register', 'repeaters', 'data_slides'));
    }

    public function read(int $id): ViewFactory|ViewContract|null
    {
        /** @var string */
        $path = Route::current()?->getAction('as');

        $path_steps = explode('.', $path);

        $resource = AdminPanel::getResource($path_steps[2]);

        if(!$resource)
        {
            throw new \Exception('Resource not found');
        }

        //----------------------------------------------------------------

        $read = Finder::fillInCard($resource->getRead());

        $register = $resource->getModel()->findOrFail($id);

        $repeaters = $resource->getRepeaters();
        
        $custom_actions = array_filter($resource->getCustomActions(), function(CustomAction $custom_action) use ($resource)
        {
            return Auth::guard(AdminPanel::getGuardName())->user()->can($resource->getName().'.custom-action.'.$custom_action->getSlug());
        }); 
        
        /** @var array<CustomAction> $custom_action_elements */
        $custom_action_elements = Finder::findElementsRecursive($custom_actions, CustomAction::class);

        $custom_action_slides = $custom_actions_modals = [];

        foreach ($custom_action_elements as $custom_action) {

            $custom_action->setResource($resource);

            $custom_action->setRegister($register);

            if (method_exists($custom_action, 'getNameSlide')) {
                $custom_action_slides[] = $custom_action->getNameSlide().': false';
            } elseif (method_exists($custom_action, 'getNameModal')) {
                $custom_actions_modals[] = $custom_action->getNameModal().': false';
            }

            if ($custom_action->hasConfirmation()) {
                $custom_actions_modals[] = $custom_action->getNameModalConfirmation().': false';
            }
        }

        return Laraguard::layout('admin::resources.read', compact('resource', 'read', 'register', 'custom_actions', 'custom_action_elements', 'custom_action_slides', 'custom_actions_modals', 'repeaters'));
    }

    public function delete(): void
    {
        /** @var string */
        $path = Route::current()?->getAction('as');

        $path_steps = explode('.', $path);

        $resource = AdminPanel::getResource($path_steps[2]);

        if(!$resource)
        {
            throw new \Exception('Resource not found');
        }

        //----------------------------------------------------------------

        // delete
    }

    public function report(): ViewFactory|ViewContract|null
    {
        /** @var string */
        $path = Route::current()?->getAction('as');

        $path_steps = explode('.', $path);

        $resource = AdminPanel::getResource($path_steps[2]);

        if(!$resource)
        {
            throw new \Exception('Resource not found');
        }

        //----------------------------------------------------------------

        $path_steps = explode('.', $path);

        $report = Finder::findBySlug($resource->getReports(), $path_steps[3]);

        if (! $report) {
            abort(404);
        }

        $filters = $resource->getFilters();

        $alpine_expression_filters = [];

        foreach ($filters as $filter) {
            $alpine_expression_filters[] = implode(':', [$filter->getField(), $filter->getAlpineExpression()]);
        }

        return Laraguard::layout('admin::resources.report', compact('resource', 'report', 'filters', 'alpine_expression_filters'));
    }

    public function customActionCallback(int $id): RedirectResponse
    {
        /** @var string */
        $path = Route::current()?->getAction('as');

        $path_steps = explode('.', $path);

        $resource = AdminPanel::getResource($path_steps[2]);

        if(!$resource)
        {
            throw new \Exception('Resource not found');
        }

        //----------------------------------------------------------------

        $register = $resource->getModel()->findOrFail($id);

        $path_steps = explode('.', $path);

        try {
            /** @var Callback */
            $custom_action = Finder::findBySlug(Finder::findElementsRecursive($resource->getCustomActions(), Callback::class), $path_steps[3]);

            $result = call_user_func($custom_action->getCallback(), $register);

            return back()->withMessage($custom_action->getSuccessMessage($result));
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }

    public function customActionUpdate(int $id): RedirectResponse
    {
        /** @var string */
        $path = Route::current()?->getAction('as');

        $path_steps = explode('.', $path);

        $resource = AdminPanel::getResource($path_steps[2]);

        if(!$resource)
        {
            throw new \Exception('Resource not found');
        }

        //----------------------------------------------------------------

        $register = $resource->getModel()->findOrFail($id);

        $path_steps = explode('.', $path);

        try {
            /** @var Update */
            $custom_action = Finder::findBySlug(Finder::findElementsRecursive($resource->getCustomActions(), Update::class), $path_steps[3]);

            foreach ($custom_action->getDataToChange() as $key => $new_value) {
                $register->{$key} = $new_value;
            }

            $register->save();

            return back()->withMessage($custom_action->getSuccessMessage($register));
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }

    public function customActionView(int $id): ViewFactory|ViewContract|null
    {
        /** @var string */
        $path = Route::current()?->getAction('as');

        $path_steps = explode('.', $path);

        $resource = AdminPanel::getResource($path_steps[2]);

        if(!$resource)
        {
            throw new \Exception('Resource not found');
        }

        //----------------------------------------------------------------

        $register = $resource->getModel()->findOrFail($id);

        $path_steps = explode('.', $path);

        /** @var View */
        $custom_action = Finder::findBySlug(Finder::findElementsRecursive($resource->getCustomActions(), View::class), $path_steps[3]);

        $view = $custom_action->getView();

        return Laraguard::layout('admin::resources.custom-action-view', compact('resource', 'register', 'custom_action', 'view'));
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
    // 	/** @var string */
        // $path = Route::current()?->getAction('as');

    // 	$path_steps = explode('.', $path);

    // 	return AdminPanel::getResource($path_steps[1].'Resource');
    // }
}
