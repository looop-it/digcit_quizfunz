<div class="btn-group" data-toggle="buttons">
    @foreach($options as $option => $label)
    <label class="btn btn-default btn-sm {{ \Request::get('type_id', 'all') == $option ? 'active' : '' }}">
        <input type="radio" class="adv-select" value="{{ $option }}">{{$label}}
    </label>
    @endforeach
</div>