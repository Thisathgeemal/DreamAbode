<div class="bg-white rounded-lg shadow-md p-6 border border-gray-200 w-full">
    <div class="grid grid-cols-3 gap-6 items-start">
        <!-- Left (1/3) -->
        <div class="col-span-1">
            <h2 class="text-lg font-semibold text-gray-900">
                {{ __('Update Password') }}
            </h2>
            <p class="text-sm text-gray-500 mt-1">
                {{ __('Ensure your account is using a long, random password to stay secure.') }}
            </p>
        </div>

        <!-- Right (2/3) -->
        <div class="col-span-2">
            <form wire:submit.prevent="updatePassword" class="space-y-6">
                <div>
                    <x-label for="current_password" value="{{ __('Current Password') }}" />
                    <x-input id="current_password" type="password"
                        class="mt-1 block w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring-green-500"
                        wire:model="state.current_password" autocomplete="current-password" />
                    <x-input-error for="current_password" class="mt-2" />
                </div>

                <div>
                    <x-label for="password" value="{{ __('New Password') }}" />
                    <x-input id="password" type="password"
                        class="mt-1 block w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring-green-500"
                        wire:model="state.password" autocomplete="new-password" />
                    <x-input-error for="password" class="mt-2" />
                </div>

                <div>
                    <x-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
                    <x-input id="password_confirmation" type="password"
                        class="mt-1 block w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring-green-500"
                        wire:model="state.password_confirmation" autocomplete="new-password" />
                    <x-input-error for="password_confirmation" class="mt-2" />
                </div>

                <div class="flex justify-end items-center gap-3 pt-4">
                    <x-action-message on="saved" class="text-green-600">
                        {{ __('Saved.') }}
                    </x-action-message>
                    <x-button type="submit" wire:loading.attr="disabled">
                        {{ __('Save') }}
                    </x-button>
                </div>
            </form>
        </div>
    </div>
</div>
