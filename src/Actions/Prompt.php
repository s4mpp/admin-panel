<?php

namespace S4mpp\AdminPanel\Actions;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use S4mpp\AdminPanel\Traits\HasNewTab;
use Illuminate\Support\Facades\Validator;
use S4mpp\AdminPanel\Traits\HasRouteAction;
use S4mpp\AdminPanel\Traits\HasSuccessMessage;

final class Prompt extends Action
{
	use HasNewTab, HasRouteAction, HasSuccessMessage;

	private $method_action = 'PUT';

	public function __construct(private string $message, private string $field)
	{}

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
		return view('admin::actions.buttons.prompt', ['action' => $this]);
	}

	public function renderContent()
	{
		return view('admin::actions.content.prompt', ['action' => $this]);
	}

	public function getCallbackRoute($resource)
	{
		return function($id, Request $request) use ($resource)
		{
			try
			{
				throw_if($this->isDisabled(), $this->getDisabledMessage());
				
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
		return view('admin::actions.modal-confirmation.modal', ['action' => $this]);
	}
}