@props([
    'sortable' => false,
    'direction' => 'asc',
    'sorted' => false,
    'align' => 'left',
])

@php
    $classes = Flux::classes(
        'py-3 px-3 first:pl-0 last:pr-0 text-sm text-zinc-800 dark:text-white',
    );
    if($sortable) {
        $classes->add('cursor-pointer');
    }
    $classes->add(match($align) {
        'left' => 'text-left',
        'center' => 'text-center',
        'right' => 'text-right',
        default => 'text-left',
    });
@endphp

<th {{ $attributes->class($classes) }}>
    <div class="flex">
        <div>
            {{ $slot }}
        </div>
        @if ($sortable)
            @if ($direction === 'desc' && $sorted)
                <div class="flex items-center justify-end">
                    <svg class="shrink-0 [:where(&amp;)]:size-4" data-flux-icon="" xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 16 16" fill="currentColor" aria-hidden="true" data-slot="icon">
                        <path fill-rule="evenodd"
                            d="M4.22 6.22a.75.75 0 0 1 1.06 0L8 8.94l2.72-2.72a.75.75 0 1 1 1.06 1.06l-3.25 3.25a.75.75 0 0 1-1.06 0L4.22 7.28a.75.75 0 0 1 0-1.06Z"
                            clip-rule="evenodd"></path>
                    </svg>
                </div>
            @endif
            @if ($direction === 'asc' && $sorted)
                <div class="flex items-center justify-end">
                    <svg class="shrink-0 [:where(&amp;)]:size-4" data-flux-icon="" xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 16 16" fill="currentColor" aria-hidden="true" data-slot="icon">
                        <path fill-rule="evenodd"
                            d="M11.78 9.78a.75.75 0 0 1-1.06 0L8 7.06 5.28 9.78a.75.75 0 0 1-1.06-1.06l3.25-3.25a.75.75 0 0 1 1.06 0l3.25 3.25a.75.75 0 0 1 0 1.06Z"
                            clip-rule="evenodd"></path>
                    </svg>
                </div>
            @endif
        @endif
    </div>
</th>
