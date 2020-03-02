 {{-- 開始   除了首頁其他頁面都有 --}}
@include('home.advertisement.top-banner-mobile')
 {{-- 結束 --}}
{{-- 手機版參加人數,要判斷是pc還是手機 --}}
{{-- @if($global->total_number > 0)
<div class="partake middle-partake">
	<div>
		<h2>{{trans('home.header.total_participants')}}</h2>
		<div class="js-box box">

		</div>
	</div>
</div>
@endif --}}

@include('home.comm.new_first')