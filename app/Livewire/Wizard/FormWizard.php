<?php

namespace App\Livewire\Wizard;

use Livewire\Component;

class FormWizard extends Component
{
    public int $step = 1;

    public array $data = [
        'name' => '',
        'email' => '',
        'password' => '',
    ];

    public function nextStep()
    {
        $this->validateStep();
        $this->step++;
    }

    public function previousStep()
    {
        $this->step--;
    }

    public function submit()
    {
        $this->validate([
            'data.name' => 'required|min:3',
            'data.email' => 'required|email',
            'data.password' => 'required|min:6',
        ]);

        // Aquí puedes guardar en DB o lanzar evento

        session()->flash('message', 'Formulario enviado correctamente');
        $this->reset();
    }

    public function validateStep()
    {
        if ($this->step === 1) {
            $this->validate(['data.name' => 'required|min:3']);
        }

        if ($this->step === 2) {
            $this->validate(['data.email' => 'required|email']);
        }

        if ($this->step === 3) {
            $this->validate(['data.password' => 'required|min:6']);
        }
    }

    public function render()
    {
        return view('livewire.wizard.form-wizard');
    }
}
