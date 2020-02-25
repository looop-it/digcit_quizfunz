<div class="col-md-2 col-xs-6">
    <div {!! $attributes !!}>
        <div class="inner">
            {{-- <h3>{{ $info }}</h3> --}}

            <h4>{{ $name }}</h4>
        </div>
        {{-- <div class="icon">
            <i class="fa fa-{{ $icon }}"></i>
        </div> --}}
        <a href="{{ $link }}" class="small-box-footer">
            <button class="btn btn-default btn-sm">{{ $action }}&nbsp;
            <i class="fa fa-hand-pointer-o"></i></button>
        </a>
    </div>
</div>