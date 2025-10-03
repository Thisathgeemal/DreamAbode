@if ($errors->any())
    @php
        \Illuminate\Support\Facades\Log::warning('Validation errors', [
            'errors' => $errors->all(),
            'ip' => request()->ip(),
        ]);
    @endphp

    <div {{ $attributes }}>
        <div class="font-medium text-red-600">{{ __('Whoops! Something went wrong.') }}</div>

        <ul class="mt-3 list-disc list-inside text-sm text-red-600">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
