<?php

namespace S4mpp\AdminPanel\Elements;

use S4mpp\AdminPanel\Input\Input;
use S4mpp\AdminPanel\Labels\Label;
use S4mpp\AdminPanel\Utils\Finder;
use S4mpp\AdminPanel\Traits\Slugable;
use S4mpp\AdminPanel\Traits\Ordenable;
use S4mpp\AdminPanel\Traits\Titleable;
use Illuminate\Database\Eloquent\Model;
use S4mpp\AdminPanel\Column\RepeaterActions;

final class Repeater
{
    use Ordenable, Slugable, Titleable;

    // private $model = null;

    // private string $order_field = 'id';

    // private string $order_direction = 'DESC';

    private bool $can_edit = false;

    private bool $can_add = false;

    // private int $total_registers = 0;

    // , private array $fields = [],

    /**
     * @param  array<Label>  $columns
     * @param  array<Input>  $fields
     */
    public function __construct(private string $title, private string $relation, private array $columns = [], private array $fields = [])
    {
        $this->createSlug($title);
    }

    // public function order(string $field = 'id', string $direction = 'DESC')
    // {
    // 	$this->order_field = $field;

    // 	$this->order_direction = $direction;

    // 	return $this;
    // }

    public function allowEdit(): self
    {
        $this->can_edit = true;

        return $this;
    }

    public function allowAdd(): self
    {
        $this->can_add = true;

        return $this;
    }

    public function canEdit(): bool
    {
        return $this->can_edit;
    }

    public function canAdd(): bool
    {
        return $this->can_add;
    }

    public function orderBy(?string $field = null, ?string $direction = null): self
    {
        $this->setOrdenation($field, $direction);

        return $this;
    }

    // public function getFieldOrderBy()
    // {
    // 	return $this->order_field;
    // }

    // public function getDirectionOrderBy()
    // {
    // 	return $this->order_direction;
    // }

    // public function setRelationShipMethod($model)
    // {
    // 	$this->model = $model;

    // 	return $this;
    // }

    public function getRelation(): string
    {
        return $this->relation;
    }

    // public function getModelRelation()
    // {
    // 	return $this->model->getRelated();
    // }

    // public function getNameModelRelation(): string
    // {
    // 	return get_class($this->model->getRelated());
    // }

    /**
     * @return array<Input>
     */
    public function getForm(): array
    {
        return $this->fields;
    }

    // public function getTotalRegisters(): int
    // {
    //     return $this->total_registers;
    // }

    // return $resource->getModel()->select('id')
    // 	->find($register->id)
    // 	->{$this->getRelation()}()
    // 	->count();
    // }

    /**
     * @return array<mixed>
     */
    public function getColumns(): array
    {
        return Finder::onlyOf($this->columns, Label::class);
    }

    // public function getColumnsWithActions(): array
    // {
    //     $columns = $this->getColumns();

    //     if ($this->can_edit) {
    //         // array_push($columns, (new RepeaterActions($this->relation))->align('right'));
    //     }

    //     return $columns;
    // }
}
