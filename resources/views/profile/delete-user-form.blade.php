<div class="bg-white rounded-lg shadow-md p-6 border border-gray-200 w-full">
    <div class="grid grid-cols-3 gap-6 items-start">
        <!-- Left (1/3) -->
        <div class="col-span-1">
            <h2 class="text-lg font-semibold text-gray-900">
                {{ __('Delete Account') }}
            </h2>
            <p class="text-sm text-gray-500 mt-1">
                {{ __('Permanently delete your account and all associated data.') }}
            </p>
        </div>

        <!-- Right (2/3) -->
        <div class="col-span-2">
            <div class="flex items-center justify-between mb-4">
                <span class="px-3 py-1 text-xs font-medium text-red-600 bg-red-100 rounded-full">
                    {{ __('Danger Zone') }}
                </span>
            </div>

            <p class="text-sm text-gray-600 mb-6">
                {{ __('Once your account is deleted, all of its resources and data will be permanently deleted.
                                                                                                                                Please download any information that you wish to retain before proceeding.') }}
            </p>

            <div class="flex justify-end">
                <x-danger-button wire:click="confirmUserDeletion" wire:loading.attr="disabled">
                    {{ __('Delete Account') }}
                </x-danger-button>
            </div>
        </div>
    </div>

    <!-- Delete User Confirmation Modal -->
    <x-dialog-modal wire:model.live="confirmingUserDeletion">
        <x-slot name="title">
            {{ __('Delete Account') }}
        </x-slot>

        <x-slot name="content">
            <p class="text-sm text-gray-600 mb-4">
                {{ __('Are you sure you want to delete your account? Once deleted, all data will be permanently removed.
                                                                                                                                Enter your password to confirm.') }}
            </p>

            <div class="mt-2" x-data="{}"
                x-on:confirming-delete-user.window="setTimeout(() => $refs.password.focus(), 250)">
                <x-input type="password"
                    class="mt-1 block w-full rounded-lg border-gray-300 focus:border-red-500 focus:ring-red-500"
                    autocomplete="current-password" placeholder="{{ __('Password') }}" x-ref="password"
                    wire:model="password" wire:keydown.enter="deleteUser" />

                <x-input-error for="password" class="mt-2" />
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$toggle('confirmingUserDeletion')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-secondary-button>

            <x-danger-button class="ms-3" wire:click="deleteUser" wire:loading.attr="disabled">
                {{ __('Delete Account') }}
            </x-danger-button>
        </x-slot>
    </x-dialog-modal>
</div>
