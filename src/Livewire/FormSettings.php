<?php

namespace S4mpp\AdminPanel\Livewire;

use Livewire\Component;
use S4mpp\AdminPanel\Settings;
use S4mpp\AdminPanel\AdminPanel;
use S4mpp\AdminPanel\Input\Input;
use Illuminate\Routing\Redirector;
use S4mpp\AdminPanel\Utils\Finder;
use Illuminate\Contracts\View\View;
use S4mpp\AdminPanel\Models\Setting;
use Illuminate\Http\RedirectResponse;
use S4mpp\AdminPanel\Traits\CreatesForm;
use Illuminate\Contracts\View\Factory as ViewFactory;

/**
 * @codeCoverageIgnore
 */
final class FormSettings extends Component
{
    use CreatesForm;

    public string $url;

    public function mount(string $url): void
    {
        $this->url = $url;

        $form = AdminPanel::getSettings();

        $this->form = Finder::fillInCard($form);

        /** @var array<Input> $fields */
        $fields = Finder::findElementsRecursive($form, Input::class);

        $this->setInitialData();

        foreach ($fields as $field) {
            $data[$field->getName()] = Settings::get($field->getName());
        }

        $this->setData($data ?? []);
    }

    public function booted(): void
    {
        $form = AdminPanel::getSettings();

        $this->form = Finder::fillInCard($form);
    }

    public function render(): View|ViewFactory
    {
        return view('admin::livewire.form');
    }

    public function save(): RedirectResponse|Redirector
    {
        $this->resetValidation();

        $this->dispatch('reset-loading');

        $fields = Finder::findElementsRecursive($this->form, Input::class);

        $fields_validated = $this->_validate($fields, 'settings');

        foreach ($fields as $field) {
            $register = Settings::getRegister($field->getName());

            $value = $fields_validated[$field->getName()];

            if (! $register && ! is_null($value)) {
                $register = new Setting();
                $register->key = $field->getName();
            }

            if ($register) {
                $register->value = $value;

                $register->save();
            }
        }

        session()->flash('message', 'Configurações salvas com sucesso!');

        return redirect($this->url);
    }
}
