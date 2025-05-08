<!-- resources/views/livewire/dashboard/life-calendar.blade.php -->
<div class="w-full max-w-full px-4">
    @if (session()->has('message'))
        <div class="mb-4 p-4 bg-green-100 dark:bg-green-900 rounded-lg text-center">
            {{ session('message') }}
        </div>
    @endif

    <!-- Calendar Grid -->
    <div class="grid grid-cols-[repeat(52,12px)] gap-[2px] mx-auto max-w-fit">
        @foreach($weeks as $week)
            <div 
                wire:click="openWeek({{ $week['week'] }}, {{ $week['year'] }})"
                class="calendar-box w-3 h-3 rounded-sm cursor-pointer hover:scale-110
                       {{ $week['status'] === 'future' ? 'bg-gray-100 dark:bg-gray-700 border-2 border-gray-400 dark:border-gray-500' : '' }}
                       {{ $week['status'] === 'no-journal' ? 'bg-gray-400 dark:bg-gray-500 border-2 border-gray-600 dark:border-gray-400' : '' }}
                       {{ $week['status'] === 'good' ? 'bg-green-500 dark:bg-green-600 border-2 border-green-700 dark:border-green-500' : '' }}
                       {{ $week['status'] === 'average' ? 'bg-yellow-500 dark:bg-yellow-600 border-2 border-yellow-700 dark:border-yellow-500' : '' }}
                       {{ $week['status'] === 'bad' ? 'bg-red-500 dark:bg-red-600 border-2 border-red-700 dark:border-red-500' : '' }}
                       {{ $week['status'] === 'current' ? 'bg-black dark:bg-white border-2 border-black dark:border-white' : '' }}"
                title="Week {{ $week['week'] }}, {{ $week['year'] }}"
            ></div>
        @endforeach
    </div>
    
    <!-- Legend -->
    <div class="flex justify-center flex-wrap gap-6 mt-8">
        <div class="flex items-center gap-2">
            <div class="w-3 h-3 bg-gray-400 dark:bg-gray-500 rounded-sm border-2 border-gray-600 dark:border-gray-400"></div>
            <span class="text-sm text-gray-600 dark:text-gray-400">Initial weeks</span>
        </div>
        <div class="flex items-center gap-2">
            <div class="w-3 h-3 bg-green-500 dark:bg-green-600 rounded-sm border-2 border-green-700 dark:border-green-500"></div>
            <span class="text-sm text-gray-600 dark:text-gray-400">Good week</span>
        </div>
        <div class="flex items-center gap-2">
            <div class="w-3 h-3 bg-yellow-500 dark:bg-yellow-600 rounded-sm border-2 border-yellow-700 dark:border-yellow-500"></div>
            <span class="text-sm text-gray-600 dark:text-gray-400">Average week</span>
        </div>
        <div class="flex items-center gap-2">
            <div class="w-3 h-3 bg-red-500 dark:bg-red-600 rounded-sm border-2 border-red-700 dark:border-red-500"></div>
            <span class="text-sm text-gray-600 dark:text-gray-400">Difficult week</span>
        </div>
        <div class="flex items-center gap-2">
            <div class="w-3 h-3 bg-black dark:bg-white rounded-sm border-2 border-black dark:border-white"></div>
            <span class="text-sm text-gray-600 dark:text-gray-400">Current week</span>
        </div>
        <div class="flex items-center gap-2">
            <div class="w-3 h-3 bg-gray-100 dark:bg-gray-700 rounded-sm border-2 border-gray-400 dark:border-gray-500"></div>
            <span class="text-sm text-gray-600 dark:text-gray-400">Future weeks</span>
        </div>
    </div>

    <!-- Journal Reader Modal -->
    @if($selectedJournal)
        <div class="fixed inset-0 bg-black/50 dark:bg-black/70 flex items-center justify-center z-50 p-4 animate-fade-in">
            <div class="bg-white dark:bg-gray-800 rounded-lg max-w-2xl w-full p-6 shadow-lg animate-scale-in">
                <h2 class="text-xl font-medium text-gray-900 dark:text-gray-100 mb-4">
                    {{ $selectedJournal->title }}
                </h2>
                <div class="prose dark:prose-invert max-w-none">
                    <p class="text-gray-700 dark:text-gray-300 whitespace-pre-wrap">{{ $selectedJournal->description }}</p>
                </div>
                <div class="mt-6 flex justify-end">
                    <button wire:click="closeJournal" 
                            class="px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 hover:border-gray-400 dark:hover:border-gray-500 text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-gray-100 transition-colors cursor-pointer">
                        Close
                    </button>
                </div>
            </div>
        </div>
    @endif

    <!-- Message for Future Weeks -->
    @if(session()->has('futureMessage'))
        <div id="futureMessage" class="fixed inset-0 bg-black/50 dark:bg-black/70 flex items-center justify-center z-50 p-4 animate-fade-in">
            <div class="bg-white dark:bg-gray-800 rounded-lg max-w-md w-full p-6 shadow-lg animate-scale-in">
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-2">Not Available Yet</h3>
                <p class="text-gray-600 dark:text-gray-300">{{ session('futureMessage') }}</p>
                <div class="mt-4 flex justify-end">
                    <button 
                        wire:click="dismissMessage"
                        class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg transition-colors">
                        OK
                    </button>
                </div>
            </div>
        </div>
    @endif

    <!-- Message for Past Weeks with No Journal -->
    @if(session()->has('pastMessage'))
        <div id="pastMessage" class="fixed inset-0 bg-black/50 dark:bg-black/70 flex items-center justify-center z-50 p-4 animate-fade-in">
            <div class="bg-white dark:bg-gray-800 rounded-lg max-w-md w-full p-6 shadow-lg animate-scale-in">
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-2">No Entry Found</h3>
                <p class="text-gray-600 dark:text-gray-300">{{ session('pastMessage') }}</p>
                <div class="mt-4 flex justify-end">
                    <button 
                        wire:click="dismissMessage"
                        class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg transition-colors">
                        OK
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>