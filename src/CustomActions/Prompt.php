<?php

namespace S4mpp\AdminPanel\CustomActions;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use S4mpp\AdminPanel\Traits\ShoudOpenInNewTab;
use S4mpp\AdminPanel\Traits\CallRouteMethod;
use S4mpp\AdminPanel\Traits\HasSuccessMessage;

final class Prompt extends CustomAction
{
	use ShoudOpenInNewTab, CallRouteMethod, HasSuccessMessage;

	public function __construct(public string $title, private string $message, private string $field)
	{
		parent::__construct($title);

		$this->setMethodAction('PUT');
	}

	public function getMessage(): string
	{
		return $this->message;
	}

	public function getNameModal(): string
	{
		return 'modal'.Str::ucfirst(Str::camel($this->getSlug()));
	}

	public function renderButton()
	{
		return view('admin::custom-actions.buttons.prompt', ['action' => $this]);
	}

	public function renderContent()
	{
		return view('admin::custom-actions.content.prompt', ['action' => $this]);
	}

	public function getCallbackRoute($resource)
	{
		return function($id, Request $request) use ($resource)
		{
			try
			{			
				$validator = Validator::make(
					['answer' => $request->get('answer') ?? ''],
					['answer' => ['required', 'string']],
					[],
					['answer' => $this->message]);
	
				$validator->validate();
	
				$validated_values = $validator->safe(['answer']);

				$register = $resource->getModel()::findOrFail($id);
	
				$register->{$this->field} = $validated_values['answer'];
	
				$register->save();
	
				return redirect()->back()->with('message', $this->getSuccessMessage());
			}
			catch(\Exception $e)
			{
				return redirect()->back()->withErrors($e->getMessage());
			}
		};
	}

	public function renderContentModalConfirmation()
	{
		return view('admin::custom-actions.modal-confirmation.modal', ['action' => $this]);
	}
}