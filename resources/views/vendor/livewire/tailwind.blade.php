@php
if (! isset($scrollTo)) {
    $scrollTo = 'body';
}

$scrollIntoViewJsSnippet = ($scrollTo !== false)
    ? <<<JS
       (\$el.closest('{$scrollTo}') || document.querySelector('{$scrollTo}')).scrollIntoView()
    JS
    : '';
@endphp

<div>
    @if ($paginator->hasPages())
        <div class="flex justify-center mt-6">
            <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center space-x-2">
                
                {{-- Previous Page --}}
                @if ($paginator->onFirstPage())
                    <span class="px-3 py-1 rounded-lg bg-gray-200 text-gray-500 cursor-not-allowed">
                        Prev
                    </span>
                @else
                    <button wire:click="previousPage" wire:loading.attr="disabled"
                        class="px-3 py-1 rounded-lg bg-white border border-gray-300 hover:bg-gray-100">
                        Prev
                    </button>
                @endif

                {{-- Page Numbers --}}
                @foreach ($elements as $element)
                    @if (is_string($element))
                        <span class="px-3 py-1 text-gray-500">...</span>
                    @endif

                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <span class="px-3 py-1 rounded-lg bg-[#5CFFAB] text-black font-bold">
                                    {{ $page }}
                                </span>
                            @else
                                <button wire:click="gotoPage({{ $page }})"
                                    class="px-3 py-1 rounded-lg bg-white border border-gray-300 hover:bg-gray-100">
                                    {{ $page }}
                                </button>
                            @endif
                        @endforeach
                    @endif
                @endforeach

                {{-- Next Page --}}
                @if ($paginator->hasMorePages())
                    <button wire:click="nextPage" wire:loading.attr="disabled"
                        class="px-3 py-1 rounded-lg bg-white border border-gray-300 hover:bg-gray-100">
                        Next
                    </button>
                @else
                    <span class="px-3 py-1 rounded-lg bg-gray-200 text-gray-500 cursor-not-allowed">
                        Next
                    </span>
                @endif
            </nav>
        </div>
    @endif
</div>
