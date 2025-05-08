<!-- resources/views/components/settings-nav.blade.php -->
<div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-4 mb-6">
    <div class="flex flex-wrap justify-center gap-4">
        <a href="{{ route('settings.profile') }}" 
           class="px-4 py-2 rounded-lg {{ request()->routeIs('settings.profile') ? 'bg-pink-500 text-white' : 'bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600' }} transition-colors">
            Profile
        </a>
        <a href="{{ route('settings.password') }}" 
           class="px-4 py-2 rounded-lg {{ request()->routeIs('settings.password') ? 'bg-pink-500 text-white' : 'bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600' }} transition-colors">
            Password
        </a>
        <a href="{{ route('settings.appearance') }}" 
           class="px-4 py-2 rounded-lg {{ request()->routeIs('settings.appearance') ? 'bg-pink-500 text-white' : 'bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600' }} transition-colors">
            Appearance
        </a>
    </div>
</div>