@props(['submit'])
@php
$hour = date('H');
$theme = ($hour >= 18 || $hour < 6) ? 'dark' : 'light' ; @endphp <x-form-section submit="updatePassword">
    <x-slot name="title">
        {{ __('Update Password') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Ensure your account is using a long, random password to stay secure.') }}
    </x-slot>

    <x-slot name="form">
        <div class="col-span-6 sm:col-span-4">
            <x-label for="current_password" value="{{ __('Current Password') }}" class="{{ $theme === 'dark' ? 'dark:text-gray-300' : 'text-gray-900' }}" />
            <x-input id="current_password" type="password" class="mt-1 block w-full {{ $theme === 'dark' ? 'dark:text-gray-300 dark:bg-gray-700 dark:border-gray-600' : 'text-gray-900 bg-gray-50 border-gray-300' }}" wire:model="state.current_password" autocomplete="current-password" />
            <x-input-error for="current_password" class="mt-2" />
        </div>

        <div class="col-span-6 sm:col-span-4">
            <x-label for="password" value="{{ __('New Password') }}" class="{{ $theme === 'dark' ? 'dark:text-gray-300' : 'text-gray-900' }}" />
            <x-input id="password" type="password" class="mt-1 block w-full {{ $theme === 'dark' ? 'dark:text-gray-300 dark:bg-gray-700 dark:border-gray-600' : 'text-gray-900 bg-gray-50 border-gray-300' }}" wire:model="state.password" autocomplete="new-password" />
            <x-input-error for="password" class="mt-2" />
        </div>

        <div class="col-span-6 sm:col-span-4">
            <x-label for="password_confirmation" value="{{ __('Confirm Password') }} " class="{{ $theme === 'dark' ? 'dark:text-gray-300' : 'text-gray-900' }}" />
            <x-input id="password_confirmation" type="password" class="mt-1 block w-full {{ $theme === 'dark' ? 'dark:text-gray-300 dark:bg-gray-700 dark:border-gray-600' : 'text-gray-900 bg-gray-50 border-gray-300' }}" wire:model="state.password_confirmation" autocomplete="new-password" />
            <x-input-error for="password_confirmation" class="mt-2" />
        </div>
    </x-slot>

    <x-slot name="actions">
        <x-action-message class="me-3" on="saved">
            {{ __('Saved.') }}
        </x-action-message>

        <x-button>
            {{ __('Save') }}
        </x-button>
    </x-slot>
    </x-form-section>
