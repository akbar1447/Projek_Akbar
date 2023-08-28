<a id="{{$id}}" {{ $attributes->merge(['class' => $class]) }}>
    @isset($icon) <i class="{{ $icon }}"></i>@endisset
    @isset($label) &nbsp; {{ $label }} @endisset
</a>    