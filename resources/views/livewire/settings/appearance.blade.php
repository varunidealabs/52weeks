<!-- resources/views/livewire/settings/appearance.blade.php -->
<section class="w-full max-w-2xl mx-auto">
    <div class="mb-8 text-center">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">Account Settings</h1>
        <p class="text-gray-600 dark:text-gray-400">Manage your appearance preferences</p>
    </div>
    
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
        <h2 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Appearance</h2>
        <p class="text-sm text-gray-600 dark:text-gray-400 mb-6">Update the appearance settings for your account.</p>
        
        <flux:radio.group x-data variant="segmented" x-model="$flux.appearance">
            <flux:radio value="light" icon="sun">{{ __('Light') }}</flux:radio>
            <flux:radio value="dark" icon="moon">{{ __('Dark') }}</flux:radio>
            <flux:radio value="system" icon="computer-desktop">{{ __('System') }}</flux:radio>
        </flux:radio.group>
    </div>
</section>