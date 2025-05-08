<!-- resources/views/livewire/settings/password.blade.php -->
<section class="w-full max-w-2xl mx-auto">
    <div class="mb-8 text-center">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">Account Settings</h1>
        <p class="text-gray-600 dark:text-gray-400">Manage your password</p>
    </div>
    
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
        <h2 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Update Password</h2>
        <p class="text-sm text-gray-600 dark:text-gray-400 mb-6">Ensure your account is using a long, random password to stay secure.</p>
        
        <form wire:submit="updatePassword" class="space-y-6">
            <flux:input
                wire:model="current_password"
                :label="__('Current password')"
                type="password"
                required
                autocomplete="current-password"
            />
            <flux:input
                wire:model="password"
                :label="__('New password')"
                type="password"
                required
                autocomplete="new-password"
            />
            <flux:input
                wire:model="password_confirmation"
                :label="__('Confirm Password')"
                type="password"
                required
                autocomplete="new-password"
            />

            <div class="flex items-center gap-4">
                <div class="flex items-center justify-end">
                    <flux:button variant="primary" type="submit" class="bg-pink-500 hover:bg-pink-600">{{ __('Save') }}</flux:button>
                </div>

                <x-action-message class="me-3" on="password-updated">
                    {{ __('Saved.') }}
                </x-action-message>
            </div>
        </form>
    </div>
</section>