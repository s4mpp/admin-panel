<?php

namespace S4mpp\AdminPanel\Traits;

trait CanHaveSubForm
{
    // public array $current_child_id = [];

    // public array $current_child_data = [];

    // public array $childs = [];

    // public $error_child = null;

    // public function mountCanHaveSubForm()
    // {
    // 	$this->_loadChilds();
    // }

    // public function bootedCanHaveSubForm()
    // {
    // 	$this->_reloadChilds();
    // }

    // public function setCurrentChild(string $repeater, int $i)
    // {
    // 	$this->current_child_id[$repeater] = $i;

    // 	$this->current_child_data[$repeater] = $this->childs[$repeater][$i];
    // }

    // public function setChildEmpty(string $repeater)
    // {
    // 	$this->current_child_id[$repeater] = null;

    // 	foreach($this->repeaters[$repeater]->getFields() as $field)
    // 	{
    // 		$fields[$field->getName()] = null;
    // 	}

    // 	$this->current_child_data[$repeater] = $fields ?? [];
    // }

    // public function saveChild(string $relation)
    // {
    // 	$this->reset('error_child');

    // 	try
    // 	{
    // 		$repeater = $this->repeaters[$relation] ?? null;

    // 		throw_if(!$repeater, 'Repeater '.$relation.' not found');

    // 		$data_id = $this->current_child_data[$relation]['id'] ?? null;

    // 		throw_if($data_id && !$repeater->canEdit(), 'Edição não permitida');

    // 		throw_if(!$data_id && !$repeater->canAdd(), 'Cadastro não permitido');

    // 		$model = $repeater->getModelRelation();

    // 		if($data_id)
    // 		{
    // 			$register = $model::find($data_id);
    // 		}
    // 		else
    // 		{
    // 			$register = new $model;
    // 		}

    // 		foreach($repeater->getFields() as $field)
    // 		{
    // 			$register->{$field->getName()} = $this->current_child_data[$relation][$field->getName()];
    // 		}

    // 		$child_id_relation = $this->current_child_id[$relation] ?? null;

    // 		if(is_numeric($child_id_relation))
    // 		{
    // 			$this->childs[$relation][$child_id_relation] = $register;
    // 		}
    // 		else
    // 		{
    // 			$this->childs[$relation] = collect($this->childs[$relation])->push($register);
    // 		}

    // 		$this->reset('current_child_data', 'current_child_id');
    // 		$this->dispatchBrowserEvent('close-slide');
    // 	}
    // 	catch (\Exception $e)
    // 	{
    // 		$this->error_child = $e->getMessage();
    // 	}
    // 	finally
    // 	{
    // 		$this->dispatchBrowserEvent('reset-form-child');
    // 	}
    // }

    // private function _saveChilds($register)
    // {
    // 	foreach($this->repeaters ?? [] as $repeater)
    // 	{
    // 		$relation = $repeater->getRelation();

    // 		$childs_to_save = [];

    // 		foreach($this->childs[$relation] ?? [] as $child)
    // 		{
    // 			$childs_to_save[] = $child;
    // 		}

    // 		$register->{$relation}()->saveMany($childs_to_save);
    // 	}
    // }

    // private function _getDataSlidesAttribute(): array
    // {
    // 	foreach($this->repeaters ?? [] as $repeater)
    // 	{
    // 		$data_slides[] = 'slide'.$repeater->getRelation().': false';
    // 	}

    // 	return $data_slides ?? [];
    // }

    // private function _getCloseSlidesAttribute(): array
    // {
    // 	foreach($this->repeaters ?? [] as $repeater)
    // 	{
    // 		$close_slides[] = 'slide'.$repeater->getRelation().' = false';
    // 	}

    // 	return $close_slides ?? [];
    // }

    // private function _loadChilds()
    // {
    // 	foreach($this->repeaters ?? [] as $repeater)
    // 	{
    // 		$this->childs[$repeater->getRelation()] = $this->register ? $this->register->{$repeater->getRelation()} : collect([]);
    // 	}
    // }

    // private function _reloadChilds()
    // {
    // 	foreach($this->repeaters ?? [] as $repeater)
    // 	{
    // 		$model = $repeater->getModelRelation();

    // 		$registers_saved = $this->childs[$repeater->getRelation()];

    // 		foreach($registers_saved as &$register_saved)
    // 		{
    // 			$register_on_db = (isset($register_saved['id'])) ? $this->register->{$repeater->getRelation()}()->find($register_saved['id']) : new $model;

    // 			foreach($repeater->getFields() as $field)
    // 			{
    // 				$register_on_db->{$field->getName()} = $register_saved[$field->getName()] ?? null;
    // 			}

    // 			$register_saved = $register_on_db;
    // 		}

    // 		$this->childs[$repeater->getRelation()] = $registers_saved;
    // 	}
    // }

    // private function _setRepeaters()
    // {
    // 	$all_repeaters = $this->resource->getRepeaters();

    // 	foreach($all_repeaters as $repeater)
    // 	{
    // 		if(!$repeater->canAdd() && !$repeater->canEdit())
    // 		{
    // 			continue;
    // 		}

    // 		$repeaters[] = $repeater;
    // 	}

    // 	$this->repeaters = $repeaters ?? [];
    // }
}
