<div>
    <div class="bg-white rounded-lg shadow-md p-6 border border-gray-200 w-full space-y-6 mb-8">
        <!-- Section 1: Account Info (including Profile Photo) -->
        <div class="grid grid-cols-3 gap-6 items-start mb-8">
            <!-- Left Column (Titles) -->
            <div class="col-span-1">
                <h2 class="text-lg font-semibold text-gray-900">
                    {{ __('Account Information') }}
                </h2>
                <p class="text-sm text-gray-500 mt-1">
                    {{ __('Update your account\'s profile, email, and contact details.') }}
                </p>
            </div>

            <!-- Right Column (Form Fields) -->
            <div class="col-span-2 space-y-4">
                <!-- Profile Photo -->
                @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                    <div x-data="{ photoName: null, photoPreview: null }" class="flex items-center space-x-4">
                        <img src="{{ $this->user->profile_photo_url }}" alt="{{ $this->user->name }}"
                            class="rounded-full w-24 h-24 object-cover border border-gray-200 shadow">
                        <div class="space-y-2">
                            <x-secondary-button type="button" x-on:click.prevent="$refs.photo.click()">
                                {{ __('Select New') }}
                            </x-secondary-button>
                            @if ($this->user->profile_photo_path)
                                <x-secondary-button type="button" wire:click="deleteProfilePhoto"
                                    class="text-red-600 hover:text-red-800">
                                    {{ __('Remove') }}
                                </x-secondary-button>
                            @endif
                        </div>
                        <input type="file" id="photo" class="hidden" wire:model.live="photo" x-ref="photo"
                            x-on:change="
                               photoName = $refs.photo.files[0].name;
                               const reader = new FileReader();
                               reader.onload = (e) => { photoPreview = e.target.result };
                               reader.readAsDataURL($refs.photo.files[0]);
                           " />
                        <x-input-error for="photo" class="mt-2" />
                    </div>
                @endif

                <!-- Name -->
                <div>
                    <x-label for="name" value="{{ __('Full Name') }}" />
                    <x-input id="name" type="text"
                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm" wire:model="state.name" required
                        autocomplete="name" />
                    <x-input-error for="name" class="mt-2" />
                </div>

                <!-- Email -->
                <div>
                    <x-label for="email" value="{{ __('Email Address') }}" />
                    <x-input id="email" type="email"
                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm" wire:model="state.email" required
                        autocomplete="username" />
                    <x-input-error for="email" class="mt-2" />
                </div>

                <!-- Mobile -->
                <div>
                    <x-label for="mobile_number" value="{{ __('Mobile Number') }}" />
                    <x-input id="mobile_number" type="tel"
                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm" wire:model="state.mobile_number"
                        required />
                    <x-input-error for="mobile_number" class="mt-2" />
                </div>
            </div>
        </div>
    </div>

    <hr class="border-t border-gray-200 my-8">

    <div class="bg-white rounded-lg shadow-md p-6 border border-gray-200 w-full space-y-6 mt-8">
        <!-- Section 2: Personal Info -->
        <div class="grid grid-cols-3 gap-6 items-start">
            <!-- Left Column (Titles) -->
            <div class="col-span-1">
                <h2 class="text-lg font-semibold text-gray-900">
                    {{ __('Personal Information') }}
                </h2>
                <p class="text-sm text-gray-500 mt-1">
                    {{ __('Update your address, gender, and date of birth.') }}
                </p>
            </div>

            <!-- Right Column (Form Fields) -->
            <div class="col-span-2 space-y-4">
                <!-- Address -->
                <div>
                    <x-label for="address" value="{{ __('Address') }}" />
                    <x-input id="address" type="text"
                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm" wire:model="state.address" />
                    <x-input-error for="address" class="mt-2" />
                </div>

                <!-- Gender -->
                <div>
                    <x-label for="gender" value="{{ __('Gender') }}" />
                    <select id="gender" wire:model="state.gender"
                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">{{ __('-- Select Gender --') }}</option>
                        <option value="male">{{ __('Male') }}</option>
                        <option value="female">{{ __('Female') }}</option>
                        <option value="other">{{ __('Other') }}</option>
                    </select>
                    <x-input-error for="gender" class="mt-2" />
                </div>

                <!-- Date of Birth -->
                <div>
                    <x-label for="dob" value="{{ __('Date of Birth') }}" />
                    <x-input id="dob" type="date"
                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm" wire:model="state.dob"
                        max="{{ now()->toDateString() }}" />
                    <x-input-error for="dob" class="mt-2" />
                </div>

                <!-- Save Button -->
                <div class="flex justify-end mt-4">
                    <x-action-message class="me-3 text-green-600 font-medium" on="saved">
                        {{ __('Saved.') }}
                    </x-action-message>
                    <x-button wire:loading.attr="disabled" wire:target="photo" class="px-6 py-2">
                        <span wire:loading wire:target="photo" class="animate-spin mr-2">⏳</span>
                        {{ __('Save Changes') }}
                    </x-button>
                </div>
            </div>
        </div>
    </div>
</div>
