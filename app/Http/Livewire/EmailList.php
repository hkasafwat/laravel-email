<?php

namespace App\Http\Livewire;

use App\Models\Message;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class EmailList extends Component
{
    public $emails = [];

    protected $listeners = ['emailSubmit' => 'updateEmails'];

    public function updateEmails() {
        $this->emails = Message::where('user_id', Auth::id())->latest()->get();
        return $this->emails;
    }

    public function render()
    {
        $this->emails = Message::where('user_id', Auth::id())->latest()->get();

        return view('livewire.email-list');
    }
}
