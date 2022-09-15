@props(['errors'])

@if (count($errors))
    <div>
        <ul class="mt-3 list-disc list-inside text-sm text-red-600">
            @foreach ($errors as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
