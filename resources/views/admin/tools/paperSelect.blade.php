<div class="btn-group" data-toggle="buttons">
    @foreach($options as $option => $label)
    <label class="btn btn-default btn-sm {{ \Request::get('status', 'all') == $option ? 'active btn-info' : '' }}">
        <input type="radio" class="promo-select" value="{{ $option }}">{{ ucfirst($label) }}
    </label>
    @endforeach
</div>