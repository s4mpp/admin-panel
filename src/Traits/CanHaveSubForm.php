<?php

namespace S4mpp\AdminPanel\Traits;

trait CanHaveSubForm 
{
	public array $current_child_id = [];
	
	public array $current_child_data = [];
	
	public array $childs = [];
	
	public function mountCanHaveSubForm()
	{				
		$this->_setInitialChilds();
	}

	public function setCurrentChild(string $relation, int $i)
	{
		$this->current_child_id[$relation] = $i;

		$this->current_child_data[$relation] = $this->childs[$relation][$i];
	}

	public function saveChild(string $relation)
	{
		try
		{
			$repeater = $this->repeaters[$relation] ?? null;

			throw_if(!$repeater, 'Repeater '.$relation.' not found');

			$data_id = $this->current_child_data[$relation]['id'] ?? null;

			$model = $repeater->getModelRelation();

			if($data_id)
			{
				$register = new $model;

				$register->id = $data_id;
			}
			else
			{
				$register = new $model;
			}

			foreach($repeater->getFields() as $field)
			{
				$register->{$field->getName()} = $this->current_child_data[$relation][$field->getName()];
			}

			$child_id_relation = $this->current_child_id[$relation] ?? null;

			if(is_numeric($child_id_relation))
			{
				$this->childs[$relation][$child_id_relation] = $register;
			}
			else
			{
				$this->childs[$relation] = collect($this->childs[$relation])->push($register);
			}
			
			$this->reset('current_child_data', 'current_child_id');
			$this->dispatchBrowserEvent('close-slide');
		}
		catch (\Exception $e)
		{
			$this->addError('exception', $e->getMessage());
		}
		finally
		{
			$this->dispatchBrowserEvent('reset-form');
		}
	}

	private function _saveChilds($register)
	{
		foreach($this->repeaters ?? [] as $repeater)
		{
			$relation = $repeater->getRelation();

			$model = $repeater->getModelRelation();

			$childs_to_save = [];
			
			foreach($this->childs[$relation] ?? [] as $child)
			{
				$child_to_save = (isset($child['id']) && $child['id']) ? $model::find($child['id']) : new $model();

				foreach($repeater->getFields() as $field)
				{
					$child_to_save->{$field->getName()} = $child[$field->getName()];
				}

				$childs_to_save[] = $child_to_save;
			}

			$register->{$relation}()->saveMany($childs_to_save);
		}
	}

	private function _getDataSlidesAttribute(): array
	{
		foreach($this->repeaters ?? [] as $repeater)
		{
			$data_slides[] = 'slide'.$repeater->getRelation().': false';
		}

		return $data_slides ?? [];
	}

	private function _getCloseSlidesAttribute(): array
	{
		foreach($this->repeaters ?? [] as $repeater)
		{
			$close_slides[] = 'slide'.$repeater->getRelation().' = false';
		}

		return $close_slides ?? [];
	}

	private function _setInitialChilds()
	{
		foreach($this->repeaters ?? [] as $repeater)
		{
			$this->childs[$repeater->getRelation()] = $this->register ? $this->register->{$repeater->getRelation()} : collect([]);
		}
	}

	private function _setRepeaters()
	{
		$this->repeaters = $this->resource->getRepeaters();
	}
}
