 {{-- 開始   除了首頁其他頁面都有 --}}
@include('home.advertisement.top-banner-mobile')
 {{-- 結束 --}}

 @if($page != 'news')
	@include('home.comm.new_first')
@endif