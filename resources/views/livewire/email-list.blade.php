<div>
    <div class="bg-purple-100 shadow rounded p-4 max-w-5xl mx-auto mt-4">
        <div class="text-3xl font-bold mb-4 text-center pt-2 pb-3">
            Sent Emails
        </div>
        <div class="flex flex-col space-y-2">
            <div class="bg-white shadow rounded p-4 flex flex-row font-bold">
                <div class="px-1 w-1/12">ID</div>
                <div class="px-1 w-3/12">Recipient</div>
                <div class="px-1 w-4/12">Email Content</div>
                <div class="px-1 w-2/12">Status</div>
                <div class="px-1 w-2/12">Date Sent</div>
            </div>
            @foreach ($emails as $email)
            <div class="bg-white shadow rounded p-4 flex flex-row break-words" wire:poll>
                <div class="px-2 w-1/12">{{ $email->id }}</div>
                <div class="px-2 w-3/12">{{ $email->recipient }}</div>
                <div class="px-2 w-4/12">{{ $email->messageContent }}</div>
                <div class="px-2 w-2/12">{{ $email->status }}</div>
                <div class="px-2 w-2/12">{{ $email->created_at->format('h:i:s d-m-y') }}</div>
            </div>
            @endforeach
        </div>
    </div>

    <button class="bg-white shadow rounded p-4 font-bold text-lg w-32 mx-auto" wire:click="emails">Submit</button>

</div>
