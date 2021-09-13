<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Mail\EmailMessage;
use Illuminate\Support\Facades\Mail;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;

class EmailForm extends Component
{
    public $email;
    public $messageContent;
    public $success;

    protected $rules = [
        'email' => 'required|email',
        'messageContent' => 'required|max:140'
    ];

    public function submit()
    {
        $this->validate();

        Message::create([
            'user_id' => Auth::id(),
            'sender' => 'hkasafwat@gmail.com',
            'recipient' => $this->email,
            'messageContent' => $this->messageContent,
            'status' => 'queued'
        ]);
        // Mail::to('hkasafwat@gmail.com')->send(new EmailMessage($this->email, $this->messageContent));
        
        $this->success = 'Email sent';
    }

    public function render()
    {
        return view('livewire.email-form');
    }
}
