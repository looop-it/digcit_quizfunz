<div class="btn-group" role="group"">
    @foreach ($types as $key => $value)
        <a href="{{ str_replace('_type_', $key, $url) }}" class="btn {{$key == $type ? "btn-success" : "btn-default"}} ">{{ $value }}</a>    
    @endforeach
</div>