<?php

namespace S4mpp\AdminPanel\Controllers;

use Illuminate\View\View;
use S4mpp\AdminPanel\Utils;
use Illuminate\Http\Request;
use S4mpp\AdminPanel\Resource;
use S4mpp\Laraguard\Laraguard;
use S4mpp\AdminPanel\AdminPanel;
use S4mpp\AdminPanel\Input\Input;
use Illuminate\Routing\Controller;
use S4mpp\AdminPanel\Labels\Label;
use S4mpp\AdminPanel\Utils\Finder;
use S4mpp\AdminPanel\Elements\Card;
use S4mpp\AdminPanel\Filter\Filter;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Route;
use S4mpp\AdminPanel\Elements\Report;
use S4mpp\AdminPanel\CustomActions\Update;
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
        $path = request()->route()->action['as'];

        $path_steps = explode('.', $path);

        $resource = AdminPanel::getResource($path_steps[2]);

        //----------------------------------------------------------------

        $filters = Finder::onlyOf($resource->filters(), Filter::class);

        $alpine_expression_filters = [];

        foreach($filters as $filter) {
            $alpine_expression_filters[] = join(':', [$filter->getField(), $filter->getAlpineExpression()]);
        }

        $reports = Finder::onlyOf($resource->reports(), Report::class);

        $placeholder_search = $resource->getMessagePlaceholderSearch();

        return Laraguard::layout('admin::resources.index', compact('resource', 'filters', 'reports', 'placeholder_search', 'alpine_expression_filters'));
    }

    public function create(): ViewFactory|ViewContract|null
    {
        $path = request()->route()->action['as'];

        $path_steps = explode('.', $path);

        $resource = AdminPanel::getResource($path_steps[2]);

        //----------------------------------------------------------------

        return Laraguard::layout('admin::resources.create', compact('resource'));
    }

    public function update(int $id): ViewFactory|ViewContract|null
    {
        $path = request()->route()->action['as'];

        $path_steps = explode('.', $path);

        $resource = AdminPanel::getResource($path_steps[2]);

        //----------------------------------------------------------------

        $inputs = Finder::findElementsRecursive($resource->form(), Input::class);

        $fields = array_map(fn ($input) => $input->getName(), $inputs);

        array_unshift($fields, 'id');

        $register = $resource->getModel()->select($fields)->findOrFail($id);

        $register = $register->getAttributes();

        return Laraguard::layout('admin::resources.update', compact('resource', 'register'));
    }

    public function read(int $id): ViewFactory|ViewContract|null
    {
        $path = request()->route()->action['as'];

        $path_steps = explode('.', $path);

        $resource = AdminPanel::getResource($path_steps[2]);

        //----------------------------------------------------------------

        $read = Finder::fillInCard(Finder::onlyOf($resource->read(), Label::class, Card::class));

        $register = $resource->getModel()->findOrFail($id);

        $custom_actions = $resource->customActions();

        $custom_action_elements = Finder::findElementsRecursive($custom_actions, CustomAction::class);

        $custom_action_slides = $custom_actions_modals = [];
        
        foreach ($custom_action_elements as $custom_action) {

            $custom_action->setResource($resource);
            
            $custom_action->setRegister($register);

            if(method_exists($custom_action, 'getNameSlide'))
            {
                $custom_action_slides[] = $custom_action->getNameSlide().': false';
            }
            elseif(method_exists($custom_action, 'getNameModal'))
            {
                $custom_actions_modals[] = $custom_action->getNameModal().': false';
            }

            if($custom_action->hasConfirmation())
            {
                $custom_actions_modals[] = $custom_action->getNameModalConfirmation().': false';
            }
        }

        return Laraguard::layout('admin::resources.read', compact('resource', 'read', 'register', 'custom_actions', 'custom_action_elements', 'custom_action_slides', 'custom_actions_modals'));
    }

    public function delete(): void
    {
        $path = request()->route()->action['as'];

        $path_steps = explode('.', $path);

        $resource = AdminPanel::getResource($path_steps[2]);

        //----------------------------------------------------------------

        // delete
    }

    public function report(string $slug): ViewFactory|ViewContract|null
    {
        $path = request()->route()->action['as'];

        $path_steps = explode('.', $path);

        $resource = AdminPanel::getResource($path_steps[2]);

        //----------------------------------------------------------------

        $report = $resource->getReport($slug);

        if (! $report) {
            abort(404);
        }

        $filters = Finder::onlyOf($resource->filters(), Filter::class); 

        $alpine_expression_filters = [];

        foreach($filters as $filter) {
            $alpine_expression_filters[] = join(':', [$filter->getField(), $filter->getAlpineExpression()]);
        }

        return Laraguard::layout('admin::resources.report', compact('resource', 'report', 'filters', 'alpine_expression_filters'));
    }

    public function customActionCallback(int $id): RedirectResponse
    {
        $path = request()->route()->action['as'];

        $path_steps = explode('.', $path);

        $resource = AdminPanel::getResource($path_steps[2]);

        //----------------------------------------------------------------

        $register = $resource->getModel()->findOrFail($id);

        $path_steps = explode('.', $path);

        
        try
        {
            $custom_action = Finder::findBySlug(Finder::findElementsRecursive($resource->customActions(), Callback::class), $path_steps[3]);
    
            $result = call_user_func($custom_action->getCallback(), $register);
                
            return back()->withMessage($custom_action->getSuccessMessage($result));
        }
        catch(\Exception $e)
        {
            return back()->withErrors($e->getMessage());
        }
    }

    public function customActionUpdate(int $id): RedirectResponse
    {
        $path = request()->route()->action['as'];

        $path_steps = explode('.', $path);

        $resource = AdminPanel::getResource($path_steps[2]);

        //----------------------------------------------------------------

        $register = $resource->getModel()->findOrFail($id);

        $path_steps = explode('.', $path);

        try
        {
            $custom_action = Finder::findBySlug(Finder::findElementsRecursive($resource->customActions(), Update::class), $path_steps[3]);
    
            foreach($custom_action->getDataToChange() as $key => $new_value)
            {
                $register->{$key} = $new_value;
            }

            $register->save();            
                
            return back()->withMessage($custom_action->getSuccessMessage($register));
        }
        catch(\Exception $e)
        {
            return back()->withErrors($e->getMessage());
        }
    }

    public function customActionView(int $id): ViewFactory|ViewContract|null
    {
        $path = request()->route()->action['as'];

        $path_steps = explode('.', $path);

        $resource = AdminPanel::getResource($path_steps[2]);

        //----------------------------------------------------------------

        $register = $resource->getModel()->findOrFail($id);

        $path_steps = explode('.', $path);

        $custom_action = Finder::findBySlug(Finder::findElementsRecursive($resource->customActions(), CustomAction::class), $path_steps[3]);

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
    // 	$path = request()->route()->action['as'];

    // 	$path_steps = explode('.', $path);

    // 	return AdminPanel::getResource($path_steps[1].'Resource');
    // }
}
