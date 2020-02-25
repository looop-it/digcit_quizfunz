<div class="btn-group" data-toggle="buttons">
    @foreach($options as $option => $label)
    <label class="btn btn-default btn-sm {{ \Request::get('feature_id', 'all') == $option ? 'active' : '' }}">
        <input type="radio" class="promo-select" value="{{ $option }}">{{$label}}
    </label>
    @endforeach
</div>