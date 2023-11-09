<?php

namespace S4mpp\AdminPanel\Resources;

use Illuminate\Http\Request;

abstract class Delete
{
	public static function delete($resource)
	{
		return function(int $id, Request $request) use ($resource)
		{
			$item = $resource->getModel()::findOrFail($id);
	
			$item->delete();

			$request->session()->flash('message', 'Exclusão realizada com sucesso!');

			return redirect()->route($resource->getRouteName('index'));
		};
	}
}