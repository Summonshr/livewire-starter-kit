@php
    $classes = Flux::classes('flex flex-col');
@endphp
<div {{ $attributes->class($classes) }}>
    {{ $slot }}
</div>
