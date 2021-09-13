

    <div class="flex flex-col justify-center min-h-screen py-12 bg-gray-50 sm:px-6 lg:px-8">
        <div class="absolute top-0 right-0 mt-4 mr-4">
            @if (Route::has('login'))
                <div class="space-x-4">
                    @auth
                        <a
                            href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                            class="font-medium text-indigo-600 hover:text-indigo-500 focus:outline-none focus:underline transition ease-in-out duration-150"
                        >
                            Log out
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="font-medium text-indigo-600 hover:text-indigo-500 focus:outline-none focus:underline transition ease-in-out duration-150">Log in</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="font-medium text-indigo-600 hover:text-indigo-500 focus:outline-none focus:underline transition ease-in-out duration-150">Register</a>
                        @endif
                    @endauth
                </div>
            @endif
        </div>

        <div>
            <div class="bg-purple-100 shadow rounded p-4 max-w-5xl mx-auto mt-4">
                <div class="text-3xl font-bold mb-4 text-center pt-2 pb-3">Send Email</div>
        
                <form class="flex flex-col space-y-2" wire:submit.prevent>
                    @csrf
                    <input class="rounded border-0 shadow py-4" type="email" name="email" placeholder="Recipient Email" wire:model="email"/>
                    @error('email')
                        <span class="error text-red-600 font-bold">{{ $message }}</span>
                    @enderror
                    <textarea name="messageContent" class="rounded h-44 border-0 shadow" placeholder="Message" wire:model="messageContent"></textarea>
                    @error('messageContent')
                        <span class="error text-red-600 font-bold">{{ $message }}</span>
                    @enderror
                    <button class="bg-white shadow rounded p-4 font-bold text-lg w-32 mx-auto" wire:click="submit">Submit</button>
                </form>
            </div>
        </div>
    </div>



