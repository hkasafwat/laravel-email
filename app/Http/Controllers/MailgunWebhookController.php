<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Message;

class MailgunWebhookController extends Controller
{
    public function handleWebhooks(Request $request)
    {
        try {            
            $this->updateEmailStatus($request);

            return response('Success', 200);
        }
        catch (Exception $e) {
            return response($e->getMessage(), 406);
        }
    }

    public function updateEmailStatus($data) 
    {
        $event_data = $data['event-data'];
        $email_id = $event_data['user-variables']['email_id'];
        $status = $event_data['event'];

        $message = Message::find($email_id);

        $message->status = $status;

        $message->save();
    }
}
