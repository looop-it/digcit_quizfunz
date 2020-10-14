<div class="col-md-6 col-sm-6 col-xs-12 ">
    <div class="ranking-block">
        <h4>{{ $title }}</h4>
        <ul class="clearfix">
            @if ($ranks)
                @foreach ($ranks as $rank)
                    <li>
                        <div>{{ $loop->iteration }}</div>

                        @if ($type == 'weekly')
                        <div>{{ $rank->participant->name }} ({{ $rank->participant->school->name }})</div>
                        <div>{{ $rank->score }}分</div>
                        @elseif($type == 'participation')
                        <div><span title="{{ $rank->name }}">{{ $rank->name }}</span></div>
                        <div>{{ $rank->participants }}</div>
                        @else
                        <div><span title="{{ $rank->name }}">{{ $rank->name }}</span></div>
                        <div>{{ $rank->score ?? "0" }}分</div>
                        @endif
                        
                        
                    </li>
                    @break($loop->iteration == 10)
                @endforeach
            @else
                <li>
                    <div></div>
                    <div>{{trans('home.rank.msg')}}</div>
                    <div></div>
                </li>
            @endif
        </ul>
    </div>
</div>
