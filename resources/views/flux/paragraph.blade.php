@php
    $classes = Flux::classes('p-6');
@endphp

<p {{ $attributes->class($classes) }}>
    {{ $slot }}
</p>
