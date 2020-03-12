<div class="btn-group" role="group"">
    @foreach ($seasons as $season)
        <a href="{{ route('admin.ranking') . "?season=$season->id" }}" class="btn {{$season->id == $seasonId ? "btn-warning" : "btn-default"}}">{{ $season->name }}</a>    
    @endforeach
</div>