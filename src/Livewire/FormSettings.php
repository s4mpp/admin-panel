<?php

namespace S4mpp\AdminPanel\Livewire;

use Livewire\Component;
use S4mpp\AdminPanel\AdminPanel;
use S4mpp\AdminPanel\Input\Input;
use S4mpp\AdminPanel\Utils\Finder;
use Illuminate\Database\Eloquent\Model;
use S4mpp\AdminPanel\Settings\Settings;
use S4mpp\AdminPanel\Traits\CreatesForm;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\View\Factory as ViewFactory;

/**
 * @codeCoverageIgnore
 */
final class FormSettings extends Component
{
    use CreatesForm;

    // protected $listeners = ['setField'];

    public function booted(): void
    {
        $form = AdminPanel::getSettings()?->getForm() ?? [];

        $this->form = Finder::fillInCard($form);

        /** @var array<Input> $fields */
        $fields = Finder::findElementsRecursive($form, Input::class);
        dump($fields);

        $name_fields = [];

        $name_fields = array_map(fn (Input $field) => Settings::get($field->getName()), $fields);

        dump($name_fields);

        // dump($fields);

        // $this->setInitialData($this->resource->getForm(), $register);
    }

    public function render(): View|ViewFactory
    {
        return view('admin::livewire.form');
    }

    // private function _getModel()
    // {
    // 	return app(Setting::class);
    // }

    // private function _saving(Model $settings)
    // {
    // 	$settings->save();

    // 	session()->flash('message', 'Configurações salvas com sucesso!');

    // 	return redirect()->route('admin.settings.index');
    // }

    // private function _setSearchFields()
    // {
    // 	$this->search_fields = $this->_getSearchFieldsForm();
    // }
}
