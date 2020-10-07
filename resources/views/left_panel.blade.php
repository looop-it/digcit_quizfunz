@php
$showNews = isset($showNews) ? $showNews : true;
$showReference = isset($showReference) ? $showReference : true;
@endphp

@if (! Agent::isMobile() || Agent::isTablet())
<div class="col-md-4 col-sm-12">
    @if ($showNews)
    <div class="row mb-3">
        <div class="col-xs-12">
            @include('home.comm.latest_news')
        </div>
    </div>
    @endif

    @if ($showReference)
    <div class="row">
        <div class="col-xs-12">
            @include('home.comm.referenceMaterial')
        </div>
    </div>
    @endif
</div>
@endif