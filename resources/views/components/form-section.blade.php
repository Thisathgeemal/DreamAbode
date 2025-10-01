@props(['submit'])

<div {{ $attributes->merge(['class' => 'w-full']) }}>
    <form wire:submit="{{ $submit }}" class="space-y-8">
        <div class="bg-white rounded-lg shadow-md p-6 border border-gray-200 w-full space-y-6">
            <div class="grid grid-cols-3 gap-6 items-start">

                <!-- Left Column (Titles) -->
                <div class="col-span-1">
                    @if (isset($title))
                        <h2 class="text-lg font-semibold text-gray-900">
                            {{ $title }}
                        </h2>
                    @endif
                    @if (isset($description))
                        <p class="text-sm text-gray-500 mt-1">
                            {{ $description }}
                        </p>
                    @endif
                </div>

                <!-- Right Column (Form Fields) -->
                <div class="col-span-2 space-y-4">
                    {{ $form }}

                    @if (isset($actions))
                        <div class="flex justify-end mt-4">
                            {{ $actions }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </form>
</div>
