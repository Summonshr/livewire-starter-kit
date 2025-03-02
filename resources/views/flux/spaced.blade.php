@php
    $classes = Flux::classes('space-y-6');
@endphp

<div {{ $attributes->class($classes) }}>
    {{ $slot }}
</div>
