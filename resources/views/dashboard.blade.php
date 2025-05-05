<!-- resources/views/dashboard.blade.php -->
<x-layouts.app-simple>
    <div class="w-full min-h-screen bg-white dark:bg-gray-900 transition-colors">
        <!-- Top Bar -->
        <div class="w-full px-6 py-4 flex justify-end gap-4 border-b border-gray-200 dark:border-gray-700">
            <a href="{{ route('settings.profile') }}" 
               class="px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 hover:border-gray-400 dark:hover:border-gray-500 text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-gray-100 transition-colors cursor-pointer">
                Settings
            </a>
            <form method="POST" action="{{ route('logout') }}" class="inline">
                @csrf
                <button type="submit" 
                        class="px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 hover:border-gray-400 dark:hover:border-gray-500 text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-gray-100 transition-colors cursor-pointer">
                    Logout
                </button>
            </form>
        </div>

        <!-- Main Content - Centered -->
        <div class="flex flex-col items-center justify-start py-10 px-4">
            <h1 class="text-2xl font-medium text-gray-900 dark:text-gray-100 mb-8 text-center">Your Weekly Reflections</h1>
            
            <!-- Life Calendar Grid -->
            <livewire:dashboard.life-calendar />
        </div>
    </div>
</x-layouts.app-simple>