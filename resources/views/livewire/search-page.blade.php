<div>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-full">
                    <div wire:loading>
                        Loading...
                    </div>
                    <div class="flex items-center" wire:loading.remove>
                        <input
                            wire:model.defer="userPrompt"
                            wire:keydown.enter="onClickSearch"
                            type="text"
                            name="userPrompt"
                            placeholder="La ce te gândești ?..."
                            class="w-full border border-gray-300 rounded-l px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400"
                        />
                        <button
                            id="sendButton"
                            name="sendButton"
                            wire:click="onClickSearch"
                            class="bg-blue-500 text-white font-bold py-2 px-4 rounded-r flex items-center ml-2 {{ $this->isLoading ? 'disabled:opacity-25' : '' }}"
                            {{ $this->isLoading ? 'disabled' : '' }}
                        >
                            <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a4 4 0 11-8 0 4 4 0 018 0zm4 4l5 5m0 0l-5-5m5 5H4"/>
                            </svg>
                            Search
                        </button>
                    </div>
                    <div class="mt-2" wire:loading.remove>
                        <a href="#" class="text-gray-500" wire:click="$emit('tagClicked','o gustare pentru cei mici')">#anything</a>
                        <a href="#" class="text-gray-500 ml-2" wire:click="$emit('tagClicked','o bautura pentru zile caniculare')">#hotDayDrink</a>
                        <a href="#" class="text-gray-500 ml-2" wire:click="$emit('tagClicked','o bautura pentru zile reci si ploioase')">#coldDayDrink</a>
                        <a href="#" class="text-gray-500 ml-2" wire:click="$emit('tagClicked','o gustare simpla')">#notHungry</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if(empty($this->recipe) && !empty($this->message))
        <div class="py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                    <div class="grid grid-cols-1">
                        <div class="text-center">
                            <h2 class="text-base">{{ $this->message }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    @if(!empty($this->recipe) && empty($this->message))
        <div class="py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                    <div class="grid grid-cols-1">
                        <div class="text-center">
                            <h2 class="text-xl">{{ $this->recipe['title'] }}</h2>
                        </div>
                    </div>
                    <hr class="py-4">
                    <div class="grid grid-cols-2">
                        <div>
                            <h2 class="text-lg">Ingrediente</h2>
                            @foreach($this->recipe['ingredients'] as $ingredient)
                                <p>{{$ingredient}}</p>
                            @endforeach
                        </div>
                        <div>
                            <h2 class="text-lg">Preparare</h2>
                            <p>{!! $this->recipe['instructions'] !!}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    @if(!empty($this->recomandations))
        <div class="py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                    <div class="grid grid-cols-1">
                        <div class="text-center">
                            <h2 class="text-xl">Recomandare de cumparare</h2>
                        </div>
                        <div>
                            <p>{!! $this->recomandations  !!}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
