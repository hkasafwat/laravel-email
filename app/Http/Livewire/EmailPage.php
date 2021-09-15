<?php

namespace App\Http\Livewire;


use Livewire\Component;

class EmailPage extends Component
{
    public $emails;

    public function render()
    {
        return view('livewire.email-page');
    }
}
