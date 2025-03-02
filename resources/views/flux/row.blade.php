@props([
    'right' => false,
    'center' => false,
])
@php
    $classes = Flux::classes('flex h-full w-full items-center flex-1');

    if ($right) {
        $classes->add('justify-end');
    }

    if ($center) {
        $classes->add('justify-center');
    }
@endphp

<div {{ $attributes->class($classes) }}>
    {{ $slot }}
</div>
