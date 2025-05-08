<!-- resources/views/livewire/settings/profile.blade.php -->
<section class="w-full max-w-4xl mx-auto pt-12 pb-16 px-6"> <!-- Added better padding top and bottom -->
    <div class="mb-10"> <!-- Increased top margin for better spacing -->
        <flux:heading size="xl" level="1" class="text-center mb-3">{{ __('Account Settings') }}</flux:heading>
        <flux:subheading size="lg" class="text-center mb-8">{{ __('Manage your profile information') }}</flux:subheading>
        <flux:separator variant="subtle" class="mb-10" /> <!-- Added extra separator with margin -->
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-8 mb-10"> <!-- Added card styling with margins -->
        <flux:heading size="lg" class="mb-4">{{ __('Profile Information') }}</flux:heading>
        <flux:text class="text-gray-600 dark:text-gray-400 mb-6">{{ __('Update your account\'s profile information and email address.') }}</flux:text>

        <form wire:submit="updateProfileInformation" class="w-full space-y-6">
            <flux:input wire:model="name" :label="__('Name')" type="text" required autofocus autocomplete="name" />

            <div>
                <flux:input wire:model="email" :label="__('Email')" type="email" required autocomplete="email" />

                @if (auth()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail &&! auth()->user()->hasVerifiedEmail())
                    <div class="mt-4">
                        <flux:text>
                            {{ __('Your email address is unverified.') }}

                            <flux:link class="cursor-pointer" wire:click.prevent="resendVerificationNotification">
                                {{ __('Click here to re-send the verification email.') }}
                            </flux:link>
                        </flux:text>

                        @if (session('status') === 'verification-link-sent')
                            <flux:text class="mt-2 font-medium !text-green-600 dark:!text-green-400">
                                {{ __('A new verification link has been sent to your email address.') }}
                            </flux:text>
                        @endif
                    </div>
                @endif
            </div>

            <div class="flex items-center justify-end gap-4 pt-2">
                <x-action-message class="me-3" on="profile-updated">
                    {{ __('Saved.') }}
                </x-action-message>
                
                <flux:button variant="primary" type="submit">{{ __('Save') }}</flux:button>
            </div>
        </form>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-8">
        <flux:heading size="lg" class="mb-4 text-red-600 dark:text-red-400">{{ __('Delete Account') }}</flux:heading>
        <flux:text class="text-gray-600 dark:text-gray-400 mb-6">{{ __('Delete your account and all of its resources') }}</flux:text>

        <flux:button variant="danger" wire:click="$dispatch('open-modal', 'confirm-user-deletion')">
            {{ __('Delete Account') }}
        </flux:button>

        <flux:modal name="confirm-user-deletion" :show="$errors->isNotEmpty()" focusable>
            <form wire:submit="deleteUser" class="p-6">
                <flux:heading size="lg">{{ __('Are you sure you want to delete your account?') }}</flux:heading>

                <flux:text class="mt-4">
                    {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
                </flux:text>

                <div class="mt-6">
                    <flux:input wire:model="password" :label="__('Password')" type="password" class="mt-1 block w-full" />
                </div>

                <div class="mt-6 flex justify-end">
                    <flux:button variant="filled" wire:click="$dispatch('close')">
                        {{ __('Cancel') }}
                    </flux:button>

                    <flux:button variant="danger" type="submit" class="ms-3">
                        {{ __('Delete Account') }}
                    </flux:button>
                </div>
            </form>
        </flux:modal>
    </div>
</section>