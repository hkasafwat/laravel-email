<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Mail\EmailMessage;
use Illuminate\Support\Facades\Mail;
use App\Models\Message;
use DateTime;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;

class EmailForm extends Component
{
    public $email;
    public $messageContent;
    public $success;
    public $ratelimitWarning;
    public $startTime;

    protected $rules = [
        'email' => 'required|email',
        'messageContent' => 'required|max:140'
    ];

    public function submit()
    {
        $executed = RateLimiter::attempt(
            'send-email:' . Auth::id(),
            $perMinute = 1,
            function () {
                $this->validate();
                
                $message = Message::create([
                    'user_id' => Auth::id(),
                    'sender' => 'hkasafwat@gmail.com',
                    'recipient' => $this->email,
                    'messageContent' => $this->messageContent,
                    'status' => 'pending'
                ]);

                $this->emit('emailSubmit');

                Mail::to('hkasafwat@gmail.com')->send(new EmailMessage($message->id, $this->email, $this->messageContent));

                $this->startDate = date("m/d/Y h:i:s a", time());

                $this->success = 'Email sent';
            }
        );

        if (!$executed) {
            $this->ratelimitWarning = 'Only one email can be sent every 15 seconds';
            return 'Only one email can be sent every 15 seconds';
        }

        $now = date("m/d/Y h:i:s a", time());


        // Log::info(RateLimiter::remaining('send-email:' . Auth::id(), $perMinute = 1));
        if(RateLimiter::remaining('send-email:' . Auth::id(), $perMinute = 1) == 0 && $now > $this->startTime->modify('+30 seconds')) {
            
        
        }
    }

    public function rateLimiting()
    {
    }

    public function render()
    {
        return view('livewire.email-form');
    }
}
