<div>
    <x-form-section submit="updateProfileInformation">
        <!-- Section 1: Account Info -->
        <x-slot name="title">
            {{ __('Account Information') }}
        </x-slot>

        <x-slot name="description">
            {{ __('Update your account\'s profile, email, and contact details.') }}
        </x-slot>

        <x-slot name="form">
            <!-- Profile Photo -->
            @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                <div x-data="{ photoName: null, photoPreview: null }" class="col-span-6 sm:col-span-4">
                    <!-- Profile Photo File Input -->
                    <input type="file" id="photo" class="hidden" wire:model.live="photo" x-ref="photo"
                        x-on:change="
                                    photoName = $refs.photo.files[0].name;
                                    const reader = new FileReader();
                                    reader.onload = (e) => {
                                        photoPreview = e.target.result;
                                    };
                                    reader.readAsDataURL($refs.photo.files[0]);
                            " />

                    <x-label for="photo" value="{{ __('Photo') }}" />

                    <!-- Current Profile Photo -->
                    <div class="mt-2" x-show="! photoPreview">
                        @if (Auth::user()->profile_photo_path)
                            <img src="{{ asset('storage/' . Auth::user()->profile_photo_path) }}"
                                alt="{{ $this->user->name }}" class="rounded-full h-[100px] w-[100px] object-cover" />
                        @else
                            <img src="{{ Auth::user()->profile_photo_url }}" alt="{{ $this->user->name }}"
                                class="rounded-full h-[100px] w-[100px] object-cover" />
                        @endif
                    </div>

                    <!-- New Profile Photo Preview -->
                    <div class="mt-2" x-show="photoPreview" style="display: none;">
                        <span class="block rounded-full h-[100px] w-[100px] bg-cover bg-no-repeat bg-center"
                            x-bind:style="'background-image: url(\'' + photoPreview + '\');'">
                        </span>
                    </div>

                    <x-secondary-button class="mt-2 me-2" type="button" x-on:click.prevent="$refs.photo.click()">
                        {{ __('Select A New Photo') }}
                    </x-secondary-button>

                    @if ($this->user->profile_photo_path)
                        <x-secondary-button type="button" class="mt-2" wire:click="deleteProfilePhoto">
                            {{ __('Remove Photo') }}
                        </x-secondary-button>
                    @endif

                    <x-input-error for="photo" class="mt-2" />
                </div>
            @endif

            <!-- Name -->
            <div>
                <x-label for="name" value="{{ __('Full Name') }}" />
                <x-input id="name" type="text" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm"
                    wire:model="state.name" required autocomplete="name" />
                <x-input-error for="name" class="mt-2" />
            </div>

            <!-- Email -->
            <div>
                <x-label for="email" value="{{ __('Email Address') }}" />
                <x-input id="email" type="email" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm"
                    wire:model="state.email" required autocomplete="username" />
                <x-input-error for="email" class="mt-2" />

                <!-- Email Verification -->
                @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::emailVerification()) &&
                        !$this->user->hasVerifiedEmail())
                    <p class="text-sm mt-2 text-gray-800">
                        {{ __('Your email address is unverified.') }}

                        <button type="button"
                            class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                            wire:click.prevent="sendEmailVerification">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if ($this->verificationLinkSent)
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                @endif
            </div>

        </x-slot>

        <x-slot name="actions">
            <x-action-message class="me-3 text-green-600 font-medium" on="saved">
                {{ __('Saved.') }}
            </x-action-message>
            <x-button wire:loading.attr="disabled" wire:target="photo" class="px-6 py-2">
                <span wire:loading wire:target="photo" class="animate-spin mr-2">⏳</span>
                {{ __('Save Changes') }}
            </x-button>
        </x-slot>
    </x-form-section>

    <hr class="border-t border-gray-200 my-8">

    <x-form-section submit="updateProfileInformation">
        <!-- Section 2: Personal Info -->
        <x-slot name="title">
            {{ __('Personal Information') }}
        </x-slot>

        <x-slot name="description">
            {{ __('Update your address, gender, and date of birth.') }}
        </x-slot>

        <x-slot name="form">
            <!-- Mobile -->
            <div>
                <x-label for="mobile_number" value="{{ __('Mobile Number') }}" />
                <x-input id="mobile_number" type="tel"
                    class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm" wire:model="state.mobile_number"
                    required />
                <x-input-error for="mobile_number" class="mt-2" />
            </div>

            <!-- Address -->
            <div>
                <x-label for="address" value="{{ __('Address') }}" />
                <x-input id="address" type="text" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm"
                    wire:model="state.address" />
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
                <x-input id="dob" type="date" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm"
                    wire:model="state.dob" max="{{ now()->toDateString() }}" />
                <x-input-error for="dob" class="mt-2" />
            </div>
        </x-slot>

        <x-slot name="actions">
            <x-action-message class="me-3 text-green-600 font-medium" on="saved">
                {{ __('Saved.') }}
            </x-action-message>
            <x-button class="px-6 py-2">
                {{ __('Save Changes') }}
            </x-button>
        </x-slot>
    </x-form-section>
</div>
