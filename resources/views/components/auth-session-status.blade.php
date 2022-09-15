@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'font-medium text-sm text-green-800']) }}>
        {!! $status !!}
    </div>
@endif
