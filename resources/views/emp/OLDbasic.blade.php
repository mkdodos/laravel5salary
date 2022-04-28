


@foreach(json_decode($rows, true) as $key => $value)
    {{ $key }} - {{ $value }}, 
@endforeach

