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

                $this->startTime = date("m/d/Y h:i:s a", time());
                Log::info('sent');
                Log::info($this->startTime);
                $this->success = 'Email sent';
            }
        );

        if (!$executed) {
            $this->ratelimitWarning = 'Only one email can be sent every 15 seconds';
        }

       
    }

    public function clearRateLimiter() {
        $now = date("m/d/Y h:i:s a", time());
        $future = date("m/d/Y h:i:s a", strtotime($this->startTime . " 15 seconds"));

        if ($now > $future) {
            RateLimiter::clear('send-email:' . Auth::id());
            $this->ratelimitWarning = '';
        }
    }

    public function render()
    {
        return view('livewire.email-form');
    }
}
