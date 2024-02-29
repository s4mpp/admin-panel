<?php

namespace S4mpp\AdminPanel\CustomActions;

use S4mpp\AdminPanel\Traits\CallRouteAction;
use S4mpp\AdminPanel\Traits\RenderButtonLink;
use S4mpp\AdminPanel\Traits\ShoudOpenInNewTab;

final class View extends CustomAction
{
    use CallRouteAction, RenderButtonLink, ShoudOpenInNewTab;

    public function __construct(string $title, private ?string $view = null)
    {
        parent::__construct($title);

        $this->setAction('customActionView');
    }

    public function getUrl(): string
    {
        return '#';
    }

    public function getView(): ?string
    {
        return $this->view;
    }

    // public function getCallbackRoute($resource)
    // {
    // 	return function($id) use ($resource)
    // 	{
    // 		$register = $resource->getModel()::findOrFail($id);

    // 		return view('admin::custom-actions.content.view-action', [
    // 			'title' => $resource->title,
    // 			'action_title'=> $this->getTitle(),
    // 			'register'=> $register,
    // 			'resource'=> $resource,
    // 			'view' => $this->view
    // 		]);
    // 	};
    // }
}
