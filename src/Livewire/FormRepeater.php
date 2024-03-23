<?php

namespace S4mpp\AdminPanel\Livewire;

use Livewire\Component;
use S4mpp\AdminPanel\Input\Input;
use S4mpp\AdminPanel\Utils\Finder;
use Illuminate\Contracts\View\View;
use S4mpp\AdminPanel\Elements\Repeater;
use S4mpp\AdminPanel\Traits\CreatesForm;
use S4mpp\AdminPanel\Traits\WithAdminResource;
use Illuminate\Contracts\View\Factory as ViewFactory;

/**
 * @codeCoverageIgnore
 */
final class FormRepeater extends Component
{
    use CreatesForm, WithAdminResource;

    public string $repeater_slug;

    public ?int $id_temp = null;

    public ?int $register_id = null;

    private Repeater $repeater;

    /**
     * @return array<string>
     */
    protected function getListeners(): array
    {
        return ['setRegister:'.$this->repeater->getRelation() => 'setRegister'];
    }

    public function mount(string $resource_slug, string $repeater_slug): void
    {
        $this->fill(compact('resource_slug', 'repeater_slug'));

        $this->loadResource();

        $this->repeater = Finder::findBySlug($this->resource->repeaters(), $this->repeater_slug);

        $this->form = Finder::onlyOf($this->repeater->getForm(), Input::class);

        $this->setInitialData();
    }

    public function booted(): void
    {
        $this->loadResource();

        $this->repeater = Finder::findBySlug($this->resource->repeaters(), $this->repeater_slug);

        $this->form = Finder::onlyOf($this->repeater->getForm(), Input::class);
    }

    public function render(): View|ViewFactory
    {
        return view('admin::livewire.form-repeater', [
            'form' => $this->form,
        ]);
    }

    /**
     * @param  array<string>  $data
     */
    public function setRegister(?int $id_temp = null, ?int $register_id = null, array $data = []): void
    {
        $this->id_temp = $id_temp;

        $this->register_id = $register_id;

        $this->setData($data);
    }

    public function save(): void
    {
        $this->resetValidation();

        $this->dispatch('reset-loading');

        $this->dispatch('setChild', 
            relation: $this->repeater->getRelation(),
            id_temp: $this->id_temp,
            register_id: $this->register_id,
            data_to_save: $this->data
        )->to('form-resource');

        $this->reset('data', 'id_temp', 'register_id');

        $this->dispatch('close-slide');
    }
}
